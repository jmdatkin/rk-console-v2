<?php

namespace App\Repository;

use App\Models\Recipient;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class RecipientRepository extends BaseRepository
{
    /**
     * RecipientRepository constructor.
     *
     * @param Recipient $model
     */
    public function __construct(Recipient $model)
    {
        parent::__construct($model);
        $this->personRepository = resolve(PersonRepository::class);
    }

    /**
     * Create new Recipient model and new related Person model
     * 
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model {
        // Create new model
        $model = parent::create($attributes);

        // Create new Person model
        $person = $this->personRepository->create($attributes);

        // Link 'recipient' role
        $role = Role::RECIPIENT();
        $person->roles()->attach($role);

        // Associate Person with Recipient
        $model->person_id = $person->id;
        $model->save();
        $person->save();

        return $model;
    }

    /**
     * Update Recipient model and its associated Person model
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

    /**
     * Destroy models with id
     * 
     * @param int $id
     */
    public function destroy($id)
    {
        $this->find($id)->routes()->detach();
        parent::destroy($id);
    }
}
