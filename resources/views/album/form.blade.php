@extends('auth')

@section('content_header')
    <h3>Create Album</h3>
@endsection

@section('content_body')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('/album/new') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">
        <label class="col-md-3 control-label">Album Name</label>
        <div class="col-md-7">
            <input type="text" class="form-control" name="Album[name]" value="{{ old('name') }}">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-7 col-md-offset-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>

@endsection

@section('content_footer')

@endsection

@section('javascript')

@endsection