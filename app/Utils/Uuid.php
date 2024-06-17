<?php

declare(strict_types=1);

namespace App\Utils;

class Uuid
{
    public static function generate(): string
    {
        return (string) \Ramsey\Uuid\Uuid::uuid7();
    }
}
