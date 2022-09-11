<?php

namespace App\Http\Controllers\Resources;

use App\Jobs\InterpretJobRequest;
use App\Repository\RecipientRepository;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $data = $request->all();
            InterpretJobRequest::dispatchSync(
                'recipient',
                'create',
                null,
                $data
            );
            return response('Record successfully created.', 200);
        } catch (Error | Exception $e) {
            Log::error($e); 
            // return response('An error occurred. Record was not created.', 409);
            return response($e, 409);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
        try {
            $data = $request->except('id', 'created_at', 'updated_at', 'deleted_at');
            // $this->repository->update($id, $data);
            InterpretJobRequest::dispatchSync(
                'recipient',
                'update',
                $id,
                $data
            );
            return response('Record successfully edited.', 200);
        } catch (Error | Exception $e) {
            Log::error($e); 
            return response('An error occurred. Record was not edited.', 409);
        }
    }
    
    public function routes($recipient_id) {
        return $this->repository->find($recipient_id)->routes;
    }

    public function pause($id) {
        // $this->repository->find($recipient_id)->pause();
        InterpretJobRequest::dispatchSync(
            'recipient',
            'pause',
            (int)$id,
        );
    }

    public function unpause($id) {
        // $this->repository->find($recipient_id)->unpause();
        InterpretJobRequest::dispatchSync(
            'recipient',
            'unpause',
            (int)$id,
        );
    }

}
