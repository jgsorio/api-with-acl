<?php

namespace App\Dto\Users;

class UpdateUserDTO
{
    public function __construct(
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null
    ) {}
}
