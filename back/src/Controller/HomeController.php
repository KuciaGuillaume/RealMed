<?php

namespace App\Controller;

use App\Entity\Medicine;
use App\Entity\SecondaryEffect;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        $user = $this->getUser();
        
        // Mapper chaque médicament pour inclure le nom et la description courte
        $medicinesData = array_map(function (Medicine $medicine) use ($user) {
            $medicineData = [
                'name' => $medicine->getName(),
                'shortDescription' => $medicine->getShortDescription()
            ];

            if ($user) {
                $medicineData['is_favorite'] = $user->isFavs($medicine);
            }

            return $medicineData;

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
            return new JsonResponse(['error' => 'medicine_not_found'], 404);
        }

        // Récupère l'utilisateur connecté, si disponible
        $user = $this->getUser();

        // Récupération des effets secondaires via la molécule
        $molecule = $medicine->getMolecule();
        $molecule = $medicine->getMolecule();
        $moleculeSecondaryEffects = $molecule ? $molecule->getSecondaryEffects()->map(function (SecondaryEffect $effect) {
            return [
                'name' => $effect->getName(),
                'severity' => $effect->getSeverity(),
                'severity_score' => $effect->getSeverityScore(),
            ];
        })->toArray() : [];

        $baseMedicineData = [
            'name' => $medicine->getName(),
            'dosage' => $medicine->getDosage(),
            'color' => $medicine->getColor(),
            'efficiencyTime' => $medicine->getEfficiencyTime(),
            'aspect' => $medicine->getAspect(),
            'commonAffliction' => $molecule ? $molecule->getCommonAffliction() : null,
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
            'isFavorite' => $user ? $user->isFavs($medicine) : false,
        ];

        // Récupérez les médicaments associés en excluant le médicament de base
        $relatedMedicines = $medicine->getMolecule()->getMedicine()->filter(function (Medicine $relatedMedicine) use ($medicine) {
            return $relatedMedicine->getId() !== $medicine->getId();
        });

        // Mappez les médicaments associés pour obtenir un tableau de données
        $relatedMedicinesData = $relatedMedicines->map(function (Medicine $relatedMedicine) {
            $user = $this->getUser();
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
                'isFavorite' => $user ? $user->isFavs($relatedMedicine) : false,
            ];
        })->toArray();

        // Combinez les données du médicament de base avec celles des médicaments associés
        $data = array_merge([$baseMedicineData], $relatedMedicinesData);

        return new JsonResponse($data);
    }
    
    
    /**
     * @Route("/api/medicines/favorite", name="api_add_favorite", methods={"POST"})
     */
    public function addFavorite(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $name = $request->request->get('name');
        $user = $this->getUser();
    
        // Vérifie si l'utilisateur est connecté
        if (!$user) {
            return new JsonResponse(['error' => 'authentication_required'], 401);
        }
    
        // Récupère le médicament à partir de son nom
        $medicine = $em->getRepository(Medicine::class)->findOneBy(['name' => $name]);
    
        if (!$medicine) {
            return new JsonResponse(['error' => 'medicine_not_found'], 404);
        }
    
        // Vérifie si le médicament est déjà dans les favoris de l'utilisateur
        if ($user->isFavs($medicine)) {
            return new JsonResponse(['message' => 'medicine_already_in_favorites'], 200);
        }
    
        // Ajoute le médicament aux favoris de l'utilisateur
        $user->addFav($medicine);
    
        // // Persiste les modifications dans la base de données
        $em->persist($user);
        $em->flush();
    
        return new JsonResponse(['message' => 'medicine_added_to_favorites'], 201);
    }

    /**
     * @Route("/api/medicines/favorite/remove", name="api_remove_favorite", methods={"POST"})
     */
    public function removeFavorite(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $name = $request->request->get('name');
        $user = $this->getUser();
    
        // Vérifie si l'utilisateur est connecté
        if (!$user) {
            return new JsonResponse(['error' => 'authentication_required'], 401);
        }
    
        // Récupère le médicament à partir de son nom
        $medicine = $em->getRepository(Medicine::class)->findOneBy(['name' => $name]);
    
        if (!$medicine) {
            return new JsonResponse(['error' => 'medicine_not_found'], 404);
        }
    
        // Vérifie si le médicament est déjà dans les favoris de l'utilisateur
        if (!$user->isFavs($medicine)) {
            return new JsonResponse(['message' => 'medicine_not_in_favorites'], 200);
        }
    
        // Supprime le médicament des favoris de l'utilisateur
        $user->removeFav($medicine);
    
        // Persiste les modifications dans la base de données
        $em->persist($user);
        $em->flush();
    
        return new JsonResponse(['message' => 'medicine_removed_from_favorites'], 200);
    }

    /**
     * @Route("/api/user/favorites", name="api_user_favorites", methods={"GET"})
     */
    public function getUserFavorites(EntityManagerInterface $em): JsonResponse
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();

        // Vérifie si l'utilisateur est connecté
        if (!$user) {
            return new JsonResponse(['error' => 'authentication_required'], 401);
        }

        // Récupère les favoris de l'utilisateur
        $favorites = $user->getFavs();

        // Convertit les favoris en un tableau de données
        $data = $favorites->map(function (Medicine $medicine) {
            // Récupération des effets secondaires via la molécule
            $molecule = $medicine->getMolecule();
            $moleculeSecondaryEffects = $molecule ? $molecule->getSecondaryEffects()->map(function (SecondaryEffect $effect) {
                return [
                    'name' => $effect->getName(),
                    'severity' => $effect->getSeverity(),
                    'severity_score' => $effect->getSeverityScore(),
                ];
            })->toArray() : [];

            return [
                'name' => $medicine->getName(),
                'shortDescription' => $medicine->getShortDescription(),
                'imageLink' => $medicine->getImageLink(),
                'dosage' => $medicine->getDosage(),
                'color' => $medicine->getColor(),
                'efficiency_time' => $medicine->getEfficiencyTime(),
                'aspect' => $medicine->getAspect(),
                'common_affliction' => $molecule ? $molecule->getCommonAffliction() : null,
                'size' => $medicine->getSize(),
                'conditioning' => $medicine->getConditioning(),
                'secondary_effects' => $moleculeSecondaryEffects,
                'format' => $medicine->getFormat(),
                'administration' => $medicine->getAdministration(),
                'duration_time' => $medicine->getDurationTime(),
                'specific_conditions' => $medicine->getSpecificConditions(),
                'molecule' => $molecule ? $molecule->getName() : null,
            ];
        })->toArray();

        return new JsonResponse($data, 200);
    }
}
