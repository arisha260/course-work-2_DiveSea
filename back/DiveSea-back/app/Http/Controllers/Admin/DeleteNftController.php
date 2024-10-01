<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nft\StoreRequest;
use App\Models\ApproveNft;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DeleteNftController extends Controller
{
    public function __invoke($id)
    {
        $nftToReject = ApproveNft::findOrFail($id);

        Gate::authorize('delete', $nftToReject);

        // Удаляем запись
        $nftToReject->delete();

        return response()->json(['message' => 'NFT rejected successfully'], 200);
    }
}
