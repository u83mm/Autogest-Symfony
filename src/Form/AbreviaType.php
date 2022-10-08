<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AbreviaType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder        	
            ->add('abrev', ChoiceType::class, [
            	'choices' => [
            		'-Selecciona-' => '',
            		'Calle' 	=> 'CL',
            		'Avenida' 	=> 'AV',
            		'Plaza' 	=> 'PZ',
            		'Polígono' 	=> 'PG',
            		'Autopista' => 'AU',
            		'Autovía' 	=> 'AI',
            		'Carretera' => 'CR',
            		'Gran Vía' 	=> 'GV',
            	],
            	'required' => false,
            ])
		;                        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'data_class' => Cliente::class,
        ]);
    }
}
