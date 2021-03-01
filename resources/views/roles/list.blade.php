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
            $checkEditRole = DB::table('permissions')->where('permission_name', 'edit_role')->value('id');
            $checkDeleteRole = DB::table('permissions')->where('permission_name', 'delete_role')->value('id');
            $checkCreateRole = DB::table('permissions')->where('permission_name', 'add_role')->value('id');
?>

@extends('layout/master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Roles</h3>
    </div>
    @if($permissionOfRole->contains($checkCreateRole))
    <div class="d-flex flex-row-reverse mr-3 mt-3"><a href="{{route('role.create')}}" class="btn btn-primary">Thêm Chức vụ</a></div>
     @endif
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Display_Name</th>
                    @if($permissionOfRole->contains($checkEditRole))
                    <th>Edit</th>
                    @endif
                    @if($permissionOfRole->contains($checkDeleteRole))
                    <th>Delete</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $key => $role)
                <tr class="rid{{$role->id}}">
                    <td>{{$key+1}}</td>
                    <td>{{$role->role_name}}</td>
                    <td>{{$role->display_name}}</td>
                    @if($permissionOfRole->contains($checkEditRole))
                    <td><a class="btn btn-info" href="{{route('role.edit', $role->id)}}">Edit</a></td>
                    @endif
                    @if($permissionOfRole->contains($checkDeleteRole))
                    <td><a href="javascript:void(0)" class="btn btn-danger" onclick="deleteRole({{$role->id}})">Delete</a></td>
                     @endif
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Display_Name</th>
                    @if($permissionOfRole->contains($checkEditRole))
                    <th>Edit</th>
                    @endif
                    @if($permissionOfRole->contains($checkDeleteRole))
                    <th>Delete</th>
                    @endif
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
        // initEventEditButtons();
    });
    function deleteRole(id){
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
                url:'role/destroy/'+id,
                type:'DELETE',
                data:{
                    _token: $("input[name=_token]").val()
                },
                success:function (response){
                    console.log(response);
                    $("#rid"+id).remove();
                    location.reload();
                    Swal.fire(
                    'Bạn đã xóa thành công!',
                    'success',
                    )
                },
                error: function (response) {
                    console.log('Error', response);
                        Swal.fire(
                        'Bạn không thể xóa!',
                    )
                }
            })
                }

            })
        }

</script>
@endsection
