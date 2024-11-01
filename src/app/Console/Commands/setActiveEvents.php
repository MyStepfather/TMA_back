<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class setActiveEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-active-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновить статус isActive по дате';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $today = Carbon::now();

        $records = Event::whereMonth('date', $today->month)
                    ->whereDay('date', $today->day)
                    ->get();

        foreach ($records as $record) {
            $record->isActive = true;
            $record->save();
        }

        $this->info('Статус isActive обновлен для ' . $records->count() . ' записей.');
    }
}
