<?php
// src/Controller/UserController.php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user/new", name="user_new", methods={"POST"})
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        $username = $request->request->get('username');
        $plainPassword = $request->request->get('password');

        if (!$username || !$plainPassword) {
            return new Response('Le username et le password sont requis.', Response::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $user->setUsername($username);

        $encodedPassword = $passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($encodedPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('Utilisateur créé avec succès', Response::HTTP_CREATED);
    }
}
