@extends('auth')

@section('content_header')
    <div class="pull-right">
        <a href="/albums" class="btn btn-default"><i class='fa fa-arrow-left'></i> Back</a>
    </div>
    <h3>Send Email to Album <b>{{ $album->name }}</b> users</h3>
@endsection

@section('content_body')
<form class="form-horizontal" role="form" action="/album/{{ $album->id}}/notify" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="container-fluid">
        <div class="well" style="padding: 10px 50px;">
            <div class="form-group">
                <label>Email Subject</label>
                <input type="text" class="form-control" name="subject" />
            </div>
            <div class="form-group">
                <label>Email Message</label>
                <textarea class="form-control" name="message"></textarea>
            </div>
        </div>
        
        <table class='table table-striped table-condensed'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Send Message</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <input type="checkbox" name="user[]" value="{{ $user->id }}" />
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        
        <input type="submit" value="Send Messages" class="btn btn-primary pull-right" />
    </div>
</form>
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