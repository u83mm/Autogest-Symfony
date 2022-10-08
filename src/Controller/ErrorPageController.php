<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/error/page')]
class ErrorPageController extends AbstractController
{
    #[Route('/acceso_denegado', name: 'error_page')]
    public function index(): Response
    {
        return $this->render('error_page/index.html.twig', [
            'controller_name' => 'ErrorPageController',
        ]);
    }
    
    #[Route('/pagina_no_encontrada', name: 'not_found')]
    public function notFound(): Response
    {
        return $this->render('error_page/pagina_no_encontrada.html.twig', [
            'controller_name' => 'ErrorPageController',
        ]);
    }
}
