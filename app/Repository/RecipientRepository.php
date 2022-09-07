<?php

namespace App\Repository;

use App\Models\Person;
use App\Models\Recipient;
use App\Models\Role;
use App\Repository\RecipientRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
    }

    public function store($data) {
        // Create new model
        $model = $this->create($data);

        // Create new Person model
        $person = new Person();
        $person->fill($data);

        // Link 'recipient' role
        $role = Role::where('name', Role::RECIPIENT)->first();
        $person->roles()->attach($role);

        // Associate Person with Recipient
        $model->person_id = $person->id;
        $model->save();
        $person->save();
    }

    public function update($id, $data): void {
        $model = $this->find($id);
        
        $model->fill($data);
        $model->person->fill($data);

        $model->save();
        $model->person->save();
    }

    public function destroy($id)
    {
        $this->find($id)->routes()->detach();
        parent::destroy($id);
    }
}
