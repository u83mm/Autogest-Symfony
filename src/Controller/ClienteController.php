<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\BuscaCliente;
use App\Form\Cliente\ClienteType;
use App\Form\AbreviaType;
use App\Form\Cliente\BuscaClienteType;
use App\Repository\ClienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/cliente')]
class ClienteController extends AbstractController
{	    
	public function __construct(
        private Security $security, 
        private \Doctrine\Persistence\ManagerRegistry $managerRegistry)
	{}
	
    #[Route('/', name: 'cliente_index', methods: ['GET'])]
    public function index(ClienteRepository $clienteRepository, Request $request): Response
    {    			
    	$offset = max(0, $request->query->getInt('offset', 0));
    	$paginator = $clienteRepository->getClientPaginator($offset);
    	
    	// Cálcula el valor a asignar a la variable $last para ir al último registro del listado    	    	    	
    	$last = $clienteRepository->getLast($paginator);    	
    	
        return $this->render('cliente/index.html.twig', [            
            'clientes' => $paginator,
            'previous' => $offset - ClienteRepository::PAGINATOR_PER_PAGE,
            'next'     => min(count($paginator), $offset + ClienteRepository::PAGINATOR_PER_PAGE),
            'desde'    => $offset + 1,
            'last'     => $last,
        ]);
    }

