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
	
	public function __construct(RouterInterface $router) {
		$this->router = $router;		
	}	    
    
    public function ShowExceptionEvent(ExceptionEvent $event): void
    {    	
        //dd($event);
        $exception = $event->getThrowable();                       
        $exception->getMessage();       
        
        //dd($this->twig);         
        
        if($exception->getCode() == 403) {        	   			           	       	        	      	     	
        	$event->setResponse(new RedirectResponse($this->router->generate('error_page')));         	       	
        }
        
        if($exception->getCode() == 0) {        	   			           	       	        	      	     	
        	//$event->setResponse(new RedirectResponse($this->router->generate('not_found')));        	
        }                
    }

    /**
     * The function `getSubscribedEvents` returns an array mapping the `KernelEvents::EXCEPTION` event
     * to the `ShowExceptionEvent` method with priority 0.
     * 
     * @return An array is being returned with the event `KernelEvents::EXCEPTION` subscribed to the
     * method `ShowExceptionEvent` with a priority of 0.
     */
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
