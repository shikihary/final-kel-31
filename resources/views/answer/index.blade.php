@extends('adminlte.master')

@section('content')
    <table class="table">
            <div class = "ml-3 pt-2 mb-2">
                <form action="/answers/{{$question_id}}" method="POST">
                    @csrf
                    <label for="exampleFormControlTextarea1">Jawaban Baru: </label>
                    <input type="hidden" id="$question_id" name="$question->id" value="{{$question_id}}">
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="isi" rows="3" placeholder="Input Jawaban di sini"></textarea>
                    <input class="btn btn-primary mt-2" type="submit" value="Buat Jawaban Baru">
                </form>
            </div>
    </table>
@endsection