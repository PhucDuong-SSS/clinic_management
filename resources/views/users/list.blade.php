@extends('layout/master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách thành viên</h3>
    </div>
    <div class="d-flex flex-row-reverse mr-3 mt-3"><a href="{{route('user.create')}}" class="btn btn-primary">Tạo thành viên</a></div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>images</th>
                    <th>UserName</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                <tr>
                    <td>{{$user->full_name}}</td>
                    <td><img src="{{asset('/storage/'.substr($user->image,7))}}" alt="" style="width: 100px; height:100px" ></td>
                    <td>{{$user->user_name}}</td>
                    <td>{{$user->address}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->email}}</td>
                    <td><a class="btn btn-info" href="{{route('user.edit', $user->id)}}">Edit</a></td>
                    <td><a class="btn btn-danger" href="{{route('user.destroy', $user->id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>images</th>
                    <th>UserName</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection
