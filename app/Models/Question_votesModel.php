<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Question_votesModel {
    public static function add($data) {
        $new_question_votes = DB::table('question_votes')->insert($data);
        return $new_question_votes;
    }

    public static function find_byid($question_id, $user_id) {
        $question_votes = DB::table('question_votes')->where('question_id', $question_id)->where('user_id', $user_id)->first();
        return $question_votes;
    }    

    public static function update($question_id, $user_id) {
        $update = DB::table('question_votes')->where('question_id', $question_id)->where('user_id', $user_id)->update($data);
        return $update;
    }
}