<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Nft\UserResource;
use App\Http\Resources\Nft\NftResource;
use App\Models\Author;
use App\Models\Nft;
use Illuminate\Http\Request;

class GetUserController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user(); // Получаем авторизованного пользователя

        return new UserResource($user); // Возвращаем данные через ресурс
    }
}
