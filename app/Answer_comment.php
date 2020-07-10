<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer_comment extends Model
{
    protected $table = 'answer_comments';
    protected $guarded = [];
    const UPDATED_AT = null;
}
