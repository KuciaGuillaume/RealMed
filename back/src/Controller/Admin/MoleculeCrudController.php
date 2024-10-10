<?php

namespace App\Controller\Admin;

use App\Entity\Molecule;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class MoleculeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Molecule::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Molecule Name'),
            TextField::new('commonAffliction', 'Common Affliction'),
            TextField::new('allergies', 'Allergies'),
            AssociationField::new('medicines', 'Associated Medicines')
                ->setHelp('Select medicines associated with this molecule')
                ->onlyOnDetail(), // Optionnel : Afficher uniquement sur les pages de détails, pas sur les formulaires
        ];
    }
}
