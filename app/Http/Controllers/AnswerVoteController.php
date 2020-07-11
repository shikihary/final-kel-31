<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Answer_votesModel;
use App\User;

class AnswerVoteController extends Controller
{
    // -- U P V O T E   J A W A B A N --
    public function upvote(Request $request)
    {
        //ambil data dari form
        $data = $request->all();
        unset($data["_token"]);

        //ambil question_id untuk keperluan redirect ke /questions/{question_id}
        $question_id = $data["question_id"];

        //tampilkan error jika reputasi di bawah 15
        if ($data["reputation"] < 15) {
            Alert::error('Reputasi kurang', 'Butuh 15 poin reputasi untuk melakukan downvote');
        }
        //jika tidak:
        else {

            //cari apakah data vote dari user sudah ada
            $qv = Answer_votesModel::find_byid($data["answer_id"], $data["user_id"]);

            //jika sudah ada, set value nya sesuai yg didapat
            if ($qv != null) {
                $value = get_object_vars($qv)["value"];
            }

            //jika belum ada atau jika value vote dari user masih 0,
            //dan user yg klik upvote bukanlah user yg nulis jawaban, maka lanjutkan
            if (($qv == null || $value == 0) && ($data["user_id"] != $data["answer_author_id"])) {
                
                //unset question id terlebih dahulu karena tidak butuh untuk disimpan
                unset($data["question_id"]);

                //beri nilai vote +1 dari user yg klik tombol upvote untuk jawaban yg bersangkutan
                $data["value"] = 1;

                //total upvotes di tabel answer tersebut bertambah 1
                DB::table('answers')->where('id', $data["answer_id"])->increment('upvotes');

                //reputasi user yg memberi pertanyaan bertambah 10
                $user = User::find($data["question_author_id"]);
                $user->reputation = $user->reputation + 10;
                $user->save();

                //unset data question author karena tidak diperlukan selanjutnya
                unset($data["question_author_id"]);

                //jika belum ada data sebelumnya, buat record baru di tabel votes
                //jika sudah ada tapi dengan value masih 0, maka update value menjadi 1)
                if ($qv == null) {
                    $add = Answer_votesModel::add($data); 
                } else {
                    $update = Answer_votesModel::update($data);
                }
            }
        }
        
        return redirect('questions/'.$question_id);
    }

    // -- D O W N V O T E   J A W A B A N --
    public function downvote(Request $request)
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
        //dan user yg klik upvote bukanlah user yg nulis jawaban,
        //dan reputasi user lebih dari atau sama dengan 15, maka lanjutkan
        if (($qv == null || $value == 0) && ($data["user_id"] != $data["answer_author_id"]) && ($data["reputation"] >= 15)) {
            
            //unset data answer author dan question id terlebih dahulu karena tidak butuh untuk disimpan
            unset($data["answer_author_id"]);
            unset($data["question_id"]);

            //beri nilai vote -1 dari user yg klik tombol downvote untuk jawaban yg bersangkutan
            $data["value"] = -1;

            //total downvotes di tabel answer tersebut bertambah 1
            DB::table('answers')->where('id', $data["answer_id"])->increment('downvotes');

            //reputasi user yg melakukan downvote berkurang 1
            $user = User::find($data["user_id"]);
            $user->reputation = $user->reputation - 1;
            $user->save();

            //unset reputation karena tidak akan disimpan
            unset($data["reputation"]);

            //jika belum ada data sebelumnya, buat record baru di tabel votes
            //jika sudah ada tapi dengan value masih 0, maka update value menjadi -1)
            if ($qv == null) {
                $add = Answer_votesModel::add($data); 
            } else {
                $update = Answer_votesModel::update($data);
            }
        }
        
        return redirect('questions/'.$question_id);
    }
}
