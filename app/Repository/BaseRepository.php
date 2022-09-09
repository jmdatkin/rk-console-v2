<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    /**      
     * @var Model      
     */
    protected $model;

    /**      
     * BaseRepository constructor.      
     *      
     * @param Model $model      
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Create new instance
     * 
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        $model = new $this->model();
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    /**
     * Retrieve resource with specified id.
     * 
     * @param int $id
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function update($id, $data): void
    {
        $this->find($id)->update($data);
    }

    /**
     * Retrieve all resources.
     * 
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Destroy resource with specified id.
     * 
     * @param int $id
     * @return int
     */
    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Destroy resources with specified ids.
     * 
     * @param array @ids
     * @return void
     */
    public function destroyMany($ids)
    {
        foreach ($ids as $id)
            $this->destroy($id);
    }

    /**
     * Create records in bulk.
     * 
     * @param array $data
     * @return void
     */
    public function import($data): void
    {
        // $model_headers = collect($this->model->first()->getAttributes())
        // ->keys()
        // ->except(['created_at', 'updated_at', 'deleted_at']);
        // dd($data);
        foreach ($data as $record) {
            // $filtered_data = collect($record)->intersectByKeys($model_headers)->toArray();
            // $this->create($filtered_data);
            $this->create($record);
        }
    }
}
