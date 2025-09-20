<?php

namespace App\Dto\Permissions;

class UpdatePermissionDTO
{
    public function __construct(
        public ?string $name = null,
        public ?string $description = null
    ) {}
}
