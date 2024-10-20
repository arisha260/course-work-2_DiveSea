<?php

namespace App\Http\Controllers\ProfileEdit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApproveRequest;
use App\Http\Requests\EditProfile\EditAvatarRequest;
use App\Http\Requests\EditProfile\EditBgRequest;
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

class EditBgController extends Controller
{
    public function __invoke(EditBgRequest $request)
    {
        $user = Auth::user();

        // Проверка прав доступа на изменение фоновой картинки
        Gate::authorize('updateUserBackground', $user);

        // Получаем валидированные данные
        $data = $request->validated();

        if (isset($data['background'])) {
            if ($user->background) {
                // Извлекаем только имя файла с помощью basename()
                $oldBgFilename = basename($user->background);
                $oldBgPath = 'users/background/' . $oldBgFilename;

                // Удаляем старый фон, если он существует и не является дефолтным
                if (!in_array($oldBgFilename, ['default_user.png', 'basic.jpg']) && Storage::disk('public')->exists($oldBgPath)) {
                    Storage::disk('public')->delete($oldBgPath);
                }
            }
            // Сохраняем новый фон
            $path = $request->file('background')->store('users/background', 'public');
            $filename = $path;  // Сохраняем только имя файла
            // Обновляем имя файла в базе данных
            $user->background = $filename;
            $user->save();
        }

        return response()->json(['message' => 'Background updated successfully'], 200);
    }
}
