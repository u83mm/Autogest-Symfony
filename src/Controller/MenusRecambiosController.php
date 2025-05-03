<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/menus')]
class MenusRecambiosController extends AbstractController
{
    #[Route('/recambios', name: 'app_menus_recambios')]
    public function index(): Response
    {
        return $this->render('main_menu/recambios/menus_recambios.html.twig', [
            'controller_name' => 'MenusRecambiosController',                      
        ]);
    }

    #[Route('/consultar_pedidos', name: 'app_menus_recambios_consultar_pedido')]
    public function consultarPedido(): Response
    {
        return $this->render('main_menu/recambios/consultar_pedido.html.twig', [
            'controller_name' => 'MenusRecambiosController',                      
        ]);
    }

    #[Route('/referencias', name: 'app_menus_recambios_referencias')]
    public function referencias(): Response
    {
        return $this->render('main_menu/recambios/referencias.html.twig', [
            'controller_name' => 'MenusRecambiosController',                      
        ]);
    }

    #[Route('/consultar_pedidos/pedidos_call_center', name: 'app_menus_recambios_consultar_pedidos_call_center')]
    public function consultarPedidosCallCenter(): Response
    {
        return $this->render('main_menu/recambios/pedidos_call_center.html.twig', [
            'controller_name' => 'MenusRecambiosController',                      
        ]);
    }
}
