<?php

namespace App\Http\Controllers\Assignments;

use App\Http\Controllers\Controller;
use App\Repository\RecipientRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ManageRecipientController extends Controller
{
    //
    public function __construct(RecipientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($id)
    {
        return Inertia::render('Assignments/ManageRecipient', [
            "recipient_id" => $id,
            "assignment_data" => $this->getAssignments($id)
        ]);
    }

    public function makeAssignment($recipient_id, $route_id, $weekday)
    {
        try {
            $this->repository->find($recipient_id)->setRoute($route_id, $weekday);
            return Redirect::route('manage.recipient', ["id" => $recipient_id])->with([
                'message-class' => 'success',
                'message' => 'Record successfully created.'
            ]);;
        } catch (Exception $e) {
            return Redirect::route('manage.recipient', ["id" => $recipient_id])->with([
                'message-class' => 'error',
                'message' => 'An error occurred. Record was not created.'
            ]);;
        }
    }

    public function getAssignments($recipient_id)
    {
        return $this->repository->find($recipient_id)->routes;
    }
}
