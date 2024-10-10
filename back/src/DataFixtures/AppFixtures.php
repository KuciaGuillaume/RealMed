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

        $medicinesData = [
            [
                'molecule' => $molecule1,
                'dosage' => '500mg Paracetamol, 30mg Codeine',
                'color' => 'Blanc',
                'efficiencyTime' => '30-60 minutes',
                'aspect' => 'Tablet',
                'size' => 'Moyen',
                'secondaryEffects' => 'Drowsiness, Constipation, Risk of addiction',
                'format' => 'Oral',
                'administration' => "Avaler avec de l'eau",
                'durationTime' => '4-6h',
                'specificCondition' => ["man_adult", "woman_adult", "senior_man", "senior_woman"],
                'name' => 'Doliprane Codeine',
                'conditionning' => ['paracetamol', 'codeine'],
                'secondary_effects_detailed' => [
                    ["name" => "Somnolence", "severity" => 1],
                    ["name" => "Constipation", "severity" => 2],
                    ["name" => "Risque de dépendance", "severity" => 3],
                    ["name" => "Nausées", "severity" => 2],
                    ["name" => "Diminution de la concentration", "severity" => 2]
                ],
                'imageUrl' => 'https://cdn.pim.mesoigner.fr/mesoigner/59251fc83589aa0229d149af35f6da6d/mesoigner-thumbnail-1000-1000-inset/372/603/codoliprane-500-mg-30-mg-comprime.webp',
                'description' => 'Un comprimé combinant du paracétamol et de la codéine pour soulager les douleurs modérées à sévères.',
                'usage_instructions' => 'Prendre 1 comprimé avec un verre d\'eau, ne pas dépasser la dose recommandée.'
            ],
            [
                'molecule' => $molecule1,
                'dosage' => '1000mg',
                'color' => 'Blanc',
                'efficiencyTime' => '45 minutes',
                'aspect' => 'Tablet',
                'size' => 'Large',
                'secondaryEffects' => 'Liver toxicity if overdosed',
                'format' => 'Oral',
                'administration' => "Avaler avec de l'eau",
                'durationTime' => '6-8h',
                'specificCondition' => ["man_adult", "woman_adult", "senior_man", "senior_woman"],
                'name' => 'Doliprane 1000mg Tablet',
                'conditionning' => ['paracetamol'],
                'secondary_effects_detailed' => [
                    ["name" => "Toxicité hépatique", "severity" => 3],
                    ["name" => "Fatigue", "severity" => 1],
                    ["name" => "Somnolence", "severity" => 1],
                    ["name" => "Douleurs musculaires", "severity" => 2]
                ],
                'imageUrl' => 'https://www.pharma-gdd.com/media/cache/resolve/product_show/333430303933353935353833382d646f6c697072616e652d313030306d672d382d636f6d7072696d657313e8670f.jpg',
                'description' => 'Destiné à soulager les douleurs fortes et prolongées.',
                'usage_instructions' => 'Prendre 1 comprimé avec de l\'eau toutes les 6 à 8 heures selon les besoins.'
            ],
            [
                'molecule' => $molecule1,
                'dosage' => '500mg',
                'color' => 'Blanc',
                'efficiencyTime' => '30 minutes',
                'aspect' => 'Tablet',
                'size' => 'Moyen',
                'secondaryEffects' => 'Nausea, Allergic reactions',
                'format' => 'Oral',
                'administration' => "Avaler avec de l'eau",
                'durationTime' => '4-6h',
                'specificCondition' => ["man_adult", "woman_adult", "senior_man", "senior_woman"],
                'name' => 'Doliprane 500mg Tablet',
                'conditionning' => ['paracetamol'],
                'secondary_effects_detailed' => [
                    ["name" => "Nausées", "severity" => 2],
                    ["name" => "Réactions allergiques", "severity" => 3],
                    ["name" => "Maux de tête", "severity" => 1],
                    ["name" => "Urticaire", "severity" => 2],
                    ["name" => "Éruption cutanée", "severity" => 2]
                ],
                'imageUrl' => 'https://s2.euro-pharmas.com/4138-large_default/doliprane-500mg-paracetamol-tablets.jpg',
                'description' => 'Analgésique courant pour traiter la fièvre et les douleurs légères à modérées.',
                'usage_instructions' => 'Prendre 1 à 2 comprimés avec de l\'eau toutes les 4 à 6 heures, sans dépasser 3 g par jour.'
            ],
            [
                'molecule' => $molecule1,
                'dosage' => '2.4g/100ml',
                'color' => 'Pink',
                'efficiencyTime' => '15 minutes',
                'aspect' => 'Syrup',
                'size' => 'N/A',
                'secondaryEffects' => 'Possible skin rash',
                'format' => 'Oral',
                'administration' => 'Measure with provided syringe',
                'durationTime' => '4-6h',
                'specificCondition' => ["child"],
                'name' => 'Doliprane Syrup 2.4%',
                'conditionning' => ['paracetamol'],
                'secondary_effects_detailed' => [
                    ["name" => "Éruption cutanée possible", "severity" => 2],
                    ["name" => "Gonflements", "severity" => 3],
                    ["name" => "Rougeurs", "severity" => 1],
                    ["name" => "Irritations cutanées", "severity" => 2]
                ],
                'imageUrl' => 'https://moncoinsante.com/mcs/65565-large_default/doliprane-sirop-sans-sucre-paracetamol-2-4-flacon-de-100ml-douleurs-et-fievre-de-l-enfant-de-3-a-26-kg.jpg',
                'description' => 'Sirop destiné aux enfants pour traiter la fièvre et les douleurs légères.',
                'usage_instructions' => 'Utiliser la seringue fournie pour mesurer la dose et administrer par voie orale.'
            ],
            [
                'molecule' => $molecule1,
                'dosage' => '300mg',
                'color' => 'Yellow',
                'efficiencyTime' => '10 minutes',
                'aspect' => 'Powder',
                'size' => 'Small sachet',
                'secondaryEffects' => 'Stomach upset',
                'format' => 'Oral',
                'administration' => 'Mix with water before drinking',
                'durationTime' => '5h',
                'specificCondition' => ["man_adult", "woman_adult", "senior_man", "senior_woman"],
                'name' => 'Paracétamol sachet',
                'conditionning' => ['paracetamol'],
                'secondary_effects_detailed' => [
                    ["name" => "Maux d’estomac", "severity" => 2],
                    ["name" => "Nausées", "severity" => 2],
                    ["name" => "Vomissements", "severity" => 2],
                    ["name" => "Diarrhée", "severity" => 2],
                    ["name" => "Fatigue", "severity" => 1]
                ],
                'imageUrl' => 'https://www.pharma-gdd.com/media/cache/resolve/product_show/333430303933343939393435312d646f6c697072616e652d3330306d672d31322d73616368657473ed0ef649.jpg',
                'description' => 'Une forme en poudre facile à dissoudre pour un soulagement rapide des douleurs.',
                'usage_instructions' => 'Dissoudre un sachet dans de l\'eau et boire immédiatement, jusqu\'à 4 fois par jour.'
            ],
            [
                'molecule' => $molecule1,
                'dosage' => '1000mg',
                'color' => 'Blanc',
                'efficiencyTime' => '45 minutes',
                'aspect' => 'Capsule',
                'size' => 'Large',
                'secondaryEffects' => 'Liver toxicity if overdosed',
                'format' => 'Oral',
                'administration' => "Avaler avec de l'eau",
                'durationTime' => '6-8h',
                'specificCondition' => ["man_adult", "woman_adult", "senior_man", "senior_woman"],
                'name' => 'Doliprane 1000mg Capsule',
                'conditionning' => ['paracetamol'],
                'secondary_effects_detailed' => [
                    ["name" => "Toxicité hépatique", "severity" => 3],
                    ["name" => "Nausées", "severity" => 2],
                    ["name" => "Douleurs abdominales", "severity" => 2],
                    ["name" => "Vomissements", "severity" => 2],
                    ["name" => "Insuffisance hépatique", "severity" => 3]
                ],
                'imageUrl' => 'https://s3.euro-pharmas.com/3578-large_default/doliprane-1000mg-8-capsules-sanofi.jpg',
                'description' => 'Capsule facile à avaler pour traiter les douleurs intenses.',
                'usage_instructions' => 'Avaler une capsule avec un verre d\'eau, ne pas dépasser 3 capsules par jour.'
            ],
            [
                'molecule' => $molecule1,
                'dosage' => '1000mg',
                'color' => 'Colorless',
                'efficiencyTime' => '15 minutes',
                'aspect' => 'Oral Suspension',
                'size' => 'N/A',
                'secondaryEffects' => 'Nausea, Stomach upset',
                'format' => 'Oral',
                'administration' => 'Drink directly from sachet',
                'durationTime' => '6-8h',
                'specificCondition' => ["man_adult", "woman_adult", "senior_man", "senior_woman"],
                'name' => 'Doliprane Liquiz 1000mg',
                'conditionning' => ['paracetamol'],
                'secondary_effects_detailed' => [
                    ["name" => "Nausées", "severity" => 2],
                    ["name" => "Maux d’estomac", "severity" => 2],
                    ["name" => "Somnolence", "severity" => 1],
                    ["name" => "Vertiges", "severity" => 1]
                ],
                'imageUrl' => 'https://universpharmacie.fr/26714-large_default/doliprane-liquiz-1000mg-8-sachets.webp',
                'description' => 'Suspension buvable pour un soulagement rapide des douleurs.',
                'usage_instructions' => 'Boire directement à partir du sachet ou diluer dans un peu d\'eau.'
            ],
            [
                'molecule' => $molecule1,
                'dosage' => '300mg',
                'color' => 'Blanc',
                'efficiencyTime' => '30 minutes',
                'aspect' => 'Suppository',
                'size' => 'Moyen',
                'secondaryEffects' => 'Rectal irritation',
                'format' => 'Rectal',
                'administration' => 'Insert into rectum',
                'durationTime' => '4-6h',
                'specificCondition' => ["child"],
                'name' => 'Doliprane Suppository 300mg',
                'conditionning' => ['paracetamol'],
                'secondary_effects_detailed' => [
                    ["name" => "Irritation rectale", "severity" => 2],
                    ["name" => "Fatigue", "severity" => 1],
                    ["name" => "Nausées", "severity" => 2],
                    ["name" => "Diarrhée", "severity" => 2]
                ],
                'imageUrl' => 'https://www.illicopharma.com/77034-thickbox_default/doliprane-300mg-suppositoire.jpg',
                'description' => 'Pour traiter les douleurs modérées et la fièvre.',
                'usage_instructions' => 'Insérer le suppositoire par voie rectale après avoir nettoyé la zone.'
            ],
            [
                'molecule' => $molecule1,
                'dosage' => '500mg',
                'color' => 'Blanc',
                'efficiencyTime' => '15 minutes',
                'aspect' => 'Powder Sachet',
                'size' => 'Small',
                'secondaryEffects' => 'Nausea, Dizziness',
                'format' => 'Oral',
                'administration' => 'Mix with water before drinking',
                'durationTime' => '4-6h',
                'specificCondition' => ["man_adult", "woman_adult", "senior_man", "senior_woman"],
                'name' => 'Doliprane Sachet 500mg',
                'conditionning' => ['paracetamol'],
                'secondary_effects_detailed' => [
                    ["name" => "Nausées", "severity" => 2],
                    ["name" => "Vertiges", "severity" => 1],
                    ["name" => "Brûlures d’estomac", "severity" => 2],
                    ["name" => "Ballonnements", "severity" => 1],
                    ["name" => "Irritations de l’estomac", "severity" => 2]
                ],
                'imageUrl' => 'https://www.pharmacie-prado-mermoz.com/client/840002/media/files/Doliprane-500-mg-20974_101_1397668349.jpg',
                'description' => 'Une forme en poudre à mélanger avec de l\'eau pour un soulagement rapide.',
                'usage_instructions' => 'Mélanger le contenu du sachet dans de l\'eau et boire immédiatement.'
            ],
            [
                'molecule' => $molecule1,
                'dosage' => '500mg Paracetamol, 150mg Vitamin C',
                'color' => 'Orange',
                'efficiencyTime' => '20 minutes',
                'aspect' => 'Effervescent Tablet',
                'size' => 'Large',
                'secondaryEffects' => 'Stomach irritation',
                'format' => 'Oral',
                'administration' => 'Dissolve in water before drinking',
                'durationTime' => '4-6h',
                'specificCondition' => ["man_adult", "woman_adult", "senior_man", "senior_woman"],
                'name' => 'Doliprane Vitamine C',
                'conditionning' => ['paracetamol'],
                'secondary_effects_detailed' => [
                    ["name" => "Irritation de l’estomac", "severity" => 2],
                    ["name" => "Vomissements", "severity" => 2],
                    ["name" => "Douleurs abdominales", "severity" => 2],
                    ["name" => "Fatigue", "severity" => 1]
                ],
                'imageUrl' => 'https://pharmaciebastille.com/36201-large_default/doliprane-vit-c-tbe-16-cp-fr.jpg',
                'description' => 'Pour combattre la douleur et fournir une dose de vitamine C.',
                'usage_instructions' => 'Dissoudre un comprimé effervescent dans un verre d\'eau avant de boire.'
            ],
            [
                'molecule' => $molecule1,
                'dosage' => '250mg',
                'color' => 'Blanc',
                'efficiencyTime' => '15 minutes',
                'aspect' => 'Orodispersible Tablet',
                'size' => 'Small',
                'secondaryEffects' => 'Rare allergic reactions',
                'format' => 'Oral',
                'administration' => 'Place on tongue to dissolve',
                'durationTime' => '4-6h',
                'specificCondition' => ["child", "teenager"],
                'name' => 'Doliprane Orodispersible 250mg',
                'conditionning' => ['paracetamol'],
                'secondary_effects_detailed' => [
                    ["name" => "Réactions allergiques rares", "severity" => 3],
                    ["name" => "Éruptions cutanées", "severity" => 2],
                    ["name" => "Gonflement", "severity" => 3],
                    ["name" => "Difficultés respiratoires", "severity" => 3]
                ],
                'imageUrl' => 'https://www.pharma-gdd.com/media/cache/resolve/product_show/757073612d6566666572616c67616e2d6d65642d3235306d672d656e66616e742d64652d31332d612d35306b672d62616e616e652d31322d636f6d7072696d65732d66616365a8bd2d75.jpg',
                'description' => 'Une tablette qui se dissout rapidement pour un soulagement des douleurs.',
                'usage_instructions' => 'Placer un comprimé sur la langue et laisser dissoudre, sans eau.'
            ],
            [
                'molecule' => $molecule1,
                'dosage' => '150mg',
                'color' => 'Blanc',
                'efficiencyTime' => '30 minutes',
                'aspect' => 'Suppository',
                'size' => 'Small',
                'secondaryEffects' => 'Rectal irritation',
                'format' => 'Rectal',
                'administration' => 'Insert into rectum',
                'durationTime' => '4-6h',
                'specificCondition' => ["baby", "child"],
                'name' => 'Doliprane Suppository 150mg',
                'conditionning' => ['paracetamol'],
                'secondary_effects_detailed' => [
                    ["name" => "Irritation rectale", "severity" => 2],
                    ["name" => "Douleurs abdominales", "severity" => 2],
                    ["name" => "Somnolence", "severity" => 1],
                    ["name" => "Sensation de brûlure", "severity" => 2]
                ],
                'imageUrl' => 'https://moncoinsante.com/mcs/66286-large_default/doliprane-paracetamol-150-mg-baby-suppositories-8-12-kg-pack-of-10-.jpg',
                'description' => 'Une forme adaptée pour les enfants pour traiter les douleurs et la fièvre.',
                'usage_instructions' => 'Insérer le suppositoire dans le rectum après avoir lubrifié l\'extrémité.'
            ]
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
            $medicine->setConditioning($data['conditionning']);
            $medicine->setSecondaryEffects($data['secondaryEffects']);
            $medicine->setFormat($data['format']);
            $medicine->setAdministration($data['administration']);
            $medicine->setDurationTime($data['durationTime']);
            $medicine->setSpecificConditions($data['specificCondition']);
            $medicine->setShortDescription($data['description']);
            $medicine->setMolecule($data['molecule']);
            $medicine->setImageLink($data['imageUrl']);
            $medicine->setUsageInstructions($data['usage_instructions']);
            $medicine->setSecondaryEffectsDetailed($data['secondary_effects_detailed']);

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