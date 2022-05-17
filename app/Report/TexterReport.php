<?php

namespace App\Report;

use App\Repository\DriverRepositoryInterface;
use App\Repository\RecipientRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class TexterReport extends BaseReport {

    public function __construct(RecipientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function report($weekday) {
        return array_values($this->repository->all()
        ->filter(function($recipient) use ($weekday) {      //Filter route assignments to chosen weekday
            return !$recipient->routes()->wherePivot('weekday', $weekday)->get()->isEmpty();
        })
        ->map(function($recipient) {        //Append route name for grouping within DataTable
            return collect($recipient->toArray())->union(
            [
                'routeName' => $recipient->routes->first()->name
            ]);
            // return $recipient;
        })->toArray());
    }

}