@extends('adminlte.master')

@section('content')
  <div class="ml-3 mt-3">
    <h1>Users</h1>
    <div class="row">
        @foreach($users as $key => $user)
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $user->name }}</h3>

                <p>Reputasi:{{ $user->reputation }}</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="{{ url('/questions/user/'.$user->id) }}" class="small-box-footer">Lihat pertanyaan <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        @endforeach
    </div>
  </div>

@endsection