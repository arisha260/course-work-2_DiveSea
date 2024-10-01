<?php

namespace App\Http\Controllers\Auth1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\UserResource;
use App\Http\Resources\Nft\NftResource;
use App\Models\Author;
use App\Models\Nft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['message' => 'Authenticated']);
        }


        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
