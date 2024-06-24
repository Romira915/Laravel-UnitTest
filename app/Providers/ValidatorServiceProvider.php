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
        Validator::extend('article_tags', function ($attribute, $value, $parameters, $validator) {
            foreach ($value as $tag) {
                if (!TagValidator::validate($tag)) {
                    return false;
                }
            }

            return true;
        });
    }
}
