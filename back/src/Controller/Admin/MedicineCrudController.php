<?php

namespace App\Controller\Admin;

use App\Entity\Medicine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class MedicineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Medicine::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Name'),
            ImageField::new('imageUrl', 'Image')
                ->setBasePath('') // Indique que l'URL est une URL complète
                ->setHelp('Provide a full URL to an external image.')
                ->onlyOnIndex(),
            TextField::new('dosage', 'Dosage')->setRequired(false),
            AssociationField::new('molecule', 'Molecule'),
            AssociationField::new('users', 'Users')->hideOnForm(),
            TextField::new('color', 'Color')->setRequired(false),
            AssociationField::new('contraindication', 'Contraindications'),
            TextField::new('efficiencyTime', 'Efficiency Time')->setRequired(false),
            TextField::new('aspect', 'Aspect')->setRequired(false),
            TextField::new('size', 'Size')->setRequired(false),
            TextField::new('conditionning', 'Conditionning')->setRequired(false),
            TextField::new('secondaryEffects', 'Secondary Effects')->setRequired(false),
            TextField::new('format', 'Format')->setRequired(false),
            TextField::new('administration', 'Administration')->setRequired(false),
            TextField::new('durationTime', 'Duration Time')->setRequired(false),
            ArrayField::new('specificConditions', 'Specific Conditions')->setRequired(false),
            TextEditorField::new('description', 'Description')->setRequired(false),
        ];
    }

}
