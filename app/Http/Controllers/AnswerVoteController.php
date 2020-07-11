<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Answer_votesModel;

class AnswerVoteController extends Controller
{
    public function upvote(Request $request)
    {
        //ambil data dari form
        $data = $request->all();
        unset($data["_token"]);

        //ambil question_id untuk keperluan redirect ke /questions/{question_id}
        $question_id = $data["question_id"];

        //cari apakah data vote dari user sudah ada
        $qv = Answer_votesModel::find_byid($data["answer_id"], $data["user_id"]);

        //jika sudah ada, set value nya sesuai yg didapat
        if ($qv != null) {
            $value = get_object_vars($qv)["value"];
        }

        //jika belum ada atau jika value vote dari user masih 0,
        //dan user yg klik upvote bukanlah user yg nulis pertanyaan, maka lanjutkan
        if (($qv == null || $value == 0) && ($data["user_id"] != $data["answer_author_id"])) {
            
            //unset data answer author dan answer id terlebih dahulu karena tidak butuh untuk disimpan
            unset($data["answer_author_id"]);
            unset($data["question_id"]);

            //beri nilai vote +1 dari user yg klik tombol upvote untuk pertanyaan yg bersangkutan
            $data["value"] = 1;

            //total upvotes di tabel answer tersebut bertambah 1
            DB::table('answers')->where('id', $data["answer_id"])->increment('upvotes');

            //jika belum ada data sebelumnya, buat baru record baru di tabel votes
            //jika sudah ada tapi dengan value masih 0, maka update value menjadi 1)
            if ($qv == null) {
                $add = Answer_votesModel::add($data); 
            } else {
                $update = Answer_votesModel::update($data);
            }
        }
        
        return redirect('questions/'.$question_id);
    }
}
