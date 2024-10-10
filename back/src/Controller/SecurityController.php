<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request, SessionInterface $session): JsonResponse
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        // Vérifiez les informations d'identification ici et démarrez une session si elles sont valides
        if ($this->authService->isValidCredentials($username, $password)) {
            $session->start();
            $session->set('user', $username);

            // Envoi du cookie de session
            return new JsonResponse(['message' => 'Login successful'], Response::HTTP_OK, [
                'Set-Cookie' => 'PHPSESSID=' . $session->getId() . '; Path=/; HttpOnly; Secure'
            ]);
        }

        return new JsonResponse(['message' => 'Login failed'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET", "POST"})
     */
    public function logout(): void
    {
        throw new \LogicException('Cette méthode peut être vide - elle sera interceptée par la clé logout de votre firewall.');
    }

    /**
     * @Route("/session/check", name="session_check", methods={"GET"})
     */
    public function checkSession(Request $request): JsonResponse
    {
        $session = $request->getSession();

        // Log de débogage pour voir si la session est bien reçue
        error_log('Session ID: ' . $session->getId());
    
        if (!$session->isStarted()) {
            $session->start();
        }

        $user = $this->getUser();
        if ($user) {
            return new JsonResponse(['sessionValid' => true, 'user' => $user->getUsername()], Response::HTTP_OK);
        } else {
            return new JsonResponse(['sessionValid' => false], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * @Route("/user/check/{username}", name="user_check", methods={"GET"})
     */
    public function checkUser(UserRepository $userRepository, string $username): JsonResponse
    {
        $user = $userRepository->findOneBy(['username' => $username]);

        if ($user) {
            return new JsonResponse(['exists' => true], Response::HTTP_OK);
        } else {
            return new JsonResponse(['exists' => false], Response::HTTP_NOT_FOUND);
        }
    }
}