    #[Route('/new', name: 'cliente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ValidatorInterface $validator): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para acceder.');
			return $this->redirectToRoute('main_menu');
		}
		
        $cliente = new Cliente();
        $cliente->setFechaAlta(new \DateTime());                                    	
        $form = $this->createForm(ClienteType::class, $cliente);
        $abrev = $this->createForm(AbreviaType::class);         
        $form->handleRequest($request); 
        $abrev->handleRequest($request);                
        
        // maneja posibles errores        
        $errors = $validator->validate($cliente);
        
        if (count($errors) > 0) {
        		$errorsString = (string) $errors;
        		
				return $this->render('cliente/new.html.twig', [
					'errors'  => $errors,
					'cliente' => $cliente,
					'form'    => $form->createView(),
					'abrev'   => $abrev, 
				]);								
        }                                 

        if ($form->isSubmitted() && $form->isValid()) {        	         	      	                              	     	     	
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($cliente);
            $entityManager->flush();
            
            // muestra mensaje
        	$this->addFlash(
		        'notice',
		        'Se ha creado el cliente!'
		    ); 

            return $this->redirectToRoute('cliente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cliente/new.html.twig', [
            'cliente' => $cliente,
            'form' 	  => $form,
            'abrev'   => $abrev,           
        ]);
    }
    
    #[Route('/search', name: 'client_search', methods: ['GET', 'POST'])]
	public function search(Request $request, ClienteRepository $clienteRepository, ValidatorInterface $validator): Response
    {
    	$buscaCliente = new BuscaCliente();		
    	$form = $this->createForm(BuscaClienteType::class, $buscaCliente);       
        $form->handleRequest($request);
        
       /* // maneja los posibles errores de validación al enviar el formulario
        $errors = $validator->validate($buscaCliente);
                        
        if(count($errors) > 0) {
    		$errorsString = (string) $errors;
    		$this->addFlash('warning', 'Debes rellenar los campos.');        		
			return $this->render('cliente/search.html.twig', [					
				//'errors' => $errors,
				'busca' => $buscaCliente,					
				'form' => $form->createView(),					
			]);								
        }    */           
                        
        if ($form->isSubmitted()) {
        	// Si no se han rellenado alguno de los campos del formulario arroja una aviso
		    if($buscaCliente->getSelecciona() == "" || $buscaCliente->getValor() == "") {
		    	$this->addFlash('warning', 'Debes rellenar los campos.');
		    	return $this->render('cliente/search.html.twig', [										
					'busca' => $buscaCliente,					
					'form'  => $form->createView(),					
				]);	
		    }
                	        	
        	$campo = $buscaCliente->getSelecciona();
        	$valor = $buscaCliente->getValor();           	        	        	        	     	        	       	        	
        	
        	$offset = max(0, $request->query->getInt('offset', 0));
    		$paginator = $clienteRepository->findByFieldValue($offset, $campo, $valor);        	        	
        	
        	if(count($paginator) > 0) {        		       		        		        		
        		return $this->render('cliente/search_result.html.twig', [				  				   
				    'clients'  => $paginator,
				    'previous' => $offset - ClienteRepository::PAGINATOR_PER_PAGE,
				    'next'     => min(count($paginator), $offset + ClienteRepository::PAGINATOR_PER_PAGE),
				    'desde'    => $offset + 1,
				    'campo'    => $campo,
				    'valor'    => $valor
				]);
        	}
        	else {
        		return $this->render('cliente/search_result.html.twig', [				  				   
				    'clients'  => '',
				    'previous' => $offset - ClienteRepository::PAGINATOR_PER_PAGE,
				    'next'     => min(count($paginator), $offset + ClienteRepository::PAGINATOR_PER_PAGE),
				    'desde'    => $offset + 1,
				    'campo'    => $campo,
				    'valor'    => $valor
				]);
        	}
        }
        
    	return $this->render('cliente/search.html.twig', [           
            'form' => $form,                 
        ]);                
    }
    
    #[Route('/search/results', name: 'client_search_results', methods: ['GET'])]
    public function searchResults(ClienteRepository $clienteRepository, Request $request): Response
    {    	        
    	$campo = $request->query->get('campo');
    	$valor = $request->query->get('valor'); 
        	
    	$offset = max(0, $request->query->getInt('offset', 0));
    	$paginator = $clienteRepository->findByFieldValue($offset, $campo, $valor);
    	
        return $this->render('cliente/search_result.html.twig', [           
            'clients'  => $paginator,
            'previous' => $offset - ClienteRepository::PAGINATOR_PER_PAGE,
            'next'     => min(count($paginator), $offset + ClienteRepository::PAGINATOR_PER_PAGE),
            'desde'    => $offset + 1,
            'campo'    => $campo,
		    'valor'    => $valor
        ]);
    }  

    #[Route('/{id}', name: 'cliente_show', methods: ['GET'])]
    public function show(Cliente $cliente): Response
    {    			
        return $this->render('cliente/show.html.twig', [
            'cliente' => $cliente,
        ]);
    }

    #[Route('/{id}/edit', name: 'cliente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cliente $cliente, ValidatorInterface $validator): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para editar el perfil.');
			return $this->redirectToRoute('cliente_show', ['id' => $cliente->getId()]);
		}
		
        $form = $this->createForm(ClienteType::class, $cliente);       
        $form->handleRequest($request);
        $abrev = $this->createForm(AbreviaType::class);
        $abrev->handleRequest($request);
        
        // maneja posibles errores        
        $errors = $validator->validate($cliente);
        
        if (count($errors) > 0) {
        		$errorsString = (string) $errors;
        		
				return $this->render('cliente/new.html.twig', [
					'errors'  => $errors,
					'cliente' => $cliente,
					'form'    => $form->createView(),
				]);								
        }                                         

        if ($form->isSubmitted() && $form->isValid()) {            	     	     	        	
            $this->managerRegistry->getManager()->flush();
            
            // muestra mensaje
        	$this->addFlash(
		        'notice',
		        'Los cambios han sido guardados!'
		    ); 

            return $this->redirectToRoute('cliente_show', ['id' => $cliente->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cliente/edit.html.twig', [
            'cliente' => $cliente,
            'form' 	  => $form,
            'abrev'   => $abrev,            
        ]);
    }

    #[Route('/{id}', name: 'cliente_delete', methods: ['POST'])]
    public function delete(Request $request, Cliente $cliente): Response
    {
    	// Crea restricción si no se es administrador
    	if(!$this->security->isGranted('ROLE_ADMIN')) {
			$this->addFlash('warning', 'Debes ser administrador para ejecutar la acción.');
			return $this->redirectToRoute('cliente_show', ['id' => $cliente->getId()]);
		}
		
        if ($this->isCsrfTokenValid('delete'.$cliente->getId(), $request->request->get('_token'))) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->remove($cliente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cliente_index', [], Response::HTTP_SEE_OTHER);
    }
}
