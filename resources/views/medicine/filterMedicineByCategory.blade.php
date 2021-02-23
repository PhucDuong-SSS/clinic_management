@extends('layout/master')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách Thuốc</h3>
        </div>
        <div style="display: flex;justify-content: space-between">
            <div class="pt-3 ml-3" >
                <form method="get" action="" >
                    @csrf
                    <select class="pl-3 " id="category" style="background:#007bff; color: white;border: none; border-radius: 3px; height: 30px">
                        @foreach($med_categories as $key => $medicine)
                            <option value="{{route('med.category', $medicine->id)}}"
                                    selected="selected"
                            >{{$medicine->med_category_name}}</option>

                        @endforeach
                    </select>
                </form>
            </div>

            <div class="d-flex flex-row-reverse mr-3 mt-3"><a href="{{route('med.create')}}" class="btn btn-primary">Thêm thuốc</a></div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Tên Loại thuốc</th>
                    <th>images</th>
                    <th>Tên thuốc</th>
                    <th>Số lượng</th>
                    <th>Giá bán</th>
                    <th>Đơn vị</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($medicines as $key => $medicine)
                    <tr class="mid{{$medicine->id}}">
                        <td>{{$medicine->medCategory->med_category_name}}</td>
                        <td><img src="{{asset('/storage/'.substr($medicine->image,7))}}" alt="" style="width: 100px; height:100px" ></td>
                        <td>{{ $medicine->medicine_name }}</td>
                        <td>{{ $medicine->medicine_amount }}</td>
                        <td>{{ $medicine->sell_price }}</td>
                        <td>{{ $medicine->unit->unit_name }}</td>
                        <td><a class="btn btn-info" href="{{route('med.edit', $medicine->id)}}">Edit</a></td>
                        <td><a href="javascript:void(0)" class="btn btn-danger" onclick="deleteMed({{$medicine->id}})">Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Tên Loại thuốc</th>
                    <th>images</th>
                    <th>Tên thuốc</th>
                    <th>Số lượng</th>
                    <th>Giá bán</th>
                    <th>Đơn vị</th>
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
        function deleteMed(id){
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
                        url:'med/destroy/'+id,
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
