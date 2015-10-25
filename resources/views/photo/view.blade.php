@extends('auth')

@section('content_header')
    <div class="pull-right">
        @if(Request::user()->is_admin == 1)
        <div class="btn btn-danger" id="delete"><i class='fa fa-remove'></i></div>
        <a href="/photo/rotate/{{ $photo->id }}/-90" class="btn btn-default"><i class='fa fa-repeat'></i> Rotate</a>
        <a href="/photo/rotate/{{ $photo->id }}/90" class="btn btn-default"><i class='fa fa-undo'></i> Rotate</a>
        @endif
        <a href="/album/{{ $photo->album_id }}" class="btn btn-default"><i class='fa fa-arrow-left'></i> Back</a>
        <a href="/photo/{{ $photo->id }}" class="btn btn-primary"><i class='fa fa-download'></i> Download Image</a>
    </div>
    <h3>{{ $photo->album->name }}:  {{$photo->name}}</h3>
@endsection

@section('content_body')

<div class="container-fluid">
    <div class="row">
        <div class="imgcontainer">
            <div class="leftarrow">
                <a href="/photo/view/{{ $photo->id}}/prev">prev</a>
            </div>
            <div class="rightarrow">
                <a href="/photo/view/{{ $photo->id}}/next">next</a>
            </div>
            <img src="{{$photo->getUrl()}}" style='max-width: 100%;' class="bigimg" />
        </div>
    </div>
</div>

@endsection

@section('javascript')

<script>
    
$(document).ready(function(){
    $('#delete').click(function(){
        var confirm = window.confirm('Are you sure you want to delete the picture?');
        if(confirm === true) {
            window.location = '/photo/delete/{{ $photo->id }}';
        }
    });
    $(document).keydown(function(e) {
        switch(e.which) {
            case 37: // left
                window.location = "/photo/view/{{ $photo->id }}/prev";
            break;

            case 39: // right
                window.location = "/photo/view/{{ $photo->id}}/next";
            break;

            default: return; // exit this handler for other keys
        }
        e.preventDefault(); // prevent the default action (scroll / move caret)
    });
});
    
</script>

@endsection