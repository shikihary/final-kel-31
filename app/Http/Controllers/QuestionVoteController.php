<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Question_votesModel;

class QuestionVoteController extends Controller
{
    // -- U P V O T E   P E R T A N Y A A N --
    public function upvote(Request $request)
    {
        //ambil data dari form
        $data = $request->all();
        unset($data["_token"]);

        //ambil question_id untuk keperluan redirect ke /questions/{question_id}
        $question_id = $data["question_id"];

        //cari apakah data vote dari user sudah ada
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

            //jika belum ada data sebelumnya, buat record baru di tabel votes
            //jika sudah ada tapi dengan value masih 0, maka update value menjadi 1)
            if ($qv == null) {
                $add = Question_votesModel::add($data); 
            } else {
                $update = Question_votesModel::update($data);
            }
        }
        
        return redirect('questions/'.$question_id);
    }

    // -- D O W N V O T E   P E R T A N Y A A N --
    public function downvote(Request $request)
    {
        //ambil data dari form
        $data = $request->all();
        unset($data["_token"]);

        //ambil question_id untuk keperluan redirect ke /questions/{question_id}
        $question_id = $data["question_id"];

        //cari apakah data vote dari user sudah ada
        $qv = Question_votesModel::find_byid($data["question_id"], $data["user_id"]);

        //jika sudah ada, set value nya sesuai yg didapat
        if ($qv != null) {
            $value = get_object_vars($qv)["value"];
        }

        //jika belum ada atau jika value vote dari user masih 0,
        //dan user yg klik upvote bukanlah user yg nulis pertanyaan,
        //dan reputasi user lebih dari atau sama dengan 15, maka lanjutkan
        if (($qv == null || $value == 0) && ($data["user_id"] != $data["question_author_id"]) && ($data["reputation"] >= 15)) {
            
            //unset data question author dan reputation terlebih dahulu karena tidak butuh untuk disimpan
            unset($data["question_author_id"]);
            unset($data["reputation"]);

            //beri nilai vote -1 dari user yg klik tombol downvote untuk pertanyaan yg bersangkutan
            $data["value"] = -1;

            //total downvotes di tabel question tersebut bertambah 1
            DB::table('questions')->where('id', $data["question_id"])->increment('downvotes');

            //jika belum ada data sebelumnya, buat record baru di tabel votes
            //jika sudah ada tapi dengan value masih 0, maka update value menjadi -1)
            if ($qv == null) {
                $add = Question_votesModel::add($data); 
            } else {
                $update = Question_votesModel::update($data);
            }
        }
        
        return redirect('questions/'.$question_id);
    }
}
