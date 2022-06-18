<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeaderController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Header::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre de l\'en-tête'),
            TextareaField::new('subtitle', 'Contenu'),
            TextField::new('buttonTitle', 'Titre du bouton'),
            TextField::new('buttonUrl', 'Url de destination du bouton'),
            ImageField::new('illustration', 'Image')
                ->setBasePath('/build/uploads/products/')
                ->setUploadDir('assets/uploads/products/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
        ];
    }
}
