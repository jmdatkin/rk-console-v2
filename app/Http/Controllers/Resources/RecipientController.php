<?php

namespace App\Http\Controllers\Resources;

use App\Jobs\ProcessJobRequest;
use App\Repository\RecipientRepository;
use Inertia\Inertia;

class RecipientController extends BaseResourceController
{
    public function __construct( RecipientRepository $repository)
    {
        parent::__construct($repository, 'recipient');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        return Inertia::render(
            'Admin/Resources/Recipient',
            [
                "data" => $this->get($id)
            ]
        );
    }

    public function routes($recipient_id) {
        return $this->repository->find($recipient_id)->routes;
    }

    public function pause($id) {
        ProcessJobRequest::dispatchSync(
            'recipient',
            'pause',
            (int)$id,
        );
    }

    public function unpause($id) {
        ProcessJobRequest::dispatchSync(
            'recipient',
            'unpause',
            (int)$id,
        );
    }

}
