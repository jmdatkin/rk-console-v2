<?php

namespace App\Models;

use App\Events\LogModelChanges;
use App\Events\RecipientModelUpdated;
use App\Traits\HasArchive;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class Recipient extends BasePersonRole implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, HasArchive;

    protected $fillable = [
        'agency_id',
        'numMeals',
        'address',
        'paused'
    ];

    protected $with = ['person', 'agency'];

    protected $touches = ['person'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    //Many-to-many linkage between route
    public function routes()
    {
        return $this->belongsToMany(Route::class)->withPivot(['weekday']);
    }

    /**
     * Sets 'paused' attribute to 'true'
     */
    public function pause() {
        $this->paused = true;
        $this->save();
    }

    /**
     * Sets 'paused' attribute to 'false'
     */
    public function unpause() {
        $this->paused = false;
        $this->save();
    }

    public function scopePaused($query) {
        return $query->where('paused', true);
    }

    public function scopeUnpaused($query) {
        return $query->where('paused', false);
    }
}
