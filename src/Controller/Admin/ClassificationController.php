<?php

namespace App\Controller\Admin;

use App\Entity\Classification;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClassificationController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Classification::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name')
        ];
    }
}
