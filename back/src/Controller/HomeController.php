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
        $medicines = $em->getRepository(Medicine::class)->findAll();
        $names = array_map(function (Medicine $medicine) {
            return $medicine->getName();
        }, $medicines);

        return new JsonResponse($names);
    }

    /**
     * @Route("/api/medicines/{name}", name="api_medicine_details", methods={"GET"})
     */
    public function getMedicineDetails(string $name, EntityManagerInterface $em): JsonResponse
    {
        $medicine = $em->getRepository(Medicine::class)->findOneBy(['dosage' => $name]);

        if (!$medicine) {
            return new JsonResponse(['error' => 'Medicine not found'], 404);
        }

        $data = [
            'dosage' => $medicine->getDosage(),
            'color' => $medicine->getColor(),
            'efficiencyTime' => $medicine->getEfficiencyTime(),
            'aspect' => $medicine->getAspect(),
            'commonAffliction' => $medicine->getCommonAffliction(),
            'size' => $medicine->getSize(),
            'conditionning' => $medicine->getConditionning(),
            'secondaryEffects' => $medicine->getSecondaryEffects(),
            'format' => $medicine->getFormat(),
            'administration' => $medicine->getAdministration(),
            'durationTime' => $medicine->getDurationTime(),
            'specificCondition' => $medicine->getSpecificConditions(),
            'molecule' => $medicine->getMolecule()->getName(),
        ];

        return new JsonResponse($data);
    }
}
