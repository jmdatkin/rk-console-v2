<?php   

namespace App\Repository\Eloquent;   

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;   

class BaseRepository implements EloquentRepositoryInterface 
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
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
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
}