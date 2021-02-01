@extends('layout/master')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách bác sĩ</h3>
        <a href="{{route('setting.create')}}" class="btn btn-primary float-right">Thêm+</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên bác sĩ</th>
                    <th>Học vị</th>
                    <th>Tên phòng khám</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                @foreach($settingApps as $key =>$settingApp)
                <tr>

                    <td>{{ ++$key }}</td>
                    <td>{{ $settingApp->name_doctor }}</td>
                    <td>{{ $settingApp->degree }}</td>
                    <td>{{ $settingApp->name_clinic }}</td>
                    <td>{{ $settingApp->phone }}</td>
                    <td>{{ $settingApp->address }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="{{route('setting.edit',$settingApp->id)}}" class="mr-2 "> <i class="nav-icon fas fa-edit"></i> Sửa</a>
                        <a style="color: red" href="{{route('setting.destroy',$settingApp->id)}}"> <i class="nav-icon far fa-trash-alt" style="color: red"></i> Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection
