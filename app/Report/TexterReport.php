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
        return array_values($this->repository->all()->filter(function($recipient) use ($weekday) {
            return !$recipient->routes()->wherePivot('weekday', $weekday)->get()->isEmpty();
        })->map(function($recipient) {
            $recipient->concat(
            [
                'routeName' => $recipient->routes->first()
            ]);
            return $recipient;
        })
        ->toArray());
    }

}