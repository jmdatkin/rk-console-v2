<?php

namespace App\Repository\Eloquent;

use App\Models\Driver;
use App\Models\Person;
use App\Models\Recipient;
use App\Models\Role;
use App\Repository\PersonRepositoryInterface;
use App\Repository\PersonRoleRepositoryInterface;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Collection;
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

    public function find($id): ?Model
    {
        // return $this->model->with('person')->find($id);
        return parent::find($id)->load('person');
    }

    // public function allWithPerson()
    public function all(): Collection
    {
        // return $this->model->with('person')->get();
        return parent::all()->load('person');
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
    // public function updateWithPerson($id, $attr)
    public function update($id, $attr): void
    {
        $model = $this->model->find($id);

        $model->fill($attr);

        $person = $model->person;
        $person->fill($attr);

        $person->save();
        $model->save();
    }

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
