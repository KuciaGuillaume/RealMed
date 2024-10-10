<?php

namespace App\Controller;

use App\Entity\Medicine;
use App\Entity\SecondaryEffect;
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
        $user = $this->getUser();

        $data = array_map(function (Medicine $medicine) use ($user) {
            $medicineData = [
                'name' => $medicine->getName(),
                'description' => $medicine->getDescription(),
            ];

            if ($user) {
                $medicineData['is_favorite'] = $user->isFavs($medicine);
            }

            return $medicineData;
        }, $medicines);

        return new JsonResponse($data);
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
        $isFavorite = false;

        // Si l'utilisateur est connecté, vérifie si le médicament est en favori
        if ($user) {
            $isFavorite = $user->getFavorites()->contains($medicine);
        }

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

        $data = [
            'name' => $medicine->getName(),
            'dosage' => $medicine->getDosage(),
            'color' => $medicine->getColor(),
            'efficiency_time' => $medicine->getEfficiencyTime(),
            'aspect' => $medicine->getAspect(),
            'common_affliction' => $molecule ? $molecule->getCommonAffliction() : null,
            'size' => $medicine->getSize(),
            'conditionning' => $medicine->getConditionning(),
            'secondary_effects' => $moleculeSecondaryEffects,
            'format' => $medicine->getFormat(),
            'administration' => $medicine->getAdministration(),
            'duration_time' => $medicine->getDurationTime(),
            'specific_conditions' => $medicine->getSpecificConditions(),
            'molecule' => $molecule ? $molecule->getName() : null,
            'description' => $medicine->getDescription(),
            'image_url' => $medicine->getImageUrl(),
            'other_medicines' => $molecule ? $molecule->getMedicine()->map(function (Medicine $otherMedicine) {
                return $otherMedicine->getName();
            })->toArray() : [],
            'is_favorite' => $isFavorite,
        ];

        return new JsonResponse($data);
    }
    /**
     * @Route("/api/medicines/{name}/favorite", name="api_add_favorite", methods={"POST"})
     */
    public function addFavorite(string $name, EntityManagerInterface $em): JsonResponse
    {
        // Récupère l'utilisateur connecté
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
        if ($user->getFavs()->contains($medicine)) {
            return new JsonResponse(['message' => 'medicine_already_in_favorites'], 200);
        }

        // Ajoute le médicament aux favoris de l'utilisateur
        $user->addFavs($medicine);

        // Persiste les modifications dans la base de données
        $em->persist($user);
        $em->flush();

        return new JsonResponse(['message' => 'medicine_added_to_favorites'], 201);
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
                'description' => $medicine->getDescription(),
                'image_url' => $medicine->getImageUrl(),
                'dosage' => $medicine->getDosage(),
                'color' => $medicine->getColor(),
                'efficiency_time' => $medicine->getEfficiencyTime(),
                'aspect' => $medicine->getAspect(),
                'common_affliction' => $molecule ? $molecule->getCommonAffliction() : null,
                'size' => $medicine->getSize(),
                'conditionning' => $medicine->getConditionning(),
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
