<?php

namespace App\Http\Controllers\Authorship;

use App\Http\Controllers\Controller;
use App\Http\Resources\Authorship\AuthorshipResource;
use App\Http\Resources\Nft\NftResource;
use App\Models\ApproveAuthorship;
use App\Models\ApproveNft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function __invoke()
    {
        $application = ApproveAuthorship::all();
        return AuthorshipResource::collection($application);
   }
}
