<?php

namespace App\DataFixtures;

use App\Entity\Medicine;
use App\Entity\Molecule;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('User');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
        $manager->persist($user);
        $user1 = new User();
        $user1->setUsername('Admin');
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setPassword($this->passwordHasher->hashPassword($user, 'password123'));

        $manager->persist($user1);

        $molecule = new Molecule();
        $molecule->setName('Paracétamol');
        $molecule->setCommonAffliction('Mal de tête');

        $medicinesData = [
            [
                'name' => 'Têtoprane',
                'dosage' => '500mg',
                'color' => 'White',
                'efficiencyTime' => '30 minutes',
                'aspect' => 'Tablet',
                'size' => 'Medium',
                'conditionning' => 'Blister pack of 10',
                'secondaryEffects' => 'Nausea, Dizziness',
                'format' => 'Oral',
                'administration' => 'Swallow with water',
                'durationTime' => '9h',
                'specificCondition' => []
            ],
            [
                'name' => 'Capsuloprane',
                'dosage' => '1g',
                'color' => 'White',
                'efficiencyTime' => '45 minutes',
                'aspect' => 'Capsule',
                'size' => 'Large',
                'conditionning' => 'Box of 20',
                'secondaryEffects' => 'Liver damage if overdosed',
                'format' => 'Oral',
                'administration' => 'Swallow with water',
                'durationTime' => '7h',
                'specificCondition' => []

            ],
            [
                'name' => 'Efferveprane',
                'dosage' => '500mg',
                'color' => 'Pink',
                'efficiencyTime' => '20 minutes',
                'aspect' => 'Effervescent Tablet',
                'size' => 'Large',
                'conditionning' => 'Tube of 15',
                'secondaryEffects' => 'Stomach irritation',
                'format' => 'Oral',
                'administration' => 'Dissolve in water before drinking',
                'durationTime' => '3h',
                'specificCondition' => []

            ],
            [
                'name' => 'Sirotête',
                'dosage' => '500mg',
                'color' => 'White',
                'efficiencyTime' => '15 minutes',
                'aspect' => 'Syrup',
                'size' => 'N/A',
                'conditionning' => 'Bottle of 150ml',
                'secondaryEffects' => 'Sleepiness, Dry mouth',
                'format' => 'Oral',
                'administration' => 'Measure with provided cup',
                'durationTime' => '4h',
                'specificCondition' => []

            ],
            [
                'name' => 'Paracétamol sachet',
                'dosage' => '300mg',
                'color' => 'Yellow',
                'efficiencyTime' => '10 minutes',
                'aspect' => 'Powder',
                'size' => 'Small sachet',
                'conditionning' => 'Box of 10 sachets',
                'secondaryEffects' => 'Stomach upset',
                'format' => 'Oral',
                'administration' => 'Mix with water before drinking',
                'durationTime' => '5h',
                'specificCondition' => ["Femme Enceinte", "Enfant Bas Age"]

            ],
        ];

        foreach ($medicinesData as $data) {
            $medicine = new Medicine();
            $medicine->setName($data['name']);
            $medicine->setDosage($data['dosage']);
            $medicine->setColor($data['color']);
            $medicine->setEfficiencyTime($data['efficiencyTime']);
            $medicine->setAspect($data['aspect']);
            $medicine->setSize($data['size']);
            $medicine->setConditionning($data['conditionning']);
            $medicine->setSecondaryEffects($data['secondaryEffects']);
            $medicine->setFormat($data['format']);
            $medicine->setAdministration($data['administration']);
            $medicine->setDurationTime($data['durationTime']);
            $medicine->setSpecificConditions($data['specificCondition']);
            $medicine->setMolecule($molecule);
            $manager->persist($molecule);
            $manager->persist($medicine);
        }

        $manager->flush();
    }
}