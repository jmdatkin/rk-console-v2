<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ManageRecipientController extends Controller
{
    //
    public function index($id) {
        return Inertia::render('Assignments/ManageRecipient', [
            "recipient_id" => $id
        ]);
    }
}
