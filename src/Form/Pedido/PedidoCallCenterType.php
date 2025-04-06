<?php

namespace App\Form\Pedido;

use App\Entity\PedidoCallCenter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;
use App\Repository\MarcaRepository;
use App\Repository\TipoEstadoRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PedidoCallCenterType extends AbstractType
{
	private $options;
	private $estado;
	
	/**
	 * Construye un array de valores conteniendo los valores de la tabla "Marca" para pasarselo al método "add" del objeto 
	 * "builder" como tercer parámetro y dichos valores en el desplegable correspondiente.
	 */
	public function __construct(MarcaRepository $marcaRepository, TipoEstadoRepository $tipoEstado) {
		$result = $marcaRepository->findAll();
		$estadoResult = $tipoEstado->findAll();
		
		$marcaSelect = ['- Selecciona -' => ''];
		$estadoSelect = ['- Selecciona -' => ''];		
		
		foreach($result as $marca) {
			$marcaSelect[$marca->getNombre()] = $marca->getId();
		}
		
		foreach($estadoResult as $estado) {
			$estadoSelect[$estado->getEstado()] = $estado->getId();
		}
		
		$this->options = $marcaSelect;
		$this->estado = $estadoSelect;
		
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha', DateType::class, [  
            	'html5' => false,
            	'widget' => 'single_text',
				'format' => 'dd/MM/yyyy',           	            	     	       	            	           	
            ])
            ->add('cuentaCliente', TextType::class)
            ->add('nombreCliente')
            ->add('contacto', null, [
            	'attr' => [
            		'placeholder' => 'Introduzca persona de contacto',
            		'title' => 'Introduzca persona de contacto',
            	]
            ])
            ->add('telefono', TelType::class, [
            	'required' => false,
            	'attr' => [
            		'placeholder' => 'Introduzca tfno. de contacto',
            		'title' => 'Introduzca tfno. de contacto',
            	]
            ])
            ->add('telefono1', TelType::class)
            ->add('cif')
            ->add('email', EmailType::class, [
            	'required' => false,
            ])
            ->add('localidad')
            ->add('comentario')
            ->add('vin') 
            ->add('marca', ChoiceType::class, [
            	'choices' => $this->options,            	
            ])
            ->add('estado', ChoiceType::class, [
            	'choices' => $this->estado,            	
            ])             
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PedidoCallCenter::class,
        ]);
    }
}
