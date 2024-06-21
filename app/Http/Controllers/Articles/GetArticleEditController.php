<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetArticleEditController extends Controller
{


    public function __invoke(Request $request, string $article_id)
    {
        $current_user = $request->user();

        return view('article_edit', [
            'current_user_id' => $current_user->id,
            'current_user_display_name' => $current_user->userDetailEloquent->display_name,
            'current_user_icon_path' => $current_user->userDetailEloquent->icon_path,
        ]);
    }
}
