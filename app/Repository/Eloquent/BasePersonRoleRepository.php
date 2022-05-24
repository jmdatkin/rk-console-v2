<?php

namespace App\Repository\Eloquent;

use App\Models\Driver;
use App\Models\Recipient;
use App\Models\Role;
use App\Repository\PersonRepositoryInterface;
use App\Repository\PersonRoleRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class BasePersonRoleRepository extends BaseRepository implements PersonRoleRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->personRepository = App::make(PersonRepositoryInterface::class);
        parent::__construct($model);
    }

    public function destroy($id)
    {
        $model = $this->find($id);
        $person = $model->person;
        $person->roles()->detach();
        $model->delete();
        $person->delete();
    }

    /**
     * 
     * @param $id
     * @param $attr
     */
    public function update($id, $attr): void
    {
        $model = $this->model->find($id);

        $model->fill($attr)->save();
        $model->person->fill($attr)->save();
    }

    /**
     * Insert a new record with a related person
     * 
     * @param $data
     */
    public function store($data)
    {
        $personAttributes = [
            'firstName',
            'lastName',
            'email',
            'phoneHome',
            'phoneCell',
            'notes'
        ];

        switch (get_class($this->model)) {
            case Recipient::class:
                $role = Role::where('name', 'recipient')->first();
                break;
            case Driver::class:
                $role = Role::where('name', 'driver')->first();
                break;
        }

        $person = $this->personRepository->create($data->only($personAttributes)->all());

        if (isset($role))
            $person->roles()->attach($role);

        $model = parent::create($data->except($personAttributes)->all());
        $model->person_id = $person->id;
        $model->save();
    }
}
