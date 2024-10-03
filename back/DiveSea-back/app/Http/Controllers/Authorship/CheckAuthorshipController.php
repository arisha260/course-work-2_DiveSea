<?php

namespace App\Http\Controllers\Authorship;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorship\ApproveRequest;
use App\Http\Resources\Authorship\AuthorshipResource;
use App\Models\ApproveAuthorship;
use App\Models\ApproveNft;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CheckAuthorshipController extends Controller
{
    public function __invoke($userId)
    {
        $application = ApproveAuthorship::where('user_id', $userId)->get();
        return AuthorshipResource::collection($application);
    }
}
