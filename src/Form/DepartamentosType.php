<?php

namespace App\Form;

use App\Entity\Departamentos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\DepartamentosRepository;

class DepartamentosType extends AbstractType
{
	private $options;
	
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
		
		$this->options = $departamentosSelect;
		
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreDepartamento', ChoiceType::class, [
            	'choices' => $this->options,
            	'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Departamentos::class,
        ]);
    }
}
