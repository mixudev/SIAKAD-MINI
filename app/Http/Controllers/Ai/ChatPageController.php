<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;

class ChatPageController extends Controller
{
    public function __invoke()
    {
        return view('ai.chat');
    }
}
