@extends('adminlte.master')

@section('title', 'Forum Developer')

@section('content')
  <div class="ml-3">
    <h1 class="float-left">Pertanyaan</h1>
    <a href="/questions/create" class="btn btn-primary mr-3 mt-2 float-right">
      Buat Pertanyaan
    </a>
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

            <td style="text-align:center">
                <p class="text-success">{{ $question->upvotes - $question->downvotes }}<br>votes</p>
            </td>
            <td colspan="2"> <a href="/questions/{{$question->id}}" class="text-decoration-none"><h4>{{ $question->judul }}</h4></a>
                 <p> {!! $question->isi !!}<br> </p>             
            </td>
            </tr>
              <td></td>
              <td>
                  <span class="text-secondary">Tanggal dibuat : {{ date_format($question->created_at, 'd-m-Y') }}</span>
                  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                  <span class="text-secondary">Terakhir diubah pada : {{ date_format($question->created_at, 'd-m-Y') }}</span>
              </td>
            <div class="col-6 offset-3" id="test">

            <td>
            <a href="/questionComments/{{$question->id}}" class="btn btn-sm btn-info">Komentar</a>
                <div class="dropdown btn">
                  <a data-toggle="dropdown"><i class="fa fa-ellipsis-h fa-1x waves-effect"></i></a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="/questions/{{$question->id}}/edit">Edit</a>
                    <form action="/questions/{{$question->id}}" method="post" style="display: inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item" >Hapus</button>
                    </form>
                  </div>
                </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection