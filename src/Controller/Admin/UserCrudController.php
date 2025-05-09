<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'username',
            'nombre',
            'apellido1',
            'apellido2',            
            'email',
            'departamento',            
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
        	->add('username')
    		->add('nombre')
    		->add('apellido1')
    		->add('apellido2')    		
            ->add('departamento')            
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
