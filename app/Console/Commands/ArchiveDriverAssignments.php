<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
