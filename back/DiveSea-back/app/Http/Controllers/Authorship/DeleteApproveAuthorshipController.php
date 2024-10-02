<?php

namespace App\Http\Controllers\Authorship;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nft\StoreRequest;
use App\Models\ApproveAuthorship;
use App\Models\ApproveNft;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DeleteApproveAuthorshipController extends Controller
{
    public function __invoke($id)
    {
        $approveAuthorship = ApproveAuthorship::findOrFail($id);

        Gate::authorize('delete', $approveAuthorship);

        // Удаляем запись
        $approveAuthorship->delete();

        return response()->json(['message' => 'ApproveAuthorship rejected successfully'], 200);
    }
}
