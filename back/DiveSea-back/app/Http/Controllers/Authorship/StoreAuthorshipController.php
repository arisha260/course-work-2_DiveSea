<?php

namespace App\Http\Controllers\Authorship;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorship\ApproveRequest;
use App\Models\ApproveAuthorship;
use App\Models\ApproveNft;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class StoreAuthorshipController extends Controller
{
    public function __invoke(ApproveRequest $request)
    {
        Gate::authorize('create', ApproveAuthorship::class);  // Проверяем права на создание

        $data = $request->validated();

        $approveAuthorship = ApproveAuthorship::create($data);

        return response()->json($approveAuthorship, 201);
    }
}
