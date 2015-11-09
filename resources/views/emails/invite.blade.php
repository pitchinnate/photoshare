{{ $current->name }} has invited you to join {{ $domain }} and given you access to the
following photo albums:<br><br>
@foreach($albums as $album)
 - {{ $album->name }}<br>
@endforeach
<br><br>
To complete your registration simply click the link below and you will enter in 
your password.<br><br>
<a href='{{ route('user.invited',['email'=>$user->email,'token'=>$token]) }}'>
    {{ route('user.invited',['email'=>$user->email,'token'=>$token]) }}
</a>