<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartamentosController extends AbstractController
{
    #[Route('/departamentos', name: 'departamentos')]
    public function index(): Response
    {
        return $this->render('departamentos/index.html.twig', [
            'controller_name' => 'DepartamentosController',
        ]);
    }
}
