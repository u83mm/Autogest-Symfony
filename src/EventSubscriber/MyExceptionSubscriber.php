<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Symfony\Component\HttpKernel\KernelEvents;

class MyExceptionSubscriber implements EventSubscriberInterface
{
	private $router;
	private $twig;	
	
	public function __construct(RouterInterface $router, Environment $twig) {
		$this->router = $router;
		$this->twig = $twig;		
	}	    
    
    public function ShowExceptionEvent(ExceptionEvent $event): void
    {    	
        //dd($event);
        $exception = $event->getThrowable();                       
        $message = $exception->getMessage();       
        
        //dd($this->twig);         
        
        if($exception->getCode() == 403) {        	   			           	       	        	      	     	
        	$event->setResponse(new RedirectResponse($this->router->generate('error_page')));         	       	
        }
        
        if($exception->getCode() == 0) {        	   			           	       	        	      	     	
        	//$event->setResponse(new RedirectResponse($this->router->generate('not_found')));        	
        }                
    }

    public static function getSubscribedEvents()
    {
        return [
            //ExceptionEvent::class =>  
            KernelEvents::EXCEPTION => [            	
            	['ShowExceptionEvent', 0]
            ],
        ];
    }
}
