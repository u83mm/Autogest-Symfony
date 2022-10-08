<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Stock;
use App\Entity\BuscaProducto;
use App\Form\Producto\ProductoType;
use App\Form\Producto\BuscaProductoType;
use App\Repository\ProductoRepository;
use App\Repository\MarcaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/producto')]
class ProductoController extends AbstractController
{
    #[Route('/', name: 'producto_index', methods: ['GET'])]
    public function index(ProductoRepository $productoRepository, MarcaRepository $marcaRepository, Request $request): Response
    {
    	$offset = max(0, $request->query->getInt('offset', 0));
    	$paginator = $productoRepository->getProductPaginator($offset);
    	
    	// Obtiene todas las marcas de la tabla "marcas" para pasarlas al index.html.twig
    	$marcas = $marcaRepository->findAll(); 
    	
        return $this->render('producto/index.html.twig', [
            //'productos' => $productoRepository->findAll(),
            'productos' => $paginator,
            'previous' => $offset - ProductoRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ProductoRepository::PAGINATOR_PER_PAGE),
            'desde' => $offset + 1,
            'marcas' => $marcas, 
        ]);
    }

    #[Route('/new', name: 'producto_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $producto = new Producto();
        $stock = new Stock();
        
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);                

        if ($form->isSubmitted() && $form->isValid()) {
        	// crea una entrada en la tabla stock
        	$stock->setAlmacen(1);
        	$stock->setMarca($producto->getMarca());
        	$stock->setReferencia($producto->getReferencia());
        	$stock->setCantidad(0);
        	$stock->setProducto($producto);
        	
        	// guarda los objetos
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($producto);
            $entityManager->persist($stock);
            $entityManager->flush();

            return $this->redirectToRoute('producto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('producto/new.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }
    
    #[Route('/search', name: 'producto_search', methods: ['GET', 'POST'])]
	public function search(Request $request, ProductoRepository $productoRepository, MarcaRepository $marcaRepository, ValidatorInterface $validator): Response
    {
    	$buscaProducto = new BuscaProducto();		
    	$form = $this->createForm(BuscaProductoType::class, $buscaProducto);       
        $form->handleRequest($request);
        
        // Obtiene todas las marcas de la tabla "marcas" para pasarlas al index.html.twig
    	$marcas = $marcaRepository->findAll();  
        
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
		    if($buscaProducto->getSelecciona() == "" || $buscaProducto->getValor() == "") {
		    	$this->addFlash('warning', 'Debes rellenar los campos.');
		    	return $this->render('producto/search.html.twig', [										
					'busca' => $buscaProducto,					
					'form' => $form->createView(),					
				]);	
		    }
                	        	
        	$campo = $buscaProducto->getSelecciona();
        	$valor = $buscaProducto->getValor();           	        	        	        	     	        	       	        	
        	
        	$offset = max(0, $request->query->getInt('offset', 0));
    		$paginator = $productoRepository->findByFieldValue($offset, $campo, $valor);        	        	
        	
        	if(count($paginator) > 0) {        		       		        		        		
        		return $this->render('producto/search_result.html.twig', [				  				   
				    'products' => $paginator,
				    'previous' => $offset - ProductoRepository::PAGINATOR_PER_PAGE,
				    'next' => min(count($paginator), $offset + ProductoRepository::PAGINATOR_PER_PAGE),
				    'desde' => $offset + 1,
				    'campo' => $campo,
				    'valor' => $valor,
				    'marcas' => $marcas
				]);
        	}
        	else {
        		return $this->render('producto/search_result.html.twig', [				  				   
				    'products' => '',
				    'previous' => $offset - ProductoRepository::PAGINATOR_PER_PAGE,
				    'next' => min(count($paginator), $offset + ProductoRepository::PAGINATOR_PER_PAGE),
				    'desde' => $offset + 1,
				    'campo' => $campo,
				    'valor' => $valor
				]);
        	}
        }
        
    	return $this->renderForm('producto/search.html.twig', [           
            'form' => $form,                 
        ]);                
    }
    
    #[Route('/search/results', name: 'producto_search_results', methods: ['GET'])]
    public function searchResults(ProductoRepository $productoRepository, MarcaRepository $marcaRepository, Request $request): Response
    {    	        
    	$campo = $request->query->get('campo');
    	$valor = $request->query->get('valor');
    	
    	// Obtiene todas las marcas de la tabla "marcas" para pasarlas al index.html.twig
    	$marcas = $marcaRepository->findAll();     	    	
        	
    	$offset = max(0, $request->query->getInt('offset', 0));
    	$paginator = $productoRepository->findByFieldValue($offset, $campo, $valor);
    	
        return $this->render('producto/search_result.html.twig', [           
            'products' => $paginator,
            'previous' => $offset - ProductoRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ProductoRepository::PAGINATOR_PER_PAGE),
            'desde' => $offset + 1,
            'campo' => $campo,
		    'valor' => $valor,
		    'marcas' => $marcas		   
        ]);
    }  

    #[Route('/{id}', name: 'producto_show', methods: ['GET'])]
    public function show(Producto $producto): Response
    {
        return $this->render('producto/show.html.twig', [
            'producto' => $producto,
        ]);
    }

    #[Route('/{id}/edit', name: 'producto_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Producto $producto, Stock $stock): Response
    {
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	// actualiza la tabla stock
        	$stock->setAlmacen(1);
        	$stock->setMarca($producto->getMarca());
        	$stock->setReferencia($producto->getReferencia());
        	$stock->setCantidad(0);
        	$stock->setProducto($producto);
        	
            $this->getDoctrine()->getManager()->flush();
            
            $this->addFlash(
		        'notice',
		        'El artículo ha sido actualizado!'
		    );

            return $this->redirectToRoute('producto_show', ['id' => $producto->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('producto/edit.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'producto_delete', methods: ['POST'])]
    public function delete(Request $request, Producto $producto): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($producto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('producto_index', [], Response::HTTP_SEE_OTHER);
    }        
}
