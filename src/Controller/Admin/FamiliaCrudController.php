<?php

namespace App\Controller\Admin;

use App\Entity\Familia;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FamiliaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Familia::class;
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
