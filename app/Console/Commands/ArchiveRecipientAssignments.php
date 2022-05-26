<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ArchiveRecipientAssignments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archive:recipients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commit this week\'s recipient assignments to archive';


    private $weekdayMap = [
        'mon' => 'mon',
        'tues' => 'tue',
        'wed' => 'wed',
        'thurs' => 'thu',
        'fri' => 'fri',
        'sat' => 'sat',
        'sun' => 'sun'
    ];

    public function weekdayToDate($weekday) {
        Carbon::parse($weekdayMap[$weekday]);
    } 


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = 
        DB::table('recipient_route')->select()->get()
            ->each(function ($item) {
                // $values = $item->replicate()->toArray();
                error_log(collect($item));
                // DB::table('recipient_route_history')->insert($values); 
            });
        return 0;
    }
}
