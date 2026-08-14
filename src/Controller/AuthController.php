<?php

namespace App\Controller;

use App\Dto\Request\Auth\RegistrationInput;
use App\Dto\Response\Auth\SuccessRegistrationResponse;
use App\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class AuthController extends AbstractController
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface      $entityManager,
        private readonly JWTTokenManagerInterface      $JWTTokenManager
    ) {
    }

    #[Route('/auth/register', name: 'auth_register', methods: ['POST'])]
    #[OA\Post(
        path: '/auth/register',
        summary: 'New user registration',
        tags: ['Authentication']
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: new Model(type: RegistrationInput::class))
    )]
    #[OA\Response(
        response: 201,
        description: 'User has registered successfully',
        content: new OA\JsonContent(ref: new Model(type: SuccessRegistrationResponse::class))
    )]
    #[OA\Response(
        response: 409,
        description: 'Conflict with registration',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'error', type: 'string', example: 'Пользователь с таким email уже зарегистрирован')
            ]
        )
    )]
    public function register(#[MapRequestPayload] RegistrationInput $input): JsonResponse
    {
        $user = new User();
        $user->setEmail($input->email);
        $user->setRoles(['ROLE_USER']);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $input->password);
        $user->setPassword($hashedPassword);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            return new JsonResponse(
                ['error' => 'Пользователь с таким email уже зарегистрирован'],
                Response::HTTP_CONFLICT
            );
        }

        $token = $this->JWTTokenManager->create($user);
        $responseDto = new SuccessRegistrationResponse($user, $token);

        return $this->json($responseDto, Response::HTTP_CREATED);
    }
}
