<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils): JsonResponse
    {
        if ($this->getUser()) {
            return $this->json([
                'message' => 'You are already logged in',
                'user' => $this->getUser()->getUsername()
            ], 200);
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error instanceof AuthenticationException) {
            return $this->json([
                'message' => 'Invalid credentials',
                'error' => $error->getMessageKey()
            ], 401);
        }

        return $this->json([
            'message' => 'Authentication required',
            'last_username' => $lastUsername,
        ], 401);
    }

    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     */
    public function adminLogin(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET", "POST"})
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/api/logout", name="api_logout", methods={"POST"})
     */
    public function apiLogout(): JsonResponse
    {
        return new JsonResponse(['message' => 'logout_successful'], 200);
    }
}
