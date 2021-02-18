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
                                        <a href="{{route('prescription.print',$prescription->id)}}" class="btn btn-sm btnprn btn-warning" title="In"><i class="fas fa-print"></i>
                                        </a>

                                        <a href="{{route('prescription.delete',$prescription->id)}}" class="btn btn-sm btn-danger" title="Xóa" id="delete"><i class="fa fa-trash"></i></a>
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

