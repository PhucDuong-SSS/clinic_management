@extends('layout/master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách thành viên</h3>
    </div>
    <div class="d-flex flex-row-reverse mr-3 mt-3"><a href="{{route('user.create')}}" class="btn btn-primary">Tạo thành viên</a></div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>images</th>
                    <th>UserName</th>
                    <th>Roles</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $key => $user)
                <?php ($roleOfUser = DB::table('users')
                                        ->join('user_role', 'users.id', '=', 'user_role.id_user')
                                        ->join('roles', 'user_role.role_key', '=', 'roles.id')
                                        ->where('users.id', $user->id)->select('roles.*')->pluck('id')) ?>
                <tr class="uid{{$user->id}}">
                    <td>{{$user->full_name}}</td>
                    <td><img src="{{asset('/storage/'.substr($user->image,7))}}" alt="" style="width: 100px; height:100px" ></td>
                    <td>{{$user->user_name}}</td>
                    <td>
                        @foreach ($roles as $role)
                            @if ($roleOfUser->contains($role->id))
                                 {{ $role->display_name }}
                            @endif
                        @endforeach
                    </td>
                    <td>{{$user->address}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->email}}</td>
                    <td><a class="btn btn-info" href="{{route('user.edit', $user->id)}}">Edit</a></td>
                    <td><a href="javascript:void(0)" class="btn btn-danger" onclick="deleteUser({{$user->id}})">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>images</th>
                    <th>UserName</th>
                    <th>Roles</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
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
    function deleteUser(id){
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
                url:'users/destroy/'+id,
                type:'DELETE',
                data:{
                    _token: $("input[name=_token]").val()
                },
                success:function (response){
                    console.log(response);
                    $("#uid"+id).remove();
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



