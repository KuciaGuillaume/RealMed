<?php

namespace App\DataFixtures;

use App\Entity\Medicine;
use App\Entity\Molecule;
use App\Entity\SecondaryEffect;
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
        // Création de l'utilisateur standard
        $user = new User();
        $user->setUsername('User');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
        $manager->persist($user);

        // Création de l'utilisateur administrateur
        $user1 = new User();
        $user1->setUsername('Admin');
        $user1->setRoles(['ROLE_ADMIN']);
        $user1->setPassword($this->passwordHasher->hashPassword($user1, 'password123'));
        $manager->persist($user1);

        // Création des effets secondaires
        $nausea = new SecondaryEffect();
        $nausea->setName('Nausea');
        $nausea->setSeverity('Moderate');
        $nausea->setSeverityScore(5);
        $manager->persist($nausea);

        $dizziness = new SecondaryEffect();
        $dizziness->setName('Dizziness');
        $dizziness->setSeverity('Low');
        $dizziness->setSeverityScore(3);
        $manager->persist($dizziness);

        $liverDamage = new SecondaryEffect();
        $liverDamage->setName('Liver Damage');
        $liverDamage->setSeverity('High');
        $liverDamage->setSeverityScore(8);
        $manager->persist($liverDamage);

        $respiratoryDepression = new SecondaryEffect();
        $respiratoryDepression->setName('Respiratory Depression');
        $respiratoryDepression->setSeverity('Severe');
        $respiratoryDepression->setSeverityScore(9);
        $manager->persist($respiratoryDepression);

        // Création des molécules et association avec les effets secondaires
        $molecule1 = new Molecule();
        $molecule1->setName('Paracétamol');
        $molecule1->setCommonAffliction('Mal de tête');
        $molecule1->setAllergies('Rare cas de réaction cutanée sévère, hypersensibilité');
        $molecule1->addSecondaryEffect($nausea);
        $molecule1->addSecondaryEffect($dizziness);
        $manager->persist($molecule1);

        $molecule2 = new Molecule();
        $molecule2->setName('Ibuprofène');
        $molecule2->setCommonAffliction('Douleurs musculaires');
        $molecule2->setAllergies('Risque de réaction allergique chez les personnes asthmatiques');
        $molecule2->addSecondaryEffect($dizziness);
        $molecule2->addSecondaryEffect($liverDamage);
        $manager->persist($molecule2);

        $molecule3 = new Molecule();
        $molecule3->setName('Morphine');
        $molecule3->setCommonAffliction('Douleurs intenses');
        $molecule3->setAllergies('Risque de dépression respiratoire, dépendance');
        $molecule3->addSecondaryEffect($respiratoryDepression);
        $manager->persist($molecule3);
        // Données des médicaments
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
                'specificCondition' => [],
                'description' => 'Têtoprane est utilisé pour soulager les douleurs modérées à sévères.',
                'molecule' => $molecule1,
                'imageUrl' =>'https://www.pharmashopi.com/images/Image/biogaran-paracetamol-500mg-gelules-1410368649.png',
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
                'specificCondition' => [],
                'description' => 'Capsuloprane est un analgésique puissant pour les douleurs chroniques.',
                'molecule' => $molecule1,
                'imageUrl' =>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSs91wkupmjebKdQiZ7QwowbPYjMt2BTNpmOQ&s',
            ],
            [
                'name' => 'Ibupraplus',
                'dosage' => '400mg',
                'color' => 'Red',
                'efficiencyTime' => '40 minutes',
                'aspect' => 'Tablet',
                'size' => 'Small',
                'conditionning' => 'Blister pack of 15',
                'secondaryEffects' => 'Stomach irritation',
                'format' => 'Oral',
                'administration' => 'Take with food to reduce stomach upset',
                'durationTime' => '6h',
                'specificCondition' => [],
                'description' => 'Ibupraplus est utilisé pour soulager les douleurs musculaires légères à modérées.',
                'molecule' => $molecule2,
                'imageUrl' =>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdVATuSLgcGwGzOJ0KQp_Gfdrq1WGuNOHw4A&s',
            ],
            [
                'name' => 'Ibufort',
                'dosage' => '800mg',
                'color' => 'Blue',
                'efficiencyTime' => '60 minutes',
                'aspect' => 'Tablet',
                'size' => 'Large',
                'conditionning' => 'Blister pack of 10',
                'secondaryEffects' => 'Gastric ulcers, dizziness',
                'format' => 'Oral',
                'administration' => 'Take with a full glass of water',
                'durationTime' => '8h',
                'specificCondition' => ["Adults only"],
                'description' => 'Ibufort est recommandé pour les douleurs sévères chez les adultes.',
                'molecule' => $molecule2,
                'imageUrl' =>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRwd43r5Q1vIFiYouJmixWrNO8l5Cha2347lw&s',
            ],
            [
                'name' => 'Morphoplus',
                'dosage' => '10mg',
                'color' => 'Clear',
                'efficiencyTime' => '10 minutes',
                'aspect' => 'Injection',
                'size' => 'N/A',
                'conditionning' => 'Ampoule of 5ml',
                'secondaryEffects' => 'Severe respiratory depression, addiction',
                'format' => 'Injection',
                'administration' => 'Administered intravenously by a healthcare professional',
                'durationTime' => '2h',
                'specificCondition' => ["Under strict medical supervision"],
                'description' => 'Morphoplus est un analgésique opioïde puissant utilisé pour soulager les douleurs intenses sous surveillance médicale stricte.',
                'molecule' => $molecule3,
                'imageUrl' => 'https://cdn-s-www.ledauphine.com/images/A88712EC-68AB-45BE-A737-F82FA104D852/MF_contenu/des-opioides-500-fois-plus-puissants-que-la-morphine-faut-il-s-inquieter-1702546088.jpg',
            ],
        ];

        // Création des médicaments et ajout de favoris pour l'utilisateur
        $favorites = [];
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
            $medicine->setDescription($data['description']);
            $medicine->setMolecule($data['molecule']);
            $medicine->setImageUrl($data['imageUrl']);

            $manager->persist($medicine);

            // Ajouter certains médicaments comme favoris pour l'utilisateur
            if (in_array($medicine->getName(), ['Têtoprane', 'Ibupraplus'])) {
                $user->addFav($medicine);
                $favorites[] = $medicine;
            }
        
            // Persister les changements pour les favoris
            $manager->persist($user);
            $manager->flush();
        }
    }
}