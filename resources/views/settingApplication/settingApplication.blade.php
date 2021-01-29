@extends('layout/master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Bảng triệu chứng</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên bác sĩ</th>
                    <th>Học vị</th>
                    <th>Tên phòng khám</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Nguyễn Văn A</td>
                    <td>Tiến sĩ</td>
                    <td>Phòng khám QTP</td>
                    <td>0965325323</td>
                    <td>28 Nguyễn Tri Phương</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Tên bác sĩ</th>
                    <th>Học vị</th>
                    <th>Tên phòng khám</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection
