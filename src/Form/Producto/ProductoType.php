<?php

namespace App\Form\Producto;

use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\FamiliaRepository;
use App\Repository\MarcaRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductoType extends AbstractType
{
	private $familia;
	private $marca;
	
	/**
	 * Construye arrays de valores conteniendo los valores de la tabla "Familia" y "Marcas" para pasarselo al método "add" del objeto 
	 * "builder" como tercer parámetro y dichos valores en el desplegable correspondiente.
	 */
	public function __construct(FamiliaRepository $familiaRepository, MarcaRepository $marcaRepository) {
		$result = $familiaRepository->findAll();
		$familiaSelect = array('- Selecciona -' => '');
		
		$marcaResult = $marcaRepository->findAll();
		$marcaSelect = array('- Selecciona -' => '');
		
		foreach($result as $familia) {
			$familiaSelect[$familia->getNombreFamilia()] = $familia->getNombreFamilia();
		}
		
		foreach($marcaResult as $marca) {
			$marcaSelect[$marca->getNombre()] = $marca->getId();
		}
		
		$this->familia = $familiaSelect;
		$this->marca = $marcaSelect;				
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('referencia')
            ->add('descripcion')
            ->add('familia', ChoiceType::class, [
            	'choices' => $this->familia,            	
            ])
            ->add('pvp')
            ->add('marca', ChoiceType::class, [
            	'choices' => $this->marca,            	
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
