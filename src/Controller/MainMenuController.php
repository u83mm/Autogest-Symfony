<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/main")
 */
class MainMenuController extends AbstractController
{
	/**
	 * @Route("/menu", name="main_menu")
	 */    
    public function index(): Response
    {    	    	
        return $this->render('main_menu/index.html.twig', [
            'controller_name' => 'MainMenuController',
            'h2_inner' => 'Menú Principal',            
        ]);
    }
    
    
	/**
	 * @Route("/inicio", name="main")
	 */    
    public function main(): Response
    {    	    	
        return $this->render('main_menu/main.html.twig', [
            'controller_name' => 'MainMenuController',
            'h2_inner' => 'Menú Principal',            
        ]);
    }
    
    /**
	 * @Route("/cuentatras", name="cuenta_atras")
	 */
	public function cuentaAtras(): Response
    {
        return $this->render('main_menu/cuenta_atras.html.twig', [
            'controller_name' => 'MainMenuController',           
        ]);
    }
    
    /**
	 * @Route("/recambios", name="recambios", methods={"GET", "POST"})
	 */
	public function recambios(): Response
    {    
    	return $this->render('main_menu/recambios/menus_recambios.html.twig', [
            'controller_name' => 'MainMenuController',                      
        ]);        	 	    	    	   	    	       
    }
    
    /**
	 * @Route("/consultar_pedido", name="consultar_pedido", methods={"GET", "POST"})
	 */
	public function recambiosConsultaPedidos(): Response
    {    	    	
    	// Muestra menús AJAX en función del menú seleccionado    	   	
    	if($_REQUEST['tipo'] == "Consultar Pedidos") {
    		return $this->render('main_menu/recambios/consultar_pedido.html.twig', [
		        'controller_name' => 'MainMenuController',                      
		    ]);
    	}    	
    	else if($_REQUEST['tipo'] == "Pedidos de Call Center") {
    		return $this->render('main_menu/recambios/pedidos_call_center.html.twig', [
		        'controller_name' => 'MainMenuController',                      
		    ]);
    	}    	
    	else if($_REQUEST['tipo'] == "Referencias") {
    		return $this->render('main_menu/recambios/referencias.html.twig', [
		        'controller_name' => 'MainMenuController',                      
		    ]);
    	}         	       	 	    	    	   	    	       
    }
    
    /**
	 * @Route("/taller", name="taller")
	 */
	public function taller(): Response
    {
    	return $this->render('main_menu/menus_taller.html.twig', [
            'controller_name' => 'MainMenuController',                      
        ]);              
    }
    
    /**
	 * @Route("/visitas", name="visitas")
	 */
	public function visitas(): Response
    {
    	return $this->render('main_menu/menus_visitas.html.twig', [
            'controller_name' => 'MainMenuController',                      
        ]);                
    }
    
    /**
	 * @Route("/clientes", name="clientes")
	 */
	public function clientes(): Response
    {
    	return $this->render('main_menu/menus_clientes.html.twig', [
            'controller_name' => 'MainMenuController',                      
        ]);                
    }        
}
