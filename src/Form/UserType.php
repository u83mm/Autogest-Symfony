<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\DepartamentosRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
	private $departamento;
	
	/**
	 * Construye un array de valores conteniendo los valores de la tabla "Departamentos" para pasarselo al método "add" del objeto 
	 * "builder" como tercer parámetro y dichos valores en el desplegable correspondiente.
	 */
	public function __construct(DepartamentosRepository $departamentosRepository) {
		$result = $departamentosRepository->findAll();
		$departamentosSelect = array('- Selecciona -' => '');
		
		foreach($result as $departamento) {
			$departamentosSelect[$departamento->getNombreDepartamento()] = $departamento->getNombreDepartamento();
		}
		
		$this->departamento = $departamentosSelect;
		
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder            
            ->add('nombre',TextType::class)
            ->add('apellido1',TextType::class)            
            ->add('apellido2',TextType::class)
            ->add('email', EmailType::class)
            ->add('username',TextType::class)
            /*->add('roles')*/ // comentamos este campo de momento para evitar el error de conversión a cadena
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class)         
            ->add('foto', FileType::class, [
            	'mapped' 		=> false,
            	'required' 		=> false,
            	'constraints' 	=> [
                    new File([
                        'maxSize' 	=> '1024k',                        
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ])
                ],
            ])
            ->add('departamento', ChoiceType::class, [
            	'choices' => $this->departamento,
            	'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
