@extends('adminlte.master')
@section('title', 'Pertanyaan ' . $user->name)
@section('content')
  <div class="ml-3 mt-3">
    <h1>Pertanyaan&nbsp;{{ $user->name }}</h1>
    <p>Reputasi :&nbsp;{{ $user->reputation }}</p>
    <table class="table table-borderless">
      <!-- tabel lama:
      <thead>                  
        <tr>
          <th style="width: 10px">No</th>
          <th>Judul</th> 
          <th>Isi</th>
          <th>Tanggal dibuat</th>
          
          <th>Actions</th>
        </tr>
      </thead>
      -->
      <tbody>
        @foreach($questions as $key => $question)
          <tr>
            <!-- tabel lama:
            <td> {{ $key+1 }} </td>
            <td> {{ $question->judul }} </td>
            <td> {{ $question->isi }} </td>
            <td> {{ $question->created_at }} </td>
            <td> -->
            <td style="text-align:center"> <p class="text-success">{{ $question->upvotes - $question->downvotes }}<br>votes </p>
            </td>
            <td> <a href="/questions/{{$question->id}}" class="text-decoration-none"><h4>{{ $question->judul }}</h4></a>
                 <p> {!! $question->isi !!}<br> </p>
                 <p class="text-secondary">Tanggal dibuat : {{ date_format($question->created_at, 'd-m-Y') }}</p>
                 <p class="text-secondary">Terakhir diubah pada : {{ date_format($question->created_at, 'd-m-Y') }}</p>
            </td>
            
            <td>
            <a href="/questionComments/{{$question->id}}" class="btn btn-sm btn-info">Komentar</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection