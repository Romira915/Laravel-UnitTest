<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PostAuthRegisterRequest;

class PostAuthRegisterController extends Controller
{
    public function __invoke(PostAuthRegisterRequest $request)
    {
        return "PostAuthRegisterController called";
    }
}
