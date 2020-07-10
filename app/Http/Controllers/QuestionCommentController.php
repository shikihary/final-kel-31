<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Question_comment;

class QuestionCommentController extends Controller
{
    public function show($question_id)
    {
        $questionComment = DB::table('question_comments')
        ->where('question_id',$question_id)
        ->get(); 
        return view('questionComment.index', compact('questionComment','question_id'));
    }

    public function store(Request $request,$question_id)
    {
        $data = $request->all();
        unset($data["_token"]);
        $new_questionComment= Question_comment::create([
            "isi" => $request["isi"],
            "user_id" => $request['user_id'],
            "question_id" => $question_id
        ]);
        if($new_questionComment){
            return redirect('questionComments/'.$question_id);
        }
    }
}
