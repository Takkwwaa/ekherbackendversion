<?php

namespace App\Controller\Admin;

use App\Entity\RateRule;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RateRuleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RateRule::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            BooleanField::new('isEnabled'),
            TextField::new('lable', 'label'),
            DateTimeField::new('createdAt'),
            AssociationField::new('RateRules', 'Category Id')
        ];
    }
}
