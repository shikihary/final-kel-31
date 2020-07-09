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
      {{ $question->upvotes - $question->downvotes }}
    </div>
@endsection