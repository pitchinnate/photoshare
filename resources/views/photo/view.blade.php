@extends('auth')

@section('content_header')
    <div class="pull-right">
        <a href="/album/{{ $photo->album_id }}" class="btn btn-default"><i class='fa fa-arrow-left'></i> Back</a>
        <a href="/photo/{{ $photo->id }}" class="btn btn-primary"><i class='fa fa-download'></i> Download Image</a>
    </div>
    <h3>{{ $photo->album->name }}:  {{$photo->name}}</h3>
@endsection

@section('content_body')

<div class="container-fluid">
    <img src="{{$photo->getUrl()}}" style='max-width: 100%;' />
</div>

@endsection

@section('javascript')

@endsection