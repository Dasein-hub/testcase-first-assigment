<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenRequest;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CurrencyController extends Controller
{
    /**
     * Возвращает список валют.
     *
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection Возвращается список курса валют или ошибку.
     */
    public function index(Request $request): JsonResponse|AnonymousResourceCollection
    {
        $currencies = Currency::query()
            ->where('date', $request->date ? Carbon::parse($request->date)->format('d.m.Y') : Carbon::now()->format('d.m.Y'))
            ->paginate($request->per_page ?: 8);

        if (isset($currencies))
        {
            return CurrencyResource::collection($currencies);
        }

        return response()->json(['message' => 'Данные (на текущую дату) не найдены'], 404);
    }

    /**
     * Возвращает одну записи из списка валют.
     *
     * @param Request $request
     * @return JsonResponse|CurrencyResource Возвращается одну запись из списка курса валют или ошибку.
     */
    public function show(Request $request): CurrencyResource|JsonResponse
    {
        if (isset($request->name)) {
            $currency = Currency::query()
            ->where('date', $request->date ? Carbon::parse($request->date)->format('d.m.Y') : Carbon::now()->format('d.m.Y'))
            ->where('name', $request->name)->first();

            if (isset($currency))
            {
                return new CurrencyResource($currency);
            }

            return response()->json(['message' => 'Данные (на текущую дату) не найдены'], 404);
        }

        return response()->json(['message' => 'Запись с данным кодом валюты не найдена'], 404);
    }

    public function token(TokenRequest $request)
    {
        $user = User::query()->create($request->all());
        $token = $user->createToken('test');

        return response()->json(['token' => $token->plainTextToken]);
    }
}
