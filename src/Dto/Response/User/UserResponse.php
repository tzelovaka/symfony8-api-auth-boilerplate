<?php

namespace App\Dto\Response\User;

use App\Entity\User;
use OpenApi\Attributes as OA;

final readonly class UserResponse
{
    #[OA\Property(example: '018f6e2b-ec1d-7a54-8153-f222d0577717')]
    public string $id;

    #[OA\Property(example: 'user@example.com')]
    public string $email;

    #[OA\Property(example: ['ROLE_USER'])]
    public array $roles;

    public function __construct(User $user)
    {
        $this->id = $user->getId()->toRfc4122();
        $this->email = $user->getEmail();
        $this->roles = $user->getRoles();
    }
}
