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
                                        <a href="" class="btn btn-sm btn-warning" title="Chi tiết"><i class="fa fa-eye"></i></a>
                                        <a href="" class="btn btn-sm btn-info" title="Sửa"><i class="fa fa-edit"></i></a>
                                        <a href="" class="btn btn-sm btn-info" title="Tái khám"><i class="far fa-plus-square"></i></a>
                                        <a href="" class="btn btn-sm btn-danger" title="Xóa" id="delete"><i class="fa fa-trash"></i></a>
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
