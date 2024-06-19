<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PostAuthLoginRequest;
use App\Models\UserEloquent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostAuthLoginController extends Controller
{
    public function __invoke(PostAuthLoginRequest $request): RedirectResponse
    {
        if (Auth::attempt($request->toArray())) {
            $request->session()->regenerate();
            Log::info($request->display_name . ' logged in');
            Log::info('login to ' . UserEloquent::with('userDetailEloquent')->whereRelation('userDetailEloquent', 'display_name', $request->display_name)->first());

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'auth_login' => 'The provided credentials do not match our records.',
        ])->onlyInput('display_name');
    }
}
