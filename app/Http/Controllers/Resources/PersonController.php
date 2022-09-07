<?php

namespace App\Http\Controllers\Resources;

use App\Jobs\SchedulePendingJob;
use App\Repository\PersonRepository;
use App\Repository\PersonRepositoryInterface;
use Error;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonController extends BaseResourceController
{
    /**
     * PersonController constructor.
     */
    public function __construct( PersonRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Load the view which displays a single Person resource.
     * 
     * @param int $id
     */
    public function show($id)
    {
        return Inertia::render(
            'Admin/Resources/Person',
            [
                "data" => $this->get($id)
            ]
        );
    }

    public function update(Request $request, $id)
    {
        //
        try {
            $data = $request->except('id', 'created_at', 'updated_at', 'deleted_at');

            SchedulePendingJob::dispatchSync('person:update', [$id, $data]);
            // $this->repository->update($id, $data);
            return response('Record successfully edited.', 200);
        } catch (Error | Exception $e) {
            return response('An error occurred. Record was not edited.', 409);
        }
        
    }
}
