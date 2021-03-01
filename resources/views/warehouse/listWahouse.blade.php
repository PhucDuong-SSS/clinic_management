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
            $checkEditLots = DB::table('permissions')->where('permission_name', 'edit_lot')->value('id');
            $checkDeleteLots = DB::table('permissions')->where('permission_name', 'delete_lot')->value('id');
            $checkCreateLots = DB::table('permissions')->where('permission_name', 'add_lot')->value('id');
?>
<?php
$unit;
$total_medicine=0;
$total_money=0;
if($data!='-1' && $data!='-2'){
    foreach ($lots as $key => $lot) {
        $total_medicine+=$lot->medicine_amount;
        $total_money+=$lot->total_price;
    }
    foreach ($medicines as $key => $medicine) {
        if($data == $medicine->id)
        $unit=$medicine->unit->unit_name;
    }
}
if($data=='-2'){
    foreach ($lots as $key => $lot) {
        $total_money+=$lot->total_price;
    }
}
?>
@extends('layout/master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kho Thuốc</h3>
    </div>
   <div style="display: flex;justify-content: space-between">
        <div class="pt-3 ml-3" >

            <form action="{{route('lots.index')}}" method="get">
                    <select class="pl-3 " id="myselect" name="myselect" style="background:#007bff; color: white;border: none; border-radius: 3px; height: 30px">
                    <option value="" disabled selected>--chọn--</option>
                    <option value="/admin/lotsList">Tất cả</option>
                    @foreach($medicines as $key => $medicine)
                        <option value="/admin/lotsList/{{$medicine->id}}"
                            {{($data == $medicine->id) ? "selected" : ""}}
                        >{{$medicine->medicine_name}}</option>
                    @endforeach

                    </select>
            </form>

        </div>
        @if($permissionOfRole->contains($checkCreateLots))
        <div class="d-flex flex-row-reverse mr-3 mt-3"><a href="{{route('lots.create')}}" class="btn btn-primary">Nhập kho</a></div>
        @endif
    </div>

    <form role="form" action="{{route('lots.search')}}" method="post" >
                @csrf
    <div class="d-flex">
        <div class="m-3">
            <label for="name" >Từ:</label>
            <input type="date" value="{{old('dateFrom')}}"  id="dateFrom" name="dateFrom">
        </div>
        <div class="m-3">
            <label for="name" >Đến:</label>
            <input type="date" value="{{old('dateTo')}}"  id="dateTo" name="dateTo">
        </div>
        <div class="m-3">
          <button type="submit" class="btn btn-primary">Tìm</button>
        </div>
    </div>
    </form>
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
                    @if($permissionOfRole->contains($checkEditLots))
                    <th>Edit</th>
                    @endif
                    @if($permissionOfRole->contains($checkDeleteLots))
                    <th>Delete</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($lots as $key => $lot)
                <tr class="mid{{$lot->id}}">
                    <td>{{$lot->created_at}}</td>
                    <td>{{$lot->code}}</td>
                    <td>{{$lot->medicines->medicine_name}}</td>
                    <td>{{ $lot->medicine_amount }}</td>
                    <td>{{number_format($lot->unit_price, 0, '', ',')}}</td>
                    <td>{{ $lot->expired_date }}</td>
                    <td>{{ $lot->receipt_date }}</td>
                    <td>{{number_format($lot->total_price, 0, '', ',')}}</td>
                    @if($permissionOfRole->contains($checkEditLots))
                    <td><a class="btn btn-info" href="{{route('lots.edit', $lot->id)}}">Edit</a></td>
                    @endif
                    @if($permissionOfRole->contains($checkDeleteLots))
                    <td><a href="javascript:void(0)" class="btn btn-danger" onclick="deleteLots({{$lot->id}})">Delete</a></td>
                    @endif
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
                    @if($permissionOfRole->contains($checkEditLots))
                    <th>Edit</th>
                    @endif
                    @if($permissionOfRole->contains($checkDeleteLots))
                    <th>Delete</th>
                    @endif
                </tr>
            </tfoot>
        </table>
        <div class="mt-3 d-flex justify-content-between" style="font-size: 20px">
            @if($data!= '-1' && $data!= '-2')
            <div class="ml-3"><strong class="pr-3">Tông số thuốc nhập:</strong>{{$total_medicine}} {{$unit}}</div>
            <div class="mr-3" ><strong class="pr-3">Tông tiền:</strong>{{number_format($total_money, 0, '', ',')}}</div>
            @endif
        </div>
        <div class="mt-3 d-flex justify-content-end" style="font-size: 20px">
            @if($data == '-2')
            <div class="mr-3" ><strong class="pr-3">Tông tiền:</strong>{{number_format($total_money, 0, '', ',')}}</div>
            @endif
        </div>
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
        // initEventEditButtons();
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
<script>
  document.getElementById("myselect").onchange = function (){
      choosenMed();
  };
  function choosenMed(){
      var data = document.getElementById("myselect");
      window.location.href = data.value;
  }


</script>
@endsection
