<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/main')]
class MainMenuController extends AbstractController
{	
    #[Route('/menu', name: 'main_menu')]  
    public function index(): Response
    {    	    	
        return $this->render('main_menu/index.html.twig', [
            'controller_name' => 'MainMenuController',
            'h2_inner' => 'Menú Principal',            
        ]);
    }        	
      
    #[Route('/cuentatras', name: 'cuenta_atras')]
	public function cuentaAtras(): Response
    {
        return $this->render('main_menu/cuenta_atras.html.twig', [
            'controller_name' => 'MainMenuController',           
        ]);
    }        
       
    #[Route('/taller', name: 'taller')]
	public function taller(): Response
    {
    	return $this->render('main_menu/menus_taller.html.twig', [
            'controller_name' => 'MainMenuController',                      
        ]);              
    }
     
    #[Route('/visitas', name: 'visitas')]
	public function visitas(): Response
    {
    	return $this->render('main_menu/menus_visitas.html.twig', [
            'controller_name' => 'MainMenuController',                      
        ]);                
    }
    
    #[Route('/clientes', name: 'clientes')]
	public function clientes(): Response
    {
    	return $this->render('main_menu/menus_clientes.html.twig', [
            'controller_name' => 'MainMenuController',                      
        ]);                
    }        
}
