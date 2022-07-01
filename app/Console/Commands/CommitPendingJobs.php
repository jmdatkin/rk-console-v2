<?php

namespace App\Console\Commands;

use App\Models\PendingJob;
use Illuminate\Console\Command;

class CommitPendingJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:commitpending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commit pending jobs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        PendingJob::uncommitted()->get()->each(function($job) {
            $job->commit();
        });
        return 0;
    }
}
