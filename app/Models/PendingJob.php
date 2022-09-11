<?php

namespace App\Models;

use App\Carbon\RkCarbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PendingJob extends Model
{
    use HasFactory;

    protected $casts = [
        'payload' => 'array'
    ];

    protected $with = ['user'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getJobKeyAttribute() {
        return $this->resource_type . ':' . $this->job_action;
    }

    public function commit()
    {
        // $jobClass = config('app.job_key_names')[$this->job_key];
        $jobClass = config('app.job_classes')[$this->resource_type][$this->job_action];

        DB::beginTransaction();
        
        // No id, e.g. create
        if (is_null($this->resource_id))
            $jobClass::dispatchSync($this->payload);

        // No payload, e.g. destroy
        else if (is_null($this->payload))
            $jobClass::dispatchSync($this->resource_id);
        
        else
            $jobClass::dispatchSync($this->resource_id, $this->payload);

        Log::info('Committing PendingJob with id'.$this->id, $this->getAttributes());
        $this->committed_at = RkCarbon::now();
        $this->save();
        DB::commit();
    }

    public function scopeUncommitted($query) {
        return $query->whereNull('committed_at');        
    }

    public function scopeWithName($query, $name) {
        return $query->where('job_name', $name);
    }

    public function scopeWithNameClass($query, $name) {
        return $query->where('job_name', 'like', $name.":%");
    }

}
