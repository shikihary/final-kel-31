@extends('adminlte.master')
@push('script-head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush
@section('content')
    <table class="table">
        <thead>
            <div class = "ml-3 pt-2 mb-2">
                <form action="/answers/{{$question_id}}" method="POST">
                    @csrf
                    <label for="exampleFormControlTextarea1">Jawab: </label>
                    <input type="hidden" id="$question_id" name="$question->id" value="{{$question_id}}">
                    <!-- Text Area Lama
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="isi" rows="3" placeholder="Input Jawaban di sini"></textarea>
                    -->
                    <textarea name="isi" class="form-control my-editor">{!! old('isi', $isi ?? '') !!}</textarea>
                    <input class="btn btn-primary mt-2" type="submit" value="Post Jawaban">
                </form>
            </div>
        <tr>
            <th>No</th>
            <th>Isi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($answer as $key => $data)
            <tr>
                <th>{{$key+1}}</th>
                <th>{!!$data->isi!!}</th>
            </tr>
        @endforeach
        </tbody>
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