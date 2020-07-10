<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question_tag extends Model
{
    protected $table="question_tag";
    protected $fillable = [
        'question_id', 'tag_id',
    ];
}
