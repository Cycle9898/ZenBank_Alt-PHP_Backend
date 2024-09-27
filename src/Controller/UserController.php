<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class UserController extends AbstractController
{
    #[Route('/sign-up', name: 'app_users_sign-up', methods: ["POST"])]
    public function signUpUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $newUser = $serializer->deserialize($request->getContent(), User::class, 'json');
        $newUser->setPassword($userPasswordHasher->hashPassword($newUser, $newUser->getPassword()));

        $manager->persist($newUser);
        $manager->flush();

        $userId = $newUser->getId();

        return new JsonResponse([
            'status' => 201,
            'message' => "User with ID: '$userId' created !"
        ], Response::HTTP_CREATED);
    }
}
