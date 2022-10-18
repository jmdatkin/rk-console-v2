<?php

namespace App\Report;

use App\Carbon\RkCarbon;

class Stats{

    public function __construct($model) {
        $this->model = $model;
    }

    public function forWeek($date) {
        $startOfWeek = RkCarbon::parse($date)->startOf('week');
        $endOfWeek = $startOfWeek->clone()->endOf('week');
        return $this->model->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
    }

    public function total() {
        return $this->model->count();
    }

    public function createdThisWeek() {
        $startOfWeek = RkCarbon::today()->startOf('week');
        return $this->model->whereDate('created_at', '>=', $startOfWeek)->count();
    }

    public function data() {
        return [
            'total' => $this->total(),
            'createdThisWeek' => $this->createdThisWeek()
        ];
    }
}