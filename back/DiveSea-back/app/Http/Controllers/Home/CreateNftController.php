<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nft\StoreRequest;
use App\Models\Nft;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CreateNftController extends Controller
{
    public function __invoke()
    {
        return response()->json(['message' => 'Create form'], 200);
    }
}
