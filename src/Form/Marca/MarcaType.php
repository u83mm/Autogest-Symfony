<?php

namespace App\Form\Marca;

use App\Entity\Marca;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class MarcaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('logo', FileType::class, [
            	'mapped' 		=> false,
            	'required' 		=> false,            	
            	/*'constraints' 	=> [
                    new File([
                        'maxSize' 	=> '1024k',
                        'mimeTypes' => [
                        	'aplication/png'
                        ],                       
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],*/
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Marca::class,
        ]);
    }
}
