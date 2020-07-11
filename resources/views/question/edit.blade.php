@extends('adminlte.master')
@section('title', $question->judul . ' - Edit Pertanyaan')
@push('script-head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush
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
            <!-- Text Area Lama
            <textarea class="form-control" rows="5" id="isi" name="isi" placeholder="Input Isi">{{$question->isi}}</textarea>
            -->
            <textarea name="isi" class="form-control my-editor">{{$question->isi}}</textarea>
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