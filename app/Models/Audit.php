<?php

namespace App\Models;

use OwenIt\Auditing\Models\Audit as ModelsAudit;

class Audit extends ModelsAudit {
    
   /**
    * Separates attributes out into own rows for displaying in data table
    */
   public function separateAttributes() {
        return collect($this->old_values)->map(function($value, $attr){
                return collect($this->load('user'))->except(['old_values','new_values'])->union([
                   'attribute' => $attr,
                   'old_value' => $value,
                   'new_value' => $this->new_values[$attr]
                ]);
            })->values();
   }
}