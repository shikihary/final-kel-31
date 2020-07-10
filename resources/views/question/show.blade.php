@extends('adminlte.master')

@section('content')
    <div class="ml-3 mt-3">
      <h1> {{ $question->judul }} </h1>
      <p class="text-secondary"> Tanggal dibuat : {{ date_format($question->created_at, 'd-m-Y') }} </p>
      <p> {{ $question->isi }} </p>
      @foreach($question->tags as $tag) 
        <button class="btn btn-default btn-sm"> {{$tag->tag_name}} </button>
      @endforeach
    </div>
    <div class="content-wrapper d-inline">
      <button type="button" class="btn btn-success">↑</button>
      <button type="button" class="btn btn-danger">↓</button>
      votes:
      {{ $question->upvotes - $question->downvotes }}<br>
    </div>

    <div class="ml-3 mt-3">
      <h3> Answers </h3> 
    </div>
    <!-- foreach disini -->
    @foreach($answers as $key => $data)
    <div class="ml-3 mt-3">
      <p class="text-secondary"> {{ date_format($question->created_at, 'd-m-Y') }} </p>
      <p> {{ $data->isi }} </p>
      
    </div>
    <div class="content-wrapper d-inline">
      <button type="button" class="btn btn-success">↑</button>
      <button type="button" class="btn btn-danger">↓</button>
      votes:
      {{ $question->upvotes - $question->downvotes }}<br>
      ___________________________________________________<br>
    </div>
    @endforeach

    <table class="table">
            <div class = "ml-3 pt-2 mb-2">
                <form action="/questions/{{$question->id}}" method="POST">
                    @csrf
                    <label for="exampleFormControlTextarea1">Jawab: </label>
                    <input type="hidden" id="$question_id" name="$question->id" value="">
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="isi" rows="3" placeholder="Input Jawaban di sini"></textarea>
                    <input class="btn btn-primary mt-2" type="submit" value="Post jawaban">
                </form>
            </div>
    </table>

@endsection