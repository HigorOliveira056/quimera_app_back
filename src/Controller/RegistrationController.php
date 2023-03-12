<?php

namespace App\Controller;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Entity\Professor;

class RegistrationController extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager
    )
    {
    }

    #[Route('/registration', name: 'app_registration')]
    public function registration(Request $request): JsonResponse
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $professor = new Professor();
        $passwordHash = $this->passwordHasher->hashPassword($professor, $password);
        $professor->setEmail($email)
                ->setPassword($passwordHash);

        return $this->json([
            'message' => 'Prefessor registrated with success',
            'success' => true,
        ]);
    }
}
