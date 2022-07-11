<?php

namespace App\Http\Controllers\Resources;

use App\Repository\PersonRepositoryInterface;
use Inertia\Inertia;

class PersonController extends BaseResourceController
{
    //
    public function __construct( PersonRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function show($id)
    {
        return Inertia::render(
            'Resources/Personnel/Person',
            [
                "data" => $this->get($id)
            ]
        );
    }
}
