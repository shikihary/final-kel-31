<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Question;
use App\Answer;
use App\Tag;
use App\User;

class QuestionController extends Controller
{
    //construct: authentication
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();
        return view('question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $new_question= Question::create([
            "judul" => $request["judul"],
            "isi" => $request["isi"],
            "user_id" => $id,
        ]);

        //dd($new_question);

        $tagArr = explode(',', $request->tags);
        $tagsMulti  = [];
        foreach($tagArr as $strTag){
            $tagArrAssc["tag_name"] = $strTag;
            $tagsMulti[] = $tagArrAssc;
        }
        //dd($tagsMulti);
        // Create Tags baru
        foreach($tagsMulti as $tagCheck){
            $tag = Tag::firstOrCreate($tagCheck);
            $question_tag = DB::table('Question_tag')->insert([
                "tag_id" => $tag->id,
                "question_id" => $new_question->id,
            ]);

            //$new_question->tags()->attach($tag->id);
        }
        return redirect('/questions');
    }

    public function answerstore(Request $request, $question_id)
    {
        $data = $request->all();
        unset($data["_token"]);
        $new_answer= Answer::create([
            "isi" => $request["isi"],
            "question_id" => $question_id,
            "user_id" => $request['user_id']
        ]);
        if($new_answer){
            return redirect('questions/'.$question_id);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
        $answers = Answer::where('question_id', $id)->get();
        return view('question.show', compact('answers', 'question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);
        return view('question.edit', compact('question'));
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
        $question = Question::find($id);
        $question->judul = $request->judul;
        $question->isi = $request->isi;
        $question->save();
        
        return redirect('/questions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();
        return redirect('/questions');
    }

    public function userquestion($user_id)
    {
        $questions = Question::where('user_id', $user_id)->get();
        //dd($questions);
        $user = User::find($user_id);
        return view('question.userquestion', compact('questions', 'user'));
    }
}
