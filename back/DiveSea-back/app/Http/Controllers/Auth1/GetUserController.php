<?php

namespace App\Http\Controllers\Auth1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\AuthorResource;
use App\Http\Resources\Nft\NftResource;
use App\Models\Author;
use App\Models\Nft;
use Illuminate\Http\Request;

class GetUserController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json($request->user());
    }
}
