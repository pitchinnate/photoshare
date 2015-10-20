@extends('auth')

@section('content_header')
    @if(Request::user()->is_admin == 1)
    <div class="pull-right">
        <a href="/album/{{ $album->id }}/upload" class="btn btn-success"><i class='fa fa-upload'></i> Upload Photos</a>
    </div>
    @endif
    <h3>{{ $album->name }}</h3>
@endsection

@section('content_body')

<div class="container-fluid">
    @foreach($album->photos as $photo)
        <a href="/photo/view/{{ $photo->id }}" class="thumbnail pull-left album-tile">
            <img src="{{$photo->getUrl()}}" class="img-rounded" />
            <div class="caption center-text">
                {{$photo->name}}
            </div>
        </a>
    @endforeach
    @if($album->photos()->count() == 0)
    <div class="center-block center-text">
        <h3>No Images Found</h3>
    </div>
    @endif
    <div class="clearfix"></div>
</div>

@endsection

@section('javascript')

@endsection