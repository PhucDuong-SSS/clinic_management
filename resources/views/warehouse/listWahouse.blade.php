@extends('layout/master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kho Thuốc</h3>
    </div>
    <div class="d-flex flex-row-reverse mr-3 mt-3"><a href="{{route('lots.create')}}" class="btn btn-primary">Nhập kho</a></div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Ngày nhập</th>
                    <th>Mã Đơn Hàng</th>
                    <th>Tên thuốc</th>
                    <th>Số lượng</th>
                    <th>Giá nhập</th>
                    <th>Ngày sản xuất</th>
                    <th>Ngày hết hạn</th>
                    <th>Tổng giá</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lots as $key => $lot)
                <tr class="mid{{$lot->id}}">
                    <td>{{$lot->created_at}}</td>
                    <td>{{$lot->code}}</td>
                    <td>{{$lot->medicines->medicine_name}}</td>
                    <td>{{ $lot->medicine_amount }}</td>
                    <td>{{ $lot->unit_price }}</td>
                    <td>{{ $lot->expired_date }}</td>
                    <td>{{ $lot->receipt_date }}</td>
                    <td>{{ $lot->total_price }}</td>
                    <td><a class="btn btn-info" href="{{route('lots.edit', $lot->id)}}">Edit</a></td>
                    <td><a href="javascript:void(0)" class="btn btn-danger" onclick="deleteLots({{$lot->id}})">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Ngày nhập</th>
                    <th>Mã Đơn Hàng</th>
                    <th>Tên thuốc</th>
                    <th>Số lượng</th>
                    <th>Giá nhập</th>
                    <th>Ngày sản xuất</th>
                    <th>Ngày hết hạn</th>
                    <th>Tổng giá</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@endsection
@section('script')
<script>

     $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
        });
        initEventEditButtons();
    });
    function deleteLots(id){
        Swal.fire({
            title: 'Bạn có muốn xóa không?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
                console.log("vao");
            $.ajax({
                url:'lots/destroy/'+id,
                type:'DELETE',
                data:{
                    _token: $("input[name=_token]").val()
                },
                success:function (response){
                    console.log(response);
                    $("#mid"+id).remove();
                    location.reload();
                }
            })
                Swal.fire(
                    'Bạn đã xóa thành công!',
                    'success',
                    )
                }

            })
        }

</script>
@endsection
