<?php

namespace App\Controller\Admin;

use App\Entity\Offres;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OffresCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Offres::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Poste'),
            TextField::new('place', 'Lieu'),
            TextareaField::new('description', 'Description')->stripTags(),
            DateTimeField::new('createdAt')->onlyOnIndex(),
            MoneyField::new('salary', 'Salaire par mois en €')->setNumDecimals(0)->setCurrency('EUR'),
            AssociationField::new('categories'),
            AssociationField::new('contractType')->formatValue(function($value,$entity){
                return $entity->getContractType();
            }),  
            AssociationField::new('author'),
        ];
    }
}
