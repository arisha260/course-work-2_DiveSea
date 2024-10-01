<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nft\StoreRequest;
use App\Models\approveNft;
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
        Log::info('Before authorization in StoreNftController');
        Gate::authorize('create', ApproveNft::class);
        Log::info('After authorization in StoreNftController');

        // Если проверка прошла, продолжаем обработку запроса
        $data = $request->validated();

        // Сохраняем изображение в папку storage/app/public/nfts
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('nfts', 'public');
            $data['img'] = $path; // Сохраняем новое изображение
        } elseif (is_string($data['img']) && !empty($data['img'])) {
            // Если это строка, просто сохраняем её как URL
            $data['img'] = $data['img'];
        } else {
            // Если ни файл, ни URL не переданы, можно вернуть ошибку или задать значение по умолчанию
            return response()->json(['error' => 'Image must be provided.'], 400);
        }

        $nft = ApproveNft::create($data);

        return response()->json($nft, 201);
    }
}
