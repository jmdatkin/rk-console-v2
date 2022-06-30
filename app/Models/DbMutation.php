<?php

namespace App\Models;

use App\Carbon\RkCarbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DbMutation extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'entity_id',
    //     'entity_type',
    //     'fields',
    //     'values',
    // ];

    public function commit()
    {
        $table = $this->entity_type;
        $entity_id = $this->entity_id;
        $fields = explode(';', $this->fields);
        $values = explode(';', $this->values);

        $attr = array_combine($fields, $values);

        //Ensure committing data and updating status on DbMutation happens in the same step
        DB::beginTransaction();
        DB::table($table)->where('id', $entity_id)->update($attr);
        $this->committed_at = RkCarbon::now();
        $this->save();
        DB::commit();
    }

    public function scopeUncommitted($query) {
        return $query->whereNull('committed_at');        
    }
}
