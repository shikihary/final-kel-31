<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Question;
use App\Answer;
use App\Tag;
use App\User;
use App\Models\Question_votesModel;

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
            "user_id" => $request["id"],
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

    public function upvote(Request $request)
    {
        //ambil data dari form
        $data = $request->all();
        unset($data["_token"]);

        //ambil question_id untuk keperluan redirect ke /questions/{question_id}
        $question_id = $data["question_id"];

        //cari apa data vote dari user sudah ada
        $qv = Question_votesModel::find_byid($data["question_id"], $data["user_id"]);

        //jika sudah ada, set value nya sesuai yg didapat
        if ($qv != null) {
            $value = get_object_vars($qv)["value"];
        }

        //jika belum ada atau jika value vote dari user masih 0,
        //dan user yg klik upvote bukanlah user yg nulis pertanyaan, maka lanjutkan
        if (($qv == null || $value == 0) && ($data["user_id"] != $data["question_author_id"])) {
            
            //unset data question author terlebih dahulu karena tidak butuh untuk disimpan
            unset($data["question_author_id"]);

            //beri nilai vote +1 dari user yg klik tombol upvote untuk pertanyaan yg bersangkutan
            $data["value"] = 1;

            //total upvotes di tabel question tersebut bertambah 1
            DB::table('questions')->where('id', $data["question_id"])->increment('upvotes');

            //jika belum ada data sebelumnya, buat baru record baru di tabel votes
            //jika sudah ada tapi dengan value masih 0, maka update value menjadi 1)
            if ($qv == null) {
                $add = Question_votesModel::add($data); 
            } else {
                $update = Question_votesModel::update($data);
            }
        }

        return redirect('questions/'.$question_id);  
    }
}
