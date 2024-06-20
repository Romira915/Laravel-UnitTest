<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GetIndexController;
use App\Http\Requests\Auth\PostAuthRegisterRequest;
use App\Models\UserEloquent;
use App\Utils\Uuid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostAuthRegisterController extends Controller
{
    public function __invoke(PostAuthRegisterRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user_id = Uuid::generate();

            $user = UserEloquent::create([
                'id' => $user_id,
            ]);
            $user->userDetailEloquent()->create([
                'display_name' => $request->display_name,
                'icon_path' => $request->file('user_icon')->store('public/user_icons'),
            ]);
            $user->userHashedPasswordEloquent()->create([
                'hashed_password' => bcrypt($request->password),
            ]);

            Auth::login($user);
        });

        return redirect()->action(GetIndexController::class);
    }
}
