<?php

namespace App\Http\Controllers\Authorship;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorship\ApproveRequest;
use App\Models\ApproveAuthorship;
use App\Models\ApproveNft;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthorshipApprovalController extends Controller
{
    public function __invoke($id)
    {
        $authorshipRequest = ApproveAuthorship::find($id);

        if (!$authorshipRequest) {
            return response()->json(['message' => 'Authorship request not found'], 404);
        }

        // Проверяем права на обновление авторства
        Gate::authorize('update', $authorshipRequest);

        // Обновляем роль пользователя на 'author'
        $user = User::find($authorshipRequest->user_id);

        if ($user) {
            $user->role = 'author';  // Изменяем роль пользователя
            $user->save();  // Сохраняем изменения
        }

        $authorshipRequest->delete();

        return response()->json(['message' => 'Authorship approved and user role updated to author'], 200);
    }
}
