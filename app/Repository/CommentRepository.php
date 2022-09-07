<?php

namespace App\Repository;

use App\Models\Comment;

class CommentRepository extends BaseRepository
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

   public function whereRecipient($recipient_id) {
       return parent::all()->where('recipient_id', $recipient_id);
   }
}