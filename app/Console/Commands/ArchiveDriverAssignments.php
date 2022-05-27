<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArchiveDriverAssignments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archive:drivers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commit this week\'s driver assignments to archive';

    public function weekdayToDate($weekday) {
        return Carbon::parse($weekday." this week");
    } 

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('driver_route')->select()->get()
            ->each(function ($item) {
                $date = $this->weekdayToDate($item->weekday);
                try {
                DB::table('driver_route_history')->insert([
                    'driver_id' => $item->driver_id,
                    'route_id' => $item->route_id,
                    'date' => $date,
                ]); 
                Log::info('Archived driver', ["driver" => $item]);
                } catch (QueryException $e) {}
            });
        return 0;
    }
}
