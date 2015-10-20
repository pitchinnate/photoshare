@extends('app')

@section('content')

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                @yield('content_header')
            </div>
            <div class="panel-body">
                @yield('content_body')
            </div>
            @yield('content_footer')
        </div>
    </div>
</div>

@endsection
