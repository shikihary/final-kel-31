@extends('adminlte.master')

@section('title', $question->judul . ' - Forum Dev')

@push('script-head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <!--script sementara buat vote-->
    <script type="text/javascript">
    var votes = 0;
    function upvote(){
        votes++;
        document.getElementById('display').innerHTML = votes;
    }

    function downvote(){
        votes--;
        document.getElementById('display').innerHTML = votes;
    }
    </script>
    <!--script sampe sini-->
@endpush

@section('content')
    <div class="ml-3">
      <h1> {{ $question->judul }} </h1>
      <p class="text-secondary"> Tanggal dibuat : {{ date_format($question->created_at, 'd-m-Y') }} <br>
      Terakhir diubah pada : {{ date_format($question->updated_at, 'd-m-Y') }} </p>
      <p> {!! $question->isi !!} </p>
      @foreach($question->tags as $tag) 
        <button class="btn btn-default btn-sm"> {{$tag->tag_name}} </button>
      @endforeach
      <p class="d-inline text-secondary">votes: {{ $question->upvotes - $question->downvotes }}<p>
    </div>
    <div class="content-wrapper d-inline">
      <!--button upvote/downvote sementara: belum diintegrasi fungsi ke database-->
      <button onclick="downvote()" type="button" class="btn btn-danger float-right mx-1">↓</button>
      
      <!-- PART INI BUAT UPVOTE PERTANYAAN -->
      <form action="{{ route('question.upvote') }}" method="POST">
        @csrf
        <input type="hidden" id="question_id" name="question_id" value="{{ $question->id }}">
        <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" id="question_author_id" name="question_author_id" value="{{ $question->user_id }}">
        <button type="submit" class="btn btn-success float-right mx-1">↑</button>
      </form>

    </div>

    <div class="ml-3 mt-3">
      <h3> Answers </h3> 
    </div>
    <!-- foreach disini -->
    @foreach($answers as $key => $data)
        <div class="mx-3 card">
          <div class="card-header text-secondary">{{ date_format($data->created_at, 'd-m-Y') }}</div>
          <div class="card-body">
            <p> {!! $data->isi !!} </p>
          </div>
        </div>
        <div class="card-footer d-inline bg-light">
          <a href="/answerComments/{{$data->id}}" class="badge badge-info float-left ml-3">Komentar</a>
          <button type="button" class="btn btn-danger float-right mx-1">↓</button>
          <button type="button" class="btn btn-success float-right mx-1">↑</button>          
            <form class="d-inline" role="form" action="/bestanswer/{{$data->id}}/{{$data->question_id}}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary float-right mx-1">Best Answer</button>
          </form>
          @if($data->is_best_answer == 1)
              <button type="button" class= "btn btn-outline-success float-right mx-1">Verified</button>
            @endif
            <p class="d-inline text-secondary">votes: {{ $data->upvotes - $data->downvotes }}<p>
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
                    <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
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