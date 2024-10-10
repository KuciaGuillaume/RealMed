<?php

namespace App\Controller;

use App\Entity\Medicine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/api/medicines", name="api_medicines", methods={"GET"})
     */
    public function getAllMedicines(EntityManagerInterface $em): JsonResponse
    {
        // Récupérer tous les médicaments
        $medicines = $em->getRepository(Medicine::class)->findAll();

        // Mapper chaque médicament pour inclure le nom et la description courte
        $medicinesData = array_map(function (Medicine $medicine) {
            return [
                'name' => $medicine->getName(),
                'shortDescription' => $medicine->getShortDescription()
            ];
        }, $medicines);

        // Retourner les données sous forme de JSON
        return new JsonResponse($medicinesData);
    }

    /**
     * @Route("/api/medicines/{name}", name="api_medicine_details", methods={"GET"})
     */
    public function getMedicineDetails(string $name, EntityManagerInterface $em): JsonResponse
    {
        $medicine = $em->getRepository(Medicine::class)->findOneBy(['name' => $name]);
        
        if (!$medicine) {
            return new JsonResponse(['error' => 'Medicine not found'], 404);
        }

        // Commencez par les données du médicament de base
        $baseMedicineData = [
            'name' => $medicine->getName(),
            'dosage' => $medicine->getDosage(),
            'color' => $medicine->getColor(),
            'efficiencyTime' => $medicine->getEfficiencyTime(),
            'aspect' => $medicine->getAspect(),
            'commonAffliction' => $medicine->getMolecule()->getCommonAffliction(),
            'size' => $medicine->getSize(),
            'conditioning' => $medicine->getConditioning(),
            'secondaryEffects' => $medicine->getSecondaryEffects(),
            'format' => $medicine->getFormat(),
            'administration' => $medicine->getAdministration(),
            'durationTime' => $medicine->getDurationTime(),
            'specificCondition' => $medicine->getSpecificConditions(),
            'molecule' => $medicine->getMolecule()->getName(),
            'secondaryEffectsDetails' => $medicine->getSecondaryEffectsDetailed(),
            'imageLink' => $medicine->getImageLink(),
            'shortDescription' => $medicine->getShortDescription(),
            'usage' => $medicine->getUsageInstructions(),
        ];

        // Récupérez les médicaments associés en excluant le médicament de base
        $relatedMedicines = $medicine->getMolecule()->getMedicine()->filter(function (Medicine $relatedMedicine) use ($medicine) {
            return $relatedMedicine->getId() !== $medicine->getId();
        });

        // Mappez les médicaments associés pour obtenir un tableau de données
        $relatedMedicinesData = $relatedMedicines->map(function (Medicine $relatedMedicine) {
            return [
                'name' => $relatedMedicine->getName(),
                'dosage' => $relatedMedicine->getDosage(),
                'color' => $relatedMedicine->getColor(),
                'efficiencyTime' => $relatedMedicine->getEfficiencyTime(),
                'aspect' => $relatedMedicine->getAspect(),
                'commonAffliction' => $relatedMedicine->getMolecule()->getCommonAffliction(),
                'size' => $relatedMedicine->getSize(),
                'conditioning' => $relatedMedicine->getConditioning(),
                'secondaryEffects' => $relatedMedicine->getSecondaryEffects(),
                'format' => $relatedMedicine->getFormat(),
                'administration' => $relatedMedicine->getAdministration(),
                'durationTime' => $relatedMedicine->getDurationTime(),
                'specificCondition' => $relatedMedicine->getSpecificConditions(),
                'molecule' => $relatedMedicine->getMolecule()->getName(),
                'secondaryEffectsDetails' => $relatedMedicine->getSecondaryEffectsDetailed(),
                'imageLink' => $relatedMedicine->getImageLink(),
                'shortDescription' => $relatedMedicine->getShortDescription(),
                'usage' => $relatedMedicine->getUsageInstructions(),
            ];
        })->toArray();

        // Combinez les données du médicament de base avec celles des médicaments associés
        $data = array_merge([$baseMedicineData], $relatedMedicinesData);

        return new JsonResponse($data);
    }
}
