<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'currency_rate',
        'date'
    ];

    /**
     * Возвращает список валют, взятый из ссылки в json формате.
     *
     *
     * @return array
    */
    static public function getData()
    {
        $response = Http::get('https://nationalbank.kz/rss/rates_all.xml?switch=russian');

        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $array = json_decode($json);

        return $array->channel->item;
    }
}
