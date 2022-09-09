<?php

namespace App\Repository;

use App\Models\Driver;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class DriverRepository extends BaseRepository
{

    /**
     * DriverRepository constructor.
     *
     * @param Driver $model
     */
    public function __construct(Driver $model)
    {
        parent::__construct($model);
        $this->personRepository = resolve(PersonRepository::class);
    }

    /**
     * Create new Driver model and new related Person model
     * 
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model {
        // Create new model
        $model = parent::create($attributes);

        // Create new Person model
        $person = $this->personRepository->create($attributes);

        // Link 'driver' role
        $role = Role::DRIVER();
        $person->roles()->attach($role);

        // Link foreign Person id
        $model->person_id = $person->id;

        $model->save();
        $person->save();

        return $model;
    }

    /**
     * Update Driver model and its associated Person model
     * 
     * @param int $id
     * @param array $attributes
     */
    public function update($id, $attributes): void {
        $model = $this->find($id);
        
        $model->fill($attributes);
        $model->person->fill($attributes);

        $model->save();
        $model->person->save();
    }

    public function destroy($id)
    {
        $model = $this->find($id);
        $model->routes()->detach();
        $model->alternateRoutes()->detach();
        parent::destroy($id);
    }
}
