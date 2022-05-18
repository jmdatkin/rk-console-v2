<?php

namespace App\Repository\Eloquent;

use App\Models\Comment;
use App\Repository\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{

   /**
    * DriverRepository constructor.
    *
    * @param Comment $model
    */
   public function __construct(Comment $model)
   {
       parent::__construct($model);
   }
}