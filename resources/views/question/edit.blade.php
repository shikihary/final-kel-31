@extends('adminlte.master')

@section('content')
  <div class="ml-3 mt-3">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit Pertanyaan</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
     <form role="form" action="/questions/{{$question->id}}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="card-body">
          <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" class="form-control" id="judul" value="{{$question->judul}}" name="judul" placeholder="Input Judul">
          </div>
          <div class="form-group">
            <label for="isi">Isi</label>
            <textarea class="form-control" rows="5" id="isi" name="isi" placeholder="Input Isi">{{$question->isi}}</textarea>
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
@endsection