<?php

namespace App\Form\Pedido;

use App\Entity\PedidoItems;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PedidoItemsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder            
            ->add('descripcion', null, [
            	'attr' => [
            		'placeholder' => 'Descripción de la pieza',
            		'title' => 'Introduzca recambio a solicitar',
            	],
            ])
            ->add('cantidad', null, [
		        	'attr' => [
		        		'placeholder' => 'Cantidad',
		        		'class' => 'cantidad',
		        		'title' => 'Introduzca cantidad a solicitar',
		        	],
		        ])
            ->add('precio', null, [
            	'attr' => [
            		'class' => 'hidde',
            		'readonly' => 'true',
            		'title' => 'Precio',
            	],
            ])
            ->add('referencia', null, [
		        	'required' => false,
		        	'attr' => [
		        		'class' => 'hidde',
		        		'placeholder' => 'Referencia',
		        		'title' => 'Introduzca referencia a solicitar',
		        	],
		    ])
            ->add('stock', null, [
            	'attr' => [
            		'class' => 'hidde hiddenHorizontal',
            		'readonly' => 'true',
            		'title' => 'Stock',
            	],
            ])
            ->add('dto', null, [
            	'attr' => [
            		'class' => 'hidde',
            		'title' => 'Descuento',            		
            	],
            ])
            ->add('neto', null, [
            	'attr' => [
            		'class' => 'hidde',
            		'readonly' => 'true',
            		'title' => 'Precio Neto',
            	],
            ])                                 	                                           		
            ->add('totalPvp')
            ->add('totalDto')
            ->add('totalNeto')
            ->add('totalIva')
            ->add('total')
        ;
        
        for($i = 1; $i <= 10; $i++) {
        	$builder
		    	->add('descripcion'.$i, null, [
		        	'required' => false,
		        	'attr' => [
		        		'placeholder' => 'Descripción de la pieza',
		        		'title' => 'Introduzca recambio a solicitar',
		        	],
		        ])
		        ->add('cantidad'.$i, null, [
		        	'required' => false,
		        	'attr' => [
		        		'placeholder' => 'Cantidad',
		        		'class' => 'cantidad',
		        		'title' => 'Introduzca cantidad a solicitar',
		        	],
		        ])
		        ->add('precio'.$i, null, [
		        	'attr' => [
		        		'class' => 'hidde',
		        		'required' => false,
		        		'readonly' => 'true',
		        		'title' => 'Precio',
		        	]	
		        ])
		        ->add('referencia'.$i, null, [
		        	'required' => false,
		        	'attr' => [
		        		'class' => 'hidde',
		        		'title' => 'Introduzca referencia a solicitar',
		        		'placeholder' => 'Referencia',
		        	],
		        ])
		        ->add('stock'.$i, null, [
		        	'attr' => [
		        		'class' => 'hidde hiddenHorizontal',
		        		'required' => 'false',
		        		'readonly' => 'true',
		        		'title' => 'Stock',
		        	]		        	
		        ])
		        ->add('dto'.$i, null, [		        	
		        	'required' => false,
		        	'attr' => [
		        		'class' => 'hidde',
		        		'title' => 'Descuento',		        		
		        	]
		        ])
		        ->add('neto'.$i, null, [
		        	'attr' => [
		        		'class' => 'hidde',
		        		'required' => 'false',
		        		'readonly' => 'true',
		        		'title' => 'Precio Neto',
		        	]	
		        ])
		    ; 
        }        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            //'data_class' => PedidoItems::class,
        ]);
    }
}
