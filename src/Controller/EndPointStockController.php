<?php

namespace App\Controller;

use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class EndPointStockController extends AbstractController
{
    #[Route('/end/point/stock/{referencia}', name: 'end_point_stock')]
    public function index(Stock $stock): JsonResponse
    {
        // Crea JSON de stock para consultarlo a través de AJAX
        $data = [
            'referencia' => $stock->getReferencia(),
            'stock'      => (int) $stock->getCantidad(),
        ];

        return $this->json($data);
    }
}