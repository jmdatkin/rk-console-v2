<?php

namespace App\Http\Controllers\Resources;

use App\Repository\RecipientRepository;
use Inertia\Inertia;

class RecipientController extends BaseResourceController
{
    public function __construct( RecipientRepository $repository)
    {
        parent::__construct($repository);
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

    public function pause($recipient_id) {
        $this->repository->find($recipient_id)->pause();
    }

    public function unpause($recipient_id) {
        $this->repository->find($recipient_id)->unpause();
    }

}
