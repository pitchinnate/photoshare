@extends('auth')

@section('content_header')
    <h3>All Users</h3>
@endsection

@section('content_body')
    <div class="container-fluid">
        <table class='table table-striped table-condensed'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date Registered</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{ date('F j, Y', strtotime($user->created_at)) }}</td>
                <td style="text-align: right;">
                    @if($user->is_admin == 1)
                    <div class='label label-success label-as-badge'>ADMIN</div>
                    @else
                    <a href="/user/admin/{{$user->id}}" class="btn btn-xs btn-default">Make Admin</a>
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

@endsection