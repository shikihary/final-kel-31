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
    <!-- foreach disini -->
      <p class="text-secondary"> Tanggal dibuat : {{ date_format($question->created_at, 'd-m-Y') }} </p>
      <p> {{ $question->isi }} </p>
    </div>
    <div class="content-wrapper d-inline">
      <button type="button" class="btn btn-success">↑</button>
      <button type="button" class="btn btn-danger">↓</button>
      votes:
      {{ $question->upvotes - $question->downvotes }}
    </div>

    <!-- naikin bagian ini ke atas, nanti ini dihapus -->
    <table class="table table-borderless">
            <th>No</th>
            <th>Isi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($answers as $key => $data)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$data->isi}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection