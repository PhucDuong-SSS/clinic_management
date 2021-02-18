@extends('layout/master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Roles</h3>
    </div>
    <div class="d-flex flex-row-reverse mr-3 mt-3"><a href="{{route('role.create')}}" class="btn btn-primary">Thêm Chức vụ</a></div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Display_Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $key => $role)
                <tr class="rid{{$role->id}}">
                    <td>{{$key+1}}</td>
                    <td>{{$role->role_name}}</td>
                    <td>{{$role->display_name}}</td>
                    <td><a class="btn btn-info" href="{{route('role.edit', $role->id)}}">Edit</a></td>
                    <td><a href="javascript:void(0)" class="btn btn-danger" onclick="deleteRole({{$role->id}})">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Display_Name</th>
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
