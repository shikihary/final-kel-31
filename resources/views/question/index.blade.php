@extends('adminlte.master')

@section('content')
  <div class="ml-3 mt-3">
    <h1>Pertanyaan</h1>
    <a href="/questions/create" class="btn btn-primary mb-2">
      Buat Pertanyaan
    </a>
    <table class="table table-bordered">
      <thead>                  
        <tr>
          <th style="width: 10px">No</th>
          <th>Judul</th>
          <th>Isi</th>
          <th>Tanggal dibuat</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($questions as $key => $question)
          <tr>
            <td> {{ $key+1 }} </td>
            <td> {{ $question->judul }} </td>
            <td> {{ $question->isi }} </td>
            <td> {{ $question->created_at }} </td>
            <td>
            <a href="/answers/{{$question->id}}" class="btn btn-sm btn-info">Jawaban</a>
              <a href="/questions/{{$question->id}}" class="btn btn-sm btn-info">show</a>
              <a href="/questions/{{$question->id}}/edit" class="btn btn-sm btn-default">edit</a>
              <form action="/questions/{{$question->id}}" method="post" style="display: inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i> </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection