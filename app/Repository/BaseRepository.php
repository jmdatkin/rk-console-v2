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
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        // return $this->model->create($attributes);
        $model = new $this->model();
        $model->fill($attributes);
        $model->save();

        return $model;
    }
 
    /**
    * @param $id
    * @return Model
    */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function update($id, $data): void {
        $this->find($id)->update($data);
    }

    public function all(): Collection {
        return $this->model->all();
    }

    public function destroy($id) {
        $this->model->destroy($id);
    }

    public function destroyMany($ids) {
        foreach ($ids as $id)
            $this->destroy($id);
    }

    public function import($data) {
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