@extends('layout/master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thuốc sắp hết</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Loại thuốc</th>
                    <th>Tên thuốc</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicines as $key => $medicine)
                <tr>
                    <td>{{++$key}}</td>
                    <td>{{$medicine->medCategory->med_category_name}}</td>
                    <td>{{$medicine->medicine_name}}</td>
                    <td>{{ $medicine->medicine_amount }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Loại thuốc</th>
                    <th>Tên thuốc</th>
                    <th>Số lượng</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection
