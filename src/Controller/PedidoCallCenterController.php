<?php

namespace App\Controller;

use App\Entity\PedidoCallCenter;
use App\Entity\Cliente;
use App\Entity\BuscaPedido;
use App\Entity\PedidoItems;
use App\Form\Pedido\PedidoCallCenterType;
use App\Form\Pedido\PedidoIntroCifType;
use App\Form\Pedido\BuscaPedidoCallCenterType;
use App\Form\Pedido\PedidoItemsType;
use App\Repository\PedidoCallCenterRepository;
use App\Repository\ClienteRepository;
use App\Repository\MarcaRepository;
use App\Repository\TipoEstadoRepository;
use App\Repository\PedidoItemsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Fpdf\Fpdf;
use App\Service\Pdf;

#[Route('/pedido/call/center')]
class PedidoCallCenterController extends AbstractController
{
    /**
     * @var \Doctrine\Persistence\ManagerRegistry
     */
    private $managerRegistry;
    public function __construct(\Doctrine\Persistence\ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
    #[Route('/', name: 'pedido_call_center_index', methods: ['GET'])]
    public function index(PedidoCallCenterRepository $pedidoCallCenterRepository, Request $request, TipoEstadoRepository $tipoEstadoRepository): Response
    {
    	$offset = max(0, $request->query->getInt('offset', 0));    	
    	$paginator = $pedidoCallCenterRepository->getPedidoPaginator($offset);
    	
    	// Obtiene todos los estados de la tabla "tipo_estado" para pasarlo al index.html.twig
    	$estados = $tipoEstadoRepository->findAll();    			        	    	    	    	    	
    	    	  	
        return $this->render('pedido_call_center/index.html.twig', [            
            'pedidos' 	=> $paginator,
            'previous' 	=> $offset - PedidoCallCenterRepository::PAGINATOR_PER_PAGE,
            'next' 		=> min(count($paginator), $offset + PedidoCallCenterRepository::PAGINATOR_PER_PAGE),
            'desde' 	=> $offset + 1,            
            'last' 		=> $pedidoCallCenterRepository->getLast($paginator),
            'estados' 	=> $estados,                   
        ]);
    }
    
    #[Route('/pedido', name: 'pedido_call_center', methods: ['GET','POST'])]
    public function showCabezera(Request $request, ClienteRepository $clienteRepository): Response
    {
    	$pedidoCallCenter = new PedidoCallCenter();
    	$form = $this->createForm(PedidoIntroCifType::class, $pedidoCallCenter);
        $form->handleRequest($request);                                                 

        if ($form->isSubmitted() && $form->isValid()) {
        	// Busca si existe un cliente en la base de datos con el C.I.F introducido en el formulario
        	$result = $clienteRepository->findByCif($pedidoCallCenter->getCuentaCliente());
        	if(count($result) == 1) {        
				return $this->redirectToRoute('pedido_call_center_new', ['cif' => $pedidoCallCenter->getCuentaCliente()], Response::HTTP_SEE_OTHER);       	      	
		    }
		    else {
		    	$this->addFlash('warning', 'No existe ningún cliente con el C.I.F. ' . $pedidoCallCenter->getCuentaCliente());
				return $this->redirectToRoute('pedido_call_center');
		    }       	         
           
        }

        return $this->render('pedido_call_center/cabezera.html.twig', [
            'pedido_call_center' => $pedidoCallCenter,
            'form' => $form,
        ]);
    }

    #[Route('/new/{cif}', name: 'pedido_call_center_new', methods: ['GET','POST'])]
    public function new(Request $request, Cliente $cliente, ValidatorInterface $validator, MarcaRepository $marcaRepository, PedidoCallCenterRepository $pedidoCallCenterRepository): Response
    {
        $pedidoCallCenter = new PedidoCallCenter();
        $pedidoCallCenter->setFecha(new \DateTime());
        $pedidoCallCenter->setEstado(1);
		$pedidoCallCenter->setCliente($cliente);                                               
                                 
        $form = $this->createForm(PedidoCallCenterType::class, $pedidoCallCenter);
        $form->handleRequest($request);                                                          
        
        $pedidoItemsForm = $this->createForm(PedidoItemsType::class);
        $pedidoItemsForm->handleRequest($request);                                                                                                                                                   
        
       	// maneja los posibles errores de validación al enviar el formulario
        $errors = $validator->validate($pedidoCallCenter);
                        
        if(count($errors) > 0) {        
    		$errorsString = (string) $errors;
    		  		     		
			return $this->render('pedido_call_center/new.html.twig', [					
				'errors' => $errors,
				'pedido_call_center' => $pedidoCallCenter,
            	'cliente' => $cliente,					
				'form' => $form->createView(),
				'pedidoItems' => $pedidoItemsForm,											
			]);								
        }                                                                                                                                     

        if ($form->isSubmitted() && $form->isValid()) {        	        	       	        	        			           	
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($pedidoCallCenter);                                                                                                                  
        }
        
        if ($pedidoItemsForm->isSubmitted() && $pedidoItemsForm->isValid()) {
        	// Recoge los valores del formulario
        	$descripcion[] = $pedidoItemsForm->get('descripcion')->getData();
        	$cantidad[] = $pedidoItemsForm->get('cantidad')->getData();
        	$precio[] = $pedidoItemsForm->get('precio')->getData();
        	$referencia[] = $pedidoItemsForm->get('referencia')->getData();
        	$stock[] = $pedidoItemsForm->get('stock')->getData();
        	$dto[] = $pedidoItemsForm->get('dto')->getData();
        	$neto[] = $pedidoItemsForm->get('neto')->getData();
        	
        	for($i = 1; $i <= 10; $i++) {
        		$descripcionVal = $pedidoItemsForm->get('descripcion' . $i)->getData();
				$cantidadVal = $pedidoItemsForm->get('cantidad' . $i)->getData();
				$precioVal = $pedidoItemsForm->get('precio' . $i)->getData();
				$referenciaVal = $pedidoItemsForm->get('referencia' . $i)->getData();
				$stockVal = $pedidoItemsForm->get('stock' . $i)->getData();
				$dtoVal = $pedidoItemsForm->get('dto' . $i)->getData();
				$netoVal = $pedidoItemsForm->get('neto' . $i)->getData();							
				
        		if($descripcionVal && $cantidadVal && $precioVal && $dtoVal && $netoVal) {
        			$descripcion[] = $pedidoItemsForm->get('descripcion' . $i)->getData();
					$cantidad[] = $pedidoItemsForm->get('cantidad' . $i)->getData();
					$precio[] = $pedidoItemsForm->get('precio' . $i)->getData();
					$referencia[] = $pedidoItemsForm->get('referencia' . $i)->getData();
					$stock[] = $pedidoItemsForm->get('stock' . $i)->getData();
					$dto[] = $pedidoItemsForm->get('dto' . $i)->getData();
					$neto[] = $pedidoItemsForm->get('neto' . $i)->getData();
        		}        		        		        		        	
        	}        	        	
        	
        	// Calcula el nº del último pedido
			$pedidos = $pedidoCallCenterRepository->findAll();

			// Guarda los datos en la tabla pedido_items
			$counter = count($descripcion);												     	        	
        	        	
        	for($i = 0; $i < $counter; $i++) {        	
        		$pedido = new PedidoItems();        		        		                                            
				
				// Si es el primer pedido de la base de datos inicializamos la propiedad PedidoId a 1
				if(count($pedidos) == 0) {
					$pedido->setPedidoId(1);						
				}								                       
				
				// Si la base de datos ya cuenta con registros de pedidos, calcula el nº de pedido a utilizar como último pedido
				if(count($pedidos) != 0) {
					for($x = 0; $x <= count($pedidos); $x++) {
						if($x == count($pedidos)) {        		        		        		        		
							$pedido->setPedidoId($pedidos[$x-1]->getId()+1); 							      		
						}        	
					}
				}
				
				$pedido->setTotalPvp($pedidoItemsForm->get('totalPvp')->getData());
				$pedido->setTotalDto($pedidoItemsForm->get('totalDto')->getData());
				$pedido->setTotalNeto($pedidoItemsForm->get('totalNeto')->getData());
				$pedido->setTotalIva($pedidoItemsForm->get('totalIva')->getData());
				$pedido->setTotal($pedidoItemsForm->get('total')->getData());
				        		        		 
        		$pedido->setDescripcion($descripcion[$i]);
        		$pedido->setCantidad($cantidad[$i]);
        		$pedido->setPrecio($precio[$i]);
        		$pedido->setReferencia($referencia[$i]);
        		$pedido->setStock($stock[$i]);
        		$pedido->setDto($dto[$i]);
        		$pedido->setNeto($neto[$i]);
        		$pedidoCallCenter->addPedidoItem($pedido);
        		
        		$entityManager->persist($pedido); 
        	}
        	
        	$entityManager->flush();
        	        	        	        	
        	return $this->redirectToRoute('pedido_call_center_index', [], Response::HTTP_SEE_OTHER);            
        }        

        return $this->render('pedido_call_center/new.html.twig', [
            'pedido_call_center' => $pedidoCallCenter,
            'cliente' => $cliente,
            'form' => $form,
            'pedidoItems' => $pedidoItemsForm,                                        
        ]);
    }
    
    #[Route('/search', name: 'pedido_search', methods: ['GET', 'POST'])]
	public function search(Request $request, PedidoCallCenterRepository $pedidoCallCenterRepository, ValidatorInterface $validator, TipoEstadoRepository $tipoEstadoRepository): Response
    {
    	$buscaPedido = new BuscaPedido();		
    	$form = $this->createForm(BuscaPedidoCallCenterType::class, $buscaPedido);       
        $form->handleRequest($request);                       
                        
        if ($form->isSubmitted()) {
        	// Si no se han rellenado alguno de los campos del formulario arroja una aviso
		    if($buscaPedido->getSelecciona() == "" || $buscaPedido->getValor() == "") {
		    	$this->addFlash('warning', 'Debes rellenar los campos.');
		    	return $this->render('pedido_call_center/search.html.twig', [										
					'busca' => $buscaPedido,					
					'form' => $form->createView(),					
				]);	
		    }
                	        	
        	$campo = $buscaPedido->getSelecciona();
        	$valor = $buscaPedido->getValor();
        	$estados = $tipoEstadoRepository->findAll();
        	
        	// Busca el valor en la tabla "tipo_estado" y devuelve el id correspondiente para hacer la búsqueda en la tabla
        	// pedido_call_center        	
        	
        	if($campo == "estado") {        		      		
        		$estados = $tipoEstadoRepository->findByFieldValue($campo, $valor);        		        		
        		
        		foreach($estados as $estado) {        			
    				$valor = $estado->getId();        			
        		}          		
        	}       	        	        	        	     	        	       	        	        	             	
        	
        	$offset = max(0, $request->query->getInt('offset', 0));
    		$paginator = $pedidoCallCenterRepository->findByFieldValue($offset, $campo, $valor);        	        	
        	
        	if(count($paginator) > 0) {        		       		        		        		
        		return $this->render('pedido_call_center/search_result.html.twig', [				  				   
				    'pedidos' 	=> $paginator,
				    'previous' 	=> $offset - PedidoCallCenterRepository::PAGINATOR_PER_PAGE,
				    'next' 		=> min(count($paginator), $offset + PedidoCallCenterRepository::PAGINATOR_PER_PAGE),
				    'desde' 	=> $offset + 1,
				    'campo' 	=> $campo,
				    'valor' 	=> $valor,
				    'last' 		=> $pedidoCallCenterRepository->getLast($paginator),
				    'estados' 	=> $estados,  
				]);
        	}
        	else {
        		return $this->render('pedido_call_center/search_result.html.twig', [				  				   
				    'pedidos' 	=> '',
				    'previous' 	=> $offset - PedidoCallCenterRepository::PAGINATOR_PER_PAGE,
				    'next' 		=> min(count($paginator), $offset + PedidoCallCenterRepository::PAGINATOR_PER_PAGE),
				    'desde' 	=> $offset + 1,
				    'campo' 	=> $campo,
				    'valor' 	=> $valor,
				    'last' 		=> $pedidoCallCenterRepository->getLast($paginator),
				    'estados' 	=> $estados,  
				]);
        	}
        }
        
    	return $this->render('pedido_call_center/search.html.twig', [           
            'form' => $form,                 
        ]);                
    }
    
    #[Route('/search/results', name: 'pedido_search_results', methods: ['GET'])]
    public function searchResults(PedidoCallCenterRepository $pedidoCallCenterRepository, Request $request, TipoEstadoRepository $tipoEstadoRepository): Response
    {    	        
    	$campo = $request->query->get('campo');
    	$valor = $request->query->get('valor');
    	$estados = $tipoEstadoRepository->findAll(); 
        	
    	$offset = max(0, $request->query->getInt('offset', 0));
    	$paginator = $pedidoCallCenterRepository->findByFieldValue($offset, $campo, $valor);    	    	
    	
        return $this->render('pedido_call_center/search_result.html.twig', [           
            'pedidos' 	=> $paginator,
            'previous' 	=> $offset - PedidoCallCenterRepository::PAGINATOR_PER_PAGE,
            'next' 		=> min(count($paginator), $offset + PedidoCallCenterRepository::PAGINATOR_PER_PAGE),
            'desde' 	=> $offset + 1,
            'campo' 	=> $campo,
		    'valor' 	=> $valor,
		    'last' 		=> $pedidoCallCenterRepository->getLast($paginator),
		    'estados' 	=> $estados, 		    
        ]);
    }
    
    /* #[Route('/logoMarca', name: 'logoMarca', methods: ['GET', 'POST'])]
	public function logoMarca(PedidoCallCenter $pedidoCallCenter): Response
    {
    	echo $pedidoCallCenter->getLogo();
    	exit();   	    	   	    	       
    }  */ 

    #[Route('/{id}', name: 'pedido_call_center_show', methods: ['GET'])]
    public function show(PedidoCallCenter $pedidoCallCenter, MarcaRepository $marcaRepository): Response
    {
    	$logoMarca = $marcaRepository->findOneByid($pedidoCallCenter->getMarca());  
    	   	    	   	
        return $this->render('pedido_call_center/show.html.twig', [
            'pedido_call_center' => $pedidoCallCenter, 
            'logo' => $logoMarca,          
        ]);
    }

    #[Route('/{id}/edit', name: 'pedido_call_center_edit', methods: ['GET','POST'])]
    public function edit(Request $request, PedidoCallCenter $pedidoCallCenter, MarcaRepository $marcaRepository, PedidoItemsRepository $pedidoItemsRepository): Response
    {    	    	
        $form = $this->createForm(PedidoCallCenterType::class, $pedidoCallCenter);
        $form->handleRequest($request);                
                
        $pedidoItemsArray = $pedidoItemsRepository->findByPedidoCallCenter($pedidoCallCenter->getId());                                                                                                                                                                                  
        
        $logoMarca = $marcaRepository->findOneByid($pedidoCallCenter->getMarca());       

        if ($form->isSubmitted() && $form->isValid()) {                    	         	
    		$pedidoItemsForm = $this->createForm(PedidoItemsType::class);
    		$pedidoItemsForm->handleRequest($request);
    		
    		// Recoge los valores del formulario
	    	$descripcion[] = $pedidoItemsForm->get('descripcion')->getData();
	    	$cantidad[] = $pedidoItemsForm->get('cantidad')->getData();
	    	$precio[] = $pedidoItemsForm->get('precio')->getData();
	    	$referencia[] = $pedidoItemsForm->get('referencia')->getData();
	    	$stock[] = $pedidoItemsForm->get('stock')->getData();
	    	$dto[] = $pedidoItemsForm->get('dto')->getData();
	    	$neto[] = $pedidoItemsForm->get('neto')->getData();
      		$counter = count($pedidoItemsArray);
	    	
	    	for($i = 1; $i < $counter; $i++) {        						        		
				$descripcion[] = $pedidoItemsForm->get('descripcion' . $i)->getData();
				$cantidad[] = $pedidoItemsForm->get('cantidad' . $i)->getData();
				$precio[] = $pedidoItemsForm->get('precio' . $i)->getData();
				$referencia[] = $pedidoItemsForm->get('referencia' . $i)->getData();
				$stock[] = $pedidoItemsForm->get('stock' . $i)->getData();
				$dto[] = $pedidoItemsForm->get('dto' . $i)->getData();
				$neto[] = $pedidoItemsForm->get('neto' . $i)->getData();        		        		        	
    		}

      		$counter = count($pedidoItemsArray);
    		
    		for($i = 0; $i < $counter; $i++) {    			
    			$pedidoItems = $pedidoItemsArray[$i];
    			
    			$pedidoItems->setTotalPvp($pedidoItemsForm->get('totalPvp')->getData());
				$pedidoItems->setTotalDto($pedidoItemsForm->get('totalDto')->getData());
				$pedidoItems->setTotalNeto($pedidoItemsForm->get('totalNeto')->getData());
				$pedidoItems->setTotalIva($pedidoItemsForm->get('totalIva')->getData());
				$pedidoItems->setTotal($pedidoItemsForm->get('total')->getData());
					    		        		 
	    		$pedidoItems->setDescripcion($descripcion[$i]);
	    		$pedidoItems->setCantidad($cantidad[$i]);
	    		$pedidoItems->setPrecio($precio[$i]);
	    		$pedidoItems->setReferencia($referencia[$i]);
	    		$pedidoItems->setStock($stock[$i]);
	    		$pedidoItems->setDto($dto[$i]);
	    		$pedidoItems->setNeto($neto[$i]);		    				    		            						 
    		}        		
    		
    		$this->managerRegistry->getManager()->flush();
    		$this->addFlash('notice', 'El pedido ' . $pedidoCallCenter->getId() . ' se ha actualizado.');
        	return $this->redirectToRoute('pedido_call_center_show', ['id' => $pedidoCallCenter->getId()], Response::HTTP_SEE_OTHER);               	
        }                    				                       
        
        // Crea un array de variables para pasarle al renderForm
        $variables = [
        	'pedido_call_center' => $pedidoCallCenter,
            'form' => $form,
            'logo' => $logoMarca,            
        ];

        $counter = count($pedidoItemsArray);               
        
        for($i = 0; $i < $counter; $i++) {
        	$pedidoItemsForm[$i] = $this->createForm(PedidoItemsType::class);
        	$pedidoItemsForm[$i]->handleRequest($request);
        	$variables['pedidoItems'.$i] = $pedidoItemsForm[$i];
        	$variables['pedido_items'.$i] = $pedidoItemsArray[$i];        	
        }                        
                               
        return $this->render('pedido_call_center/edit.html.twig', $variables);
    }

    #[Route('/{id}', name: 'pedido_call_center_delete', methods: ['POST'])]
    public function delete(Request $request, PedidoCallCenter $pedidoCallCenter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pedidoCallCenter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->remove($pedidoCallCenter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pedido_call_center_index', [], Response::HTTP_SEE_OTHER);
    }

	#[Route('/{id}/print', name: 'pedido_call_center_print', methods: ['GET','POST'])]
	public function print(Request $request, PedidoCallCenter $pedidoCallCenter, MarcaRepository $marcaRepository, PedidoItemsRepository $pedidoItemsRepository, Pdf $pdf) : void 
	{				
		$pedidoItemsArray = $pedidoItemsRepository->findByPedidoCallCenter($pedidoCallCenter->getId());                                                                                                                                                                                          
        $logoMarca = $marcaRepository->findOneByid($pedidoCallCenter->getMarca());						
		
		$totales = $pedidoItemsArray[0];						
				
		$pdf->fecha = $pedidoCallCenter->getFecha()->format('d-m-Y');
		$pdf->nombreCliente = $pedidoCallCenter->getNombreCliente();
		$pdf->telefono1 = $pedidoCallCenter->getTelefono1();
		$pdf->contacto = $pedidoCallCenter->getContacto();
		$pdf->telefono = $pedidoCallCenter->getTelefono();
		$pdf->email = $pedidoCallCenter->getEmail();
		$pdf->localidad = $pedidoCallCenter->getLocalidad();
		$pdf->cif = $pedidoCallCenter->getCif();
		$pdf->comentario = $pedidoCallCenter->getComentario();
		$pdf->vin = $pedidoCallCenter->getVin();
		$pdf->marca = $logoMarca->getNombre();
		
		// Cabecera del pdf
		$pdf->SetLineWidth(0.5);
		$pdf->AddPage();
		$pdf->AliasNbPages();
		$pdf->SetAutoPageBreak(true, 15);		

		// Relación de artículos
		$pdf->SetFont('');
		
		foreach($pedidoItemsArray as $producto) {
			$pdf->Cell(40, 6, iconv('UTF-8', 'ISO-8859-1', $producto->getReferencia()), 0, 0, 'L');
			$pdf->Cell(77, 6, iconv('UTF-8', 'ISO-8859-1', ucfirst(strtolower($producto->getDescripcion()))), 0, 0, 'L');
			$pdf->Cell(18, 6, iconv('UTF-8', 'ISO-8859-1', $producto->getCantidad()), 0, 0, 'C');
			$pdf->Cell(20, 6, iconv('UTF-8', 'ISO-8859-1', $producto->getPrecio()), 0, 0, 'C');
			$pdf->Cell(20, 6, iconv('UTF-8', 'ISO-8859-1', $producto->getDto()), 0, 0, 'C');
			$pdf->Cell(18, 6, iconv('UTF-8', 'ISO-8859-1', $producto->getNeto()), 0, 0, 'R');
			$pdf->Ln();
		}

		// Muestra totales
		$pdf->SetY(242);
		$pdf->SetFont('Arial', 'I', 10);
		$pdf->Cell(170, 6, 'Total P.V.P', 0, 0, 'R');
		$pdf->SetFont('', 'I', 10);
		$pdf->Cell(20, 6, iconv('UTF-8', 'ISO-8859-1', $totales->getTotalPvp()), 0, 0, 'R');
		$pdf->Ln();		
		$pdf->SetFont('Arial', 'I', 10);
		$pdf->Cell(170, 6, 'Total Dto.', 0, 0, 'R');
		$pdf->SetFont('', 'I', 10);
		$pdf->Cell(20, 6, iconv('UTF-8', 'ISO-8859-1', $totales->getTotalDto()), 0, 0, 'R');
		$pdf->Ln();
		$pdf->SetFont('Arial', 'I', 10);
		$pdf->Cell(170, 6, 'Total neto', 0, 0, 'R');
		$pdf->SetFont('', 'I', 10);
		$pdf->Cell(20, 6, iconv('UTF-8', 'ISO-8859-1', $totales->getTotalNeto()), 0, 0, 'R');
		$pdf->Ln();
		$pdf->SetFont('Arial', 'I', 10);
		$pdf->Cell(170, 6, 'Total I.V.A', 0, 0, 'R');
		$pdf->SetFont('', 'I', 10);
		$pdf->Cell(20, 6, iconv('UTF-8', 'ISO-8859-1', $totales->getTotalIva()), 0, 0, 'R');
		$pdf->Ln();
		$pdf->SetFont('Arial', 'BI', 10);
		$pdf->Cell(170, 6, 'Total', 0, 0, 'R');
		$pdf->SetFont('Arial', 'I', 10);
		$pdf->Cell(20, 6, iconv('UTF-8', 'ISO-8859-1', $totales->getTotal()), 0, 0, 'R');
		$pdf->Ln();								

		$pdf->Output('D', 'Pedido');
	}
}
