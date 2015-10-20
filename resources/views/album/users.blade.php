@extends('auth')

@section('content_header')
    <div class="pull-right">
        <a href="/albums" class="btn btn-default"><i class='fa fa-arrow-left'></i> Back</a>
    </div>
    <h3>Album: {{ $album->name }} Users</h3>
@endsection

@section('content_body')
    <div class="container-fluid">
        <table class='table table-striped table-condensed'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Access</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    @if($user->hasAccess($album->id))
                    <div class='access btn btn-success' data-user='{{$user->id}}' data-access='1'>Yes</div>
                    <div class='access btn btn-default' data-user='{{$user->id}}' data-access='0'>No</div>
                    @else
                    <div class='access btn btn-default' data-user='{{$user->id}}' data-access='1'>Yes</div>
                    <div class='access btn btn-danger' data-user='{{$user->id}}' data-access='0'>No</div>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('content_footer')

@endsection

@section('javascript')

<script>
$(document).ready(function(){

    $('.access').click(function(e) {
        var button = $(this);
        var userid = button.data('user');
        var access = button.data('access');
        
        $.post('/album/{{ $album->id }}/user',{album_user: {user: userid, access: access}},function(data) {
            console.log(data);
            if(access == 1) {
                $('.access[data-user="'+userid+'"][data-access="0"]').addClass('btn-default');
                $('.access[data-user="'+userid+'"][data-access="0"]').removeClass('btn-danger');
                $('.access[data-user="'+userid+'"][data-access="1"]').addClass('btn-success');
                $('.access[data-user="'+userid+'"][data-access="1"]').removeClass('btn-default');
            } else {
                $('.access[data-user="'+userid+'"][data-access="0"]').removeClass('btn-default');
                $('.access[data-user="'+userid+'"][data-access="0"]').addClass('btn-danger');
                $('.access[data-user="'+userid+'"][data-access="1"]').removeClass('btn-success');
                $('.access[data-user="'+userid+'"][data-access="1"]').addClass('btn-default');
            }
        });
    });

});
</script>

@endsection