<?php

namespace App\Repository\Eloquent;

use App\Models\Person;
use App\Repository\PersonRoleRepositoryInterface;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BasePersonRoleRepository extends BaseRepository implements PersonRoleRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }


    public function findWithPerson($id)
    {
        return $this->model->with('person')->find($id);
    }

    public function allWithPerson()
    {
        return $this->model->with('person')->get();
    }

    public function destroy($id)
    {
        // foreach ($ids as $id) {
        $model = $this->find($id);
        $person = $model->person;
        error_log($person);
        // $model->delete();
        // $person->delete();
        // }
    }

    public function destroyMany($ids) {
        foreach ($ids as $id)
            $this->destroy($id);
    }

    /**
     * 
     * @param $id
     * @param $attr
     */
    public function updateWithPerson($id, $attr)
    {
        $model = $this->model->find($id);

        $model->fill($attr);

        $person = $model->person;
        $person->fill($attr);

        $person->save();
        $model->save();
    }

    public function storeWithPerson($data)
    {
    }
}
