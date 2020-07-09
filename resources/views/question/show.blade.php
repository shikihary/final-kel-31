@extends('adminlte.master')

@section('content')
    <div class="ml-3 mt-3">
      <h3>Detail Pertanyaan</h3>
      <p> Judul : {{ $question->judul }} </p>
      <p> Isi : {{ $question->isi }} </p>
      <p> Tanggal dibuat : {{ $question->created_at }} </p>
      @foreach($question->tags as $tag) 
        <button class="btn btn-default btn-sm"> {{$tag->tag_name}} </button>
      @endforeach
    </div>
@endsection