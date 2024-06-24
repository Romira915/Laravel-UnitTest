<?php

namespace App\Providers;

use App\Domain\Validator\TagValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Validator::extend('tag_max_length', function ($attribute, $value, $parameters, $validator) {
            return TagValidator::validate($value);
        });
    }
}
