@extends('layout/master')
@section('content')
<section class="content">
    <div class="container-fluid">
        <form role="form" action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label >Tên:</label>
                        <input type="text" class="form-control" value="{{$role->role_name}}" name="role_name"  placeholder="Họ và tên">
                         @error('role_name')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >Tên Hiển Thị:</label>
                        <input type="text" class="form-control" value="{{$role->display_name}}" name="display_name"  placeholder="Họ và tên">
                         @error('display_name')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>


                </div>
                <div class="col-md-6">

                   <div class="form-group">
                        <label >Chọn quyền:</label>
                        @foreach($permissions as $permission)
                     <div class="form-check">
                        <input type="checkbox"
                        {{$permissionOfRole->contains($permission->id) ? "checked" : ""}}
                        class="form-check-input" value="{{$permission->id}}" name="permission[]">
                        <label class="form-check-label">{{$permission->display_name}}</label>
                    </div>
                    @endforeach
                    </div>

                </div>



            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Chỉnh sửa Chức vụ</button>
            </div>
        </form>


    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

@endsection
