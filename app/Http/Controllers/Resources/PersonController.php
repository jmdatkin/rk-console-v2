<?php

namespace App\Http\Controllers\Resources;

use App\Repository\PersonRepositoryInterface;
use Inertia\Inertia;

class PersonController extends BaseResourceController
{
    /**
     * PersonController constructor.
     */
    public function __construct( PersonRepositoryInterface $repository)
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
}
