<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopbarController extends Controller
{
    public function getUserName()
    {
        $user = Auth::user();

        return response()->json([
            'userName' => $user ? $user->name : 'Guest',
        ]);
    }
}
