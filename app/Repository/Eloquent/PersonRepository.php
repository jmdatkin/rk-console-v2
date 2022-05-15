<?php

namespace App\Repository\Eloquent;

use App\Models\Person;
use App\Repository\PersonRepositoryInterface;
use Error;

class PersonRepository extends BaseRepository implements PersonRepositoryInterface
{

    /**
     * PersonRepository constructor.
     *
     * @param Person $model
     */
    public function __construct(Person $model)
    {
        parent::__construct($model);
    }

    public function withRoles()
    {
        return $this->model->with('roles')->get();
    }

    public function destroy($id)
    {
        $person = $this->find($id);
        error_log($id);
        error_log($person);//->load('roles'));
        $person->roles()->detach();

        if ($person->recipient()->exists())
            $person->recipient->delete();

        if ($person->driver()->exists())
            $person->driver->delete();

        parent::destroy($id);
    }
}
