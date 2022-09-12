<?php

namespace App\Http\Controllers;

use App\Models\PendingJob;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class JobController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Admin/PendingJobs', [
            'pending_jobs' => PendingJob::uncommitted()->orderBy('created_at', 'desc')->get()
        ]);
    }

    public function commit($job_id) {
        try {
            PendingJob::find($job_id)->commit();
            Log::info('Job committed.', 
            [
                'job_id' => $job_id
            ]);
            return response('Job was successfully committed.', 200);
        } catch (Error | Exception $e) {
            Log::error('An error occurred while committing job.', 
            [
                'job_id' => $job_id,
                'error_message' => $e
            ]);
            return response('An error occurred. Job was not committed.', 200);
        }
    }

    public function destroy($job_id) {
        try {
            PendingJob::find($job_id)->delete();
            Log::info('Job deleted.', 
            [
                'job_id' => $job_id
            ]);
            return response('Job was successfully deleted.', 200);
        } catch (Error | Exception $e) {
            Log::error('An error occurred while attempting to delete job.', 
            [
                'job_id' => $job_id,
                'error_message' => $e
            ]);
            return response('An error occurred. Job was not deleted.', 200);
        }
    }
}
