<?php

namespace App\Dto\Response\Auth;

use App\Dto\Response\User\UserResponse;
use App\Entity\User;
use OpenApi\Attributes as OA;
final readonly class SuccessRegistrationResponse
{
    #[OA\Property(example: true)]
    public bool $success;

    public UserResponse $user;

    #[OA\Property(description: 'JWT token for access', example: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...')]
    public string $token;

    public function __construct(User $user, string $token)
    {
        $this->success = true;
        $this->user = new UserResponse($user);
        $this->token = $token;
    }
}
