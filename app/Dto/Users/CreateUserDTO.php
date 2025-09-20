<?php

namespace App\Dto\Users;

class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}
}
