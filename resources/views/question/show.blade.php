@extends('adminlte.master')
@push('script-head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush
@section('content')
    <div class="ml-3 mt-3">
      <h1> {{ $question->judul }} </h1>
      <p class="text-secondary"> Tanggal dibuat : {{ date_format($question->created_at, 'd-m-Y') }} </p>
      <p class="text-secondary"> Terakhir diubah pada : {{ date_format($question->updated_at, 'd-m-Y') }} </p>
      <p> {!! $question->isi !!} </p>
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
      @if($data->is_best_answer == 1)
        <div class="ml-3 mt-3 bg-success">
      @else
        <div class="ml-3 mt-3">
      @endif
          <p class="text-secondary"> {{ date_format($data->created_at, 'd-m-Y') }} </p>
          <p> {!! $data->isi !!} </p>
        </div>
        <div class="content-wrapper d-inline">
          <a href="/answerComments/{{$data->id}}" class="btn btn-sm btn-info float-left ml-3">Komentar</a>
          <form class="content-wrapper d-inline" role="form" action="/bestanswer/{{$data->question_id}}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Best Answer</button>
          </form>
          <button type="button" class="btn btn-success">↑</button>
          <button type="button" class="btn btn-danger">↓</button>
          votes:
          {{ $data->upvotes - $data->downvotes }}<br>
          ________________________________________________________<br>
        </div>

    @endforeach

    <table class="table">
            <div class = "ml-3 pt-2 mb-2">
                <form action="/questions/{{$question->id}}" method="POST">
                    @csrf
                    <label for="exampleFormControlTextarea1">Jawab: </label>
                    <input type="hidden" id="$question_id" name="$question_id" value="">
                    <!-- Text Area Lama
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="isi" rows="3" placeholder="Input Jawaban di sini"></textarea>
                    -->
                    <textarea name="isi" class="form-control my-editor">{!! old('isi', $isi ?? '') !!}</textarea>
                    <input class="btn btn-primary mt-2" type="submit" value="Post Jawaban">
                </form>
            </div>
    </table>

@endsection

@push('scripts')
    <script>
    var editor_config = {
        path_absolute : "/",
        selector: "textarea.my-editor",
        plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
        file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
            file : cmsURL,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            resizable : "yes",
            close_previous : "no"
        });
        }
    };

    tinymce.init(editor_config);
    </script>
@endpush