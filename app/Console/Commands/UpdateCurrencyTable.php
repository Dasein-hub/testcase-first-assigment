<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;

class UpdateCurrencyTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновляет все записи в таблице currency';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Currency::query()->truncate();

        foreach (Currency::getData() as $item)
        {
            Currency::query()->create([
                'name' => $item->title,
                'currency_rate' => $item->description,
                'date' => $item->pubDate
            ]);
        }
    }
}
