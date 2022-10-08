<?php

namespace App\Form\Cliente;

use App\Entity\Cliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClienteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('id')
            ->add('razonSocial')
            ->add('nombre')
            ->add('apellido1')
            ->add('apellido2')            
            ->add('tipoVia')
            ->add('nombreVia')
            ->add('codigoPostal')
            ->add('numVia')
            ->add('puerta')
            ->add('localidad')
            ->add('provincia')
            ->add('tfno')
            ->add('email', EmailType::class, [
            	'required' => false,
            ])
            ->add('cif')
            ->add('fechaAlta', DateType::class, [  
            	'html5' => false,
            	'widget' => 'single_text',             	            	     	       	            	           	
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cliente::class,
        ]);
    }
}
