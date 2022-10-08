<?php

namespace App\Form;

use App\Entity\BuscaUsuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BuscaUsuarioType extends AbstractType
{
	private $options;
	
	/**
	 * Construye un array de valores conteniendo los nombres de los campos de la tabla "User" para pasarselo al método "add" del objeto 
	 * "builder" como tercer parámetro y ver dichos valores en el desplegable correspondiente.
	 */
	public function __construct() {								
		$campoSelect = array(
			'- Selecciona -' => '',
			'Nombre' => 'nombre',
			'Primer Apellido' => 'apellido1',
			'Segundo Apellido' => 'apellido2',
			'Departamento' => 'departamento',
		);				
		
		$this->options = $campoSelect;
		
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('selecciona', ChoiceType::class, [
            	'choices' => $this->options,
            	'required' => false,
            ])
            ->add('valor', TextType::class, [
            	'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BuscaUsuario::class,
        ]);
    }
}
