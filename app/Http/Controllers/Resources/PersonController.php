<?php

namespace App\Http\Controllers\Resources;

use App\Repository\PersonRepository;
use Inertia\Inertia;

class PersonController extends BaseResourceController
{
    /**
     * PersonController constructor.
     */
    public function __construct( PersonRepository $repository)
    {
        parent::__construct($repository, 'person');
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
}
