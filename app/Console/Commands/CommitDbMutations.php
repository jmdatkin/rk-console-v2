<?php

namespace App\Console\Commands;

use App\Models\DbMutation;
use Illuminate\Console\Command;

class CommitDbMutations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mutations:commit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Confirm data mutations made by users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DbMutation::uncommitted()->get()->each(function($record) {
            $record->commit();
        });
        return 0;
    }
}
