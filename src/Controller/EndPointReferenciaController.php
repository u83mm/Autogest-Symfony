<?php

namespace App\Controller;

use App\Entity\Producto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class EndPointReferenciaController extends AbstractController
{
    #[Route('/referencia/{referencia}', name: 'referencia')]
    public function index(Producto $producto): Response
    {
    	// Crea JSON de referencias para consultarlo a través de AJAX        
    	        
        $result[] = [
        	'referencia' => $producto->getReferencia(), 
        	'descripcion' => $producto->getDescripcion(),
        	'pvp' => number_format($producto->getPvp(), 2),
        	'dto' => number_format(0, 2),
        ];                                   
        
        return $response = new JsonResponse($result);   
        
        /*return $this->render('referencia/index.html.twig', [
            'controller_name' => 'ReferenciaController',
        ]);*/
    }
}
