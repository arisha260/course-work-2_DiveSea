<?php

namespace App\Http\Controllers\ProfileEdit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApproveRequest;
use App\Http\Requests\EditProfile\EditAvatarRequest;
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

class EditAvatarController extends Controller
{
    public function __invoke(EditAvatarRequest $request)
    {
        $user = Auth::user();

        // Проверка прав доступа на изменение аватара
        Gate::authorize('updateUserAvatar', $user);

        // Получаем валидированные данные
        $data = $request->validated();

        // Проверка на существование старого аватара и его удаление
        if (isset($data['img'])) {
            if ($user->img) {
                // Извлекаем только имя файла с помощью basename()
                $oldAvatarFilename = basename($user->img);
                $oldAvatarPath = 'users/avatars/' . $oldAvatarFilename;

                // Удаляем старый аватар, если он существует и не является дефолтным
                if (!in_array($oldAvatarFilename, ['default_user.png', 'basic.jpg']) && Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }
            }
            // Сохраняем новый аватар
            $path = $request->file('img')->store('users/avatars', 'public');
            $filename = $path;  // Сохраняем только имя файла
            // Обновляем имя файла в базе данных
            $user->img = $filename;
            $user->save();
        }

        return response()->json(['message' => 'Avatar updated successfully'], 200);
    }
}
