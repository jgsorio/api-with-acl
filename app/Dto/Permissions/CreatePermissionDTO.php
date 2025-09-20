<?php

namespace App\Dto\Permissions;

class CreatePermissionDTO
{
    public function __construct(
        public string $name,
        public ?string $description = ''
    ) {}
}
