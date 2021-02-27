@extends('layout/master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lịch sử nhập thuốc</h3>
    </div>
    {{-- <div class="d-flex flex-row-reverse mr-3 mt-3"><a href="{{route('user.create')}}" class="btn btn-primary">Tạo thành viên</a></div>
    <!-- /.card-header -->
    <div class="card-body"> --}}
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tên thuốc</th>
                    <th>Số lượng</th>
                    <th>Thanh toán</th>
                    <th>Ngày nhập</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($users as $key => $user)
                <tr class="uid{{$user->id}}">
                    <td>{{$user->full_name}}</td>
                    <td><img src="{{asset('/storage/'.substr($user->image,7))}}" alt="" style="width: 100px; height:100px" ></td>
                    <td>{{$user->user_name}}</td>
                </tr>
                @endforeach --}}
            </tbody>
            <tfoot>
                <tr>
                    <th>Tên thuốc</th>
                    <th>Số lượng</th>
                    <th>Thanh toán</th>
                    <th>Ngày nhập</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection
