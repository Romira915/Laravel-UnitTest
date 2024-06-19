<?php

declare(strict_types=1);

namespace App\Http\DTO;

class CurrentUserDTO
{
    public function __construct(
        public string $id,
        public string $display_name,
        public string $icon_path,
    )
    {
    }
}
