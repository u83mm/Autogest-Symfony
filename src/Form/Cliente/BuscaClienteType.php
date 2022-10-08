<?php

namespace App\Form\Cliente;

use App\Entity\BuscaCliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BuscaClienteType extends AbstractType
{
	private $options;
	
	/**
	 * Construye un array de valores conteniendo los nombres de los campos de la tabla "Clientes" para pasarselo al método "add" del objeto 
	 * "builder" como tercer parámetro y ver dichos valores en el desplegable correspondiente.
	 */
	public function __construct() {								
		$campoSelect = array(
			'- Selecciona -' => '',
			'C.I.F' => 'cif',
			'Nombre' => 'nombre',
			'Primer Apellido' => 'apellido1',
			'Segundo Apellido' => 'apellido2',
			'Razón Social' => 'razonSocial',
			'Localidad' => 'localidad',
			'Provincia' => 'provincia',			
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
            'data_class' => BuscaCliente::class,
        ]);
    }
}
