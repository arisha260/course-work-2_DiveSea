<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nft\StoreRequest;
use App\Models\Nft;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class StoreNftController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        Gate::authorize('create', Nft::class);

        // Если проверка прошла, продолжаем обработку запроса
        $data = $request->validated();

        // Сохраняем изображение в папку storage/app/public/nfts
        $path = $request->file('img')->store('nfts', 'public');
        $data['img'] = $path; // Сохраняем путь к изображению в базе данных

        $nft = Nft::create($data);

        return response()->json($nft, 201);
    }
}
