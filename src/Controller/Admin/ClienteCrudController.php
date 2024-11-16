<?php

namespace App\Controller\Admin;

use App\Entity\Cliente;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class ClienteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cliente::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'razon_social',
            'nombre',
            'apellido1',
            'apellido2',
            'tipo_via',
            'nombre_via',            
            'num_via',
            'puerta',
            'codigo_postal',
            'localidad',
            'provincia',
            'tfno',
            'email',
            'cif',
            DateField::new('fecha_alta'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
        	->add('razonSocial')
    		->add('nombre')
    		->add('apellido1')
    		->add('apellido2')
            ->add('codigoPostal')
            ->add('localidad')
            ->add('provincia')
            ->add('cif')            
        ;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
