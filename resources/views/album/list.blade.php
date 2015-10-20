@extends('auth')

@section('content_header')
    @if(Request::user()->is_admin == 1)
    <div class="pull-right">
        <a href="/album/new" class="btn btn-success"><i class='fa fa-plus'></i> Add Album</a>
    </div>
    @endif
    <h3>Photo Albums</h3>
@endsection

@section('content_body')
    <div class="container-fluid">
        @foreach($albums as $album)
            <div class="thumbnail pull-left album-tile">
                <a href="/album/{{ $album->id }}">
                    @if($album->photos()->count() > 0)
                    <img src="{{$album->photos[0]->getUrl()}}" class="img-rounded" />
                    @else
                    <img src="/img/missing.jpg" class="img-rounded" />
                    @endif
                </a>
                <div class="caption center-text">
                    <a href="/album/{{ $album->id }}">
                        <h5>{{$album->name}}</h5>
                    </a>
                    @if(Request::user()->is_admin == 1)
                    <a href="/album/{{ $album->id }}/users" class="btn btn-primary"><i class='fa fa-users'></i> Authorized Users</a>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="clearfix"></div>
    </div>
@endsection

@section('content_footer')

@endsection

@section('javascript')

@endsection