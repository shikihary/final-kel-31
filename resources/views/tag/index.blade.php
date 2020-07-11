@extends('adminlte.master')
@section('title', 'Tags')
@section('content')
  <div class="ml-3 mt-3">
    <h1>Tags</h1>
    <div class="row">
        @foreach($tags as $key => $tag)
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $tag->tag_name }}</h3>
                <br>
              </div>
              <div class="icon">
                <i class="ion ion-bookmark"></i>
              </div>
              <a href="{{ url('/tags/'.$tag->id) }}" class="small-box-footer">Lihat pertanyaan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        @endforeach
    </div>
  </div>

@endsection