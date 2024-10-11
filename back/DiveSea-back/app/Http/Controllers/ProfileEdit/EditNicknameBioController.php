<?php

namespace App\Http\Controllers\ProfileEdit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApproveRequest;
use App\Http\Requests\EditProfile\EditAvatarRequest;
use App\Http\Requests\EditProfile\EditNicknameBioRequest;
use App\Models\Nft;
use App\Models\ApproveNft;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EditNicknameBioController extends Controller
{
    public function __invoke(EditNicknameBioRequest $request)
    {
        $user = Auth::user();

        // Проверка прав доступа на изменение аватара
        Gate::authorize('updateUserNicknameBio', $user);

        // Получаем валидированные данные
        $data = $request->validated();

        if (!empty($data['nickname'])) {
            $user->nickname = $data['nickname'];
        }

        if (!empty($data['bio'])) {
            $user->bio = $data['bio'];
        }

        $user->save();


        return response()->json(['message' => 'Nickname/bio updated successfully'], 200);
    }
}
