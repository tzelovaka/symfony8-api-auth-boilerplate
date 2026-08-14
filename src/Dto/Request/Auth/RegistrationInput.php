<?php

namespace App\Dto\Request\Auth;

use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

readonly class RegistrationInput
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        #[OA\Property(description: 'User email', example: 'user@example.com')]
        public string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 6)]
        #[OA\Property(description: 'Password (min: 6 symbols)', example: 'secret123')]
        public string $password,
    ) {
    }
}
