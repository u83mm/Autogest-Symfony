<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\MarcaRepository;

class LogoMarcaController extends AbstractController
{
    #[Route('/logo/marca', name: 'logo_marca')]
    public function index(MarcaRepository $marcaRepository): Response
    {
    	// Crea JSON de marcas para consultarlo a través de AJAX
        $marcaQuery = $marcaRepository->findAll();                

        foreach($marcaQuery as $logoMarca) {
        	$result[] = ['id' => $logoMarca->getId(), 'logo' => $logoMarca->getLogo()];    
        }                                  

        return $response = new JsonResponse($result);              

        /*return $this->render('logo_marca/index.html.twig', [
            'controller_name' => 'LogoMarcaController',
        ]);*/
    }
}
