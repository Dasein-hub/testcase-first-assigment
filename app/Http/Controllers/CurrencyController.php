<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Возвращает список валют.
     *
     * @param string $date Дата, текущая по умолчанию. Берётся из $request.
     * @param string $per_page Количество записей в списке, 8 по умолчанию. Берётся из $request.
     *
     * @return CurrencyResource|json Возвращается список курса валют или ошибку.
    */
    public function index(Request $request)
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
     * @param string $date Дата, текущая по умолчанию. Берётся из $request.
     * @param string $name Код валюты. Берётся из $request.
     *
     * @return CurrencyResource|json Возвращается одну запись из списка курса валют или ошибку.
    */
    public function show(Request $request)
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
}
