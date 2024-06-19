<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetIndexController;
use Illuminate\Support\Facades\Auth;

class GetAuthLoginController extends Controller
{
    public function __invoke()
    {
        if (Auth::check()) {
            return redirect()->action(GetIndexController::class);
        }

        return view('auth.login');
    }
}
