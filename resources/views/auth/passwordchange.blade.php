@extends('auth')

@section('content_header')
    <h3>Change Your Password</h3>
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

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/update') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label class="col-md-4 control-label">Current Password</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="oldpassword" value="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">New Password</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password" value="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Confirm New Password</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation" value="">
            </div>
        </div>
        <div class="form-group">
            <div class='col-md-6 col-md-offset-4'>
                <input type='submit' value='Update Password' class='btn btn-primary' />
            </div>
        </div>
    </form>
@endsection