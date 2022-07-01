<?php

namespace App\Models;

use App\Carbon\RkCarbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PendingJob extends Model
{
    use HasFactory;

    protected $casts = [
        'payload' => 'array'
    ];

    public function commit()
    {
        $jobClass = config('app.job_key_names')[$this->job_name];

        DB::beginTransaction();
        $jobClass::dispatchSync(...$this->payload);
        $this->committed_at = RkCarbon::now();
        $this->save();
        DB::commit();
    }

    public function scopeUncommitted($query) {
        return $query->whereNull('committed_at');        
    }
}
