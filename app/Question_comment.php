<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question_comment extends Model
{
    protected $table = 'question_comments';
    protected $guarded = [];
    const UPDATED_AT = null;
}
