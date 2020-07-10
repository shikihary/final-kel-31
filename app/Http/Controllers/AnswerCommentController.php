<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Answer_comment;

class AnswerCommentController extends Controller
{
    public function show($answer_id)
    {
        $answerComment = DB::table('answer_comments')
        ->where('answer_id',$answer_id)
        ->get(); 
        return view('answerComment.index', compact('answerComment','answer_id'));
    }

    public function store(Request $request,$answer_id)
    {
        $data = $request->all();
        unset($data["_token"]);
        $new_answerComment= Answer_comment::create([
            "isi" => $request["isi"],
            "answer_id" => $answer_id
        ]);
        if($new_answerComment){
            return redirect('answerComments/'.$answer_id);
        }
    }
}
