@extends('auth')

@section('content_header')
    <h3>Invite New User</h3>
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

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/invite') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label class="col-md-4 control-label">Name</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">E-Mail Address</label>
            <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-4 control-label">Select Albums</label>
            <div class="col-md-6">
                @foreach($albums as $album)
                <label class='checkbox checkbox-inline'>
                    <input type='checkbox' name='albums[]' value='{{ $album->id }}' /> {{ $album->name }}
                </label>
                <br>
                @endforeach
            </div>
        </div>
        
        <div class="form-group">
            <div class='col-md-6 col-md-offset-4'>
                <input type='submit' value='Send Invite' class='btn btn-primary' />
            </div>
        </div>
    </form>
@endsection

@section('content_footer')

@endsection

@section('javascript')

@endsection