<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Answer_votesModel {
    public static function add($data) {
        $new_answer_votes = DB::table('answer_votes')->insert($data);
        return $new_answer_votes;
    }

    public static function find_byid($answer_id, $user_id) {
        $answer_votes = DB::table('answer_votes')->where('answer_id', $answer_id)->where('user_id', $user_id)->first();
        return $answer_votes;
    }    

    public static function update($answer_id, $user_id) {
        $update = DB::table('answer_votes')->where('answer_id', $answer_id)->where('user_id', $user_id)->update($data);
        return $update;
    }
}