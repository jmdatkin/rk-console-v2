<?php

namespace App\Repository;

use App\Models\Person;

class PersonRepository extends BaseRepository
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

    /**
     * Destroy Person model and related models
     * 
     * @param int $id
     * @return void
     */
    public function destroy($id): void
    {
        $person = $this->find($id);

        $person->roles()->detach();

        if ($person->recipient()->exists()) {
            $person->recipient->routes()->detach();
            $person->recipient->delete();
        }

        if ($person->driver()->exists()) {
            $person->driver->routes()->detach();
            $person->driver->delete();
        }

        parent::destroy($id);
    }
}
