<?php
             $roleOfUser = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.id_user')
            ->join('roles', 'user_role.role_key', '=', 'roles.id')
            ->where('users.id', auth()->id())->select('roles.*')->get()->pluck('id');
            $permissionOfRole = DB::table('roles')
            ->join('role_permission', 'roles.id', '=', 'role_permission.role_key')
            ->join('permissions', 'role_permission.permission_key', '=', 'permissions.id')
            ->where('roles.id', $roleOfUser)
            ->select('permissions.*')->get()->pluck('id')->unique();
            $checkPrintPres = DB::table('permissions')->where('permission_name', 'print_prescription')->value('id');
            $checkDeletePres = DB::table('permissions')->where('permission_name', 'delete_prescription')->value('id');
            $checkExPres = DB::table('permissions')->where('permission_name', 'word_prescription')->value('id');
?>
@extends('layout/master')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách đơn thuốc</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên bệnh nhân</th>
                                    <th>Số điện thoại</th>
                                    <th>Ngày khám</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($prescriptions as $index=> $prescription)

                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>
                                     {{$prescription->patient->full_name}}
                                    </td>
                                    <td>{{$prescription->patient->phone_number}}</td>
                                    <td> {{$prescription->exam_date}}</td>
                                    <td>
                                        @if($permissionOfRole->contains($checkPrintPres))
                                        <a href="{{route('prescription.print',$prescription->id)}}" class="btn btn-sm btnprn btn-warning" title="In"><i class="fas fa-print"></i>
                                        </a>
                                        @endif
                                        @if($permissionOfRole->contains($checkExPres))
                                        <a href="{{route('prescription.exportWord',$prescription->id)}}" class="btn btn-sm btnprn btn-warning" title="Export word"><i class="fas fa-file-export"></i>
                                        </a>
<<<<<<< HEAD
                                        @endif
                                         @if($permissionOfRole->contains($checkDeletePres))
                                        <a href="{{route('prescription.delete',$prescription->id)}}" class="btn btn-sm btn-danger" title="Xóa" id="delete"><i class="fa fa-trash"></i></a>
                                        @endif
=======

                                        <a href="{{route('prescription.delete',$prescription->id)}}" class="btn btn-sm btn-danger delete-confirm" title="Xóa" id="delete"><i class="fa fa-trash"></i></a>
>>>>>>> master
                                        @foreach($arrIndexByReExam as $arr)
                                            @if($arr == ($index+1))
                                               <a href="{{route('prescription.reExam',$prescription->id)}}" class="btn btn-sm btn-info" title="Tái khám"><i class="far fa-plus-square"></i></a>
                                                <span class="badge badge-success">Đơn thuốc mới nhất</span>
                                            @endif

                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>

@endsection

@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function () {
        $('.delete-confirm').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'Are you sure?',
        text: 'Bạn có chắc chắn muốn xóa đơn thuốc này không?',
        icon: 'warning',
        buttons: ["Hủy", "Yes!"],
    }).then(function(value) {
        if (value) {
            window.location.href = url;
        }
    });
});
    });
</script>
@endsection
