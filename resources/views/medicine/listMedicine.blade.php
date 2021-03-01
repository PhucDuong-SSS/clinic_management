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
            $checkEditMed = DB::table('permissions')->where('permission_name', 'edit_med')->value('id');
            $checkDeleteMed = DB::table('permissions')->where('permission_name', 'delete_med')->value('id');
            $checkCreateMed = DB::table('permissions')->where('permission_name', 'add_med')->value('id');
?>

@extends('layout/master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách Thuốc</h3>
    </div>
    <div style="display: flex;justify-content: space-between">
    <div class="pt-3 ml-3" >

           <form action="{{route('med.index')}}" method="get">
                <select class="pl-3 " id="myselect" name="myselect" style="background:#007bff; color: white;border: none; border-radius: 3px; height: 30px">
                <option value="/admin/medicine" selected>Tất cả</option>
                @foreach($med_categories as $key => $medicine)
                    <option value="/admin/medicine/{{$medicine->id}}"
                        {{($category == $medicine->id) ? "selected" : ""}}
                    >{{$medicine->med_category_name}}</option>
                @endforeach

                </select>
           </form>

    </div>
      @if($permissionOfRole->contains($checkCreateMed))
    <div class="d-flex flex-row-reverse mr-3 mt-3"><a href="{{route('med.create')}}" class="btn btn-primary">Thêm thuốc</a></div>
    @endif
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tên Loại thuốc</th>
                    <th>Ảnh</th>
                    <th>Tên thuốc</th>
                    <th>Số lượng</th>
                    <th>Giá bán</th>
                    <th>Đơn vị</th>
                    @if($permissionOfRole->contains($checkEditMed))
                    <th>Sửa</th>
                    @endif
                    @if($permissionOfRole->contains($checkDeleteMed))
                    <th>Xóa</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($medicines as $key => $medicine)
                <tr class="mid{{$medicine->id}}">
                    <td>{{$medicine->medCategory->med_category_name}}</td>
                    <td><img src="{{asset('/storage/'.substr($medicine->image,7))}}" alt="" style="width: 100px; height:100px" ></td>
                    <td>{{ $medicine->medicine_name }}</td>
                    <td>{{ $medicine->medicine_amount }}</td>
                    <td>{{number_format($medicine->sell_price, 0, '', ',')}}</td>
                    <td>{{ $medicine->unit->unit_name }}</td>
                    @if($permissionOfRole->contains($checkEditMed))
                    <td><a class="btn btn-info" href="{{route('med.edit', $medicine->id)}}">Sửa</a></td>
                    @endif
                    @if($permissionOfRole->contains($checkDeleteMed))
                    <td><a href="javascript:void(0)" class="btn btn-danger" onclick="deleteMed({{$medicine->id}})">Xóa</a></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
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
        // initEventEditButtons();
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
<script>
  document.getElementById("myselect").onchange = function (){
      choosenCategory();
  };
  function choosenCategory(){
      var category = document.getElementById("myselect");
      window.location.href = category.value;
  }


</script>
@endsection
