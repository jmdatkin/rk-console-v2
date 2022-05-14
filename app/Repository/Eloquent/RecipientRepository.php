<?php

namespace App\Repository\Eloquent;

use App\Models\Recipient;
use App\Repository\RecipientRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecipientRepository extends BasePersonRoleRepository implements RecipientRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Recipient $model
     */
    public function __construct(Recipient $model)
    {
        parent::__construct($model);
    }

    public function destroy($id)
    {
        $this->find($id)->routes()->detach();
        //    DB::table('recipient_route')->where('recipient_id', $id)->delete();
        parent::destroy($id);
    }
}
