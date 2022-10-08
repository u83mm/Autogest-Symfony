<?php

namespace App\Controller;

use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class EndPointStockController extends AbstractController
{
    #[Route('/end/point/stock/{referencia}', name: 'end_point_stock')]
    public function index(Stock $stock): Response
    {
    	// Crea JSON de stock para consultarlo a través de AJAX        
    	        
        $result[] = [
        	'referencia' => $stock->getReferencia(),
        	'stock' => number_format($stock->getCantidad(), 0),         	
        ];                                   
        
        return $response = new JsonResponse($result);
        
        /*return $this->render('end_point_stock/index.html.twig', [
            'controller_name' => 'EndPointStockController',
        ]);*/
    }
}
