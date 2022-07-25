<?php

namespace App\QueryScopes;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ScopeUnpaused implements Scope {
    public function apply(Builder $builder, Model $model) {
        $builder->where('paused', false);
    }
}