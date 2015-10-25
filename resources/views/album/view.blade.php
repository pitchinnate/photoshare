@extends('auth')

@section('content_header')
    @if(Request::user()->is_admin == 1)
    <div class="pull-right">
        <a href="/album/{{ $album->id }}/upload" class="btn btn-success"><i class='fa fa-upload'></i> Upload Photos</a>
    </div>
    @endif
    <h3>{{ $album->name }} <span class='small'>({{ $album->photos()->count() }} Photos Found)</span></h3>
@endsection

@section('content_body')

<div class="container-fluid">
    
    @if($pages > 1)
        <div class='row'>
            Page: 
        @for($x=1;$x<=$pages;$x++)
            @if($page == $x)
            <div class='btn btn-default disabled'>{{ $x }}</div>
            @else
            <a href='/album/{{ $album->id }}/{{ $x }}' class='btn btn-primary'>{{ $x }}</a>
            @endif
        @endfor
        </div>
    @endif
    
    @foreach($album->photos->forPage($page, env('PAGE_SIZE',15)) as $photo)
        <a href="/photo/view/{{ $photo->id }}" class="thumbnail pull-left album-tile">
            <img src="{{$photo->getThumbnail()}}" class="img-rounded" />
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