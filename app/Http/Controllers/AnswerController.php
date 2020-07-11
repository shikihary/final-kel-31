<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use App\User;

class AnswerController extends Controller
{
    //construct: authentication
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $question = Question::find($id);
        $answers = Answer::where('question_id', $id)->get();
        return view('answer.index', compact('answers', 'question'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $question = Question::find($id);
        return view('answer.create', compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$question_id)
    {
        $data = $request->all();
        unset($data["_token"]);
        $new_answer= Answer::create([
            "isi" => $request["isi"],
            "question_id" => $question_id
        ]);
        if($new_answer){
            return redirect('answers/'.$question_id);
        }
    }

    public function bestanswer(Request $request, $id, $question_id){
        $answer = Answer::find($id);
        $answer->is_best_answer = 1;
        $answer->save();
        $allanswers = Answer::where('question_id', $question_id)
                            ->where('id', '!=' , $id)
                            ->get();

        foreach ($allanswers as $key => $value) {
            $value->is_best_answer = 0;
            $value->save();
        }
        
        $user = User::find($request["answer_author_id"]);
        $user->reputation = $user->reputation + 15;
        $user->save();

        return redirect('questions/'.$question_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($question_id)
    {
        $answer = DB::table('answers')
        ->where('question_id',$question_id)
        ->get(); 
        return view('answer.index', compact('answer','question_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
