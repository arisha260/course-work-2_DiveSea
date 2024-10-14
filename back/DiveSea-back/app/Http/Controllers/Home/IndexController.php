<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\NftResource;
use App\Models\Nft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function __invoke()
    {
//        Log::info('Before authorization in IndexController');
//        Gate::authorize('viewAny', Nft::class);
//        Log::info('After authorization in IndexController');

        $nft = Nft::paginate(10);
        $totalCount = Nft::count();

        return response()->json([
            'data' => NftResource::collection($nft),
            'total_count' => $totalCount
        ]);
    }
}
