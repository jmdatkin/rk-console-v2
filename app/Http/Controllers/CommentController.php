<?php

namespace App\Http\Controllers;

use App\Repository\CommentRepositoryInterface;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function __construct(CommentRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function show($recipient_id) {
        return $this->repository->whereRecipient($recipient_id)->load('driver');
    }

    public function show_recipient($recipient_id) {
        return $this->repository->whereRecipient($recipient_id)->load('driver');
    }

    /**
     * Create new Comment record
     *  
     * @param Request
     * @return void
     */
    public function store(Request $request) {
        error_log($request->collect());
        if ($request->has(['driver_id','recipient_id','body'])) {
            $this->repository->create($request->only(['driver_id','recipient_id','body']));
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
