@extends('layout/master')
@section('content')
<section class="content">
    <div class="container-fluid">
        <form role="form" action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label >Họ và Tên:</label>
                        <input type="text" class="form-control" value="{{$user->full_name}}" name="full_name"  placeholder="Họ và tên">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email:</label>
                        <input type="email" class="form-control" value="{{$user->email}}" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label >UserName:</label>
                        <input type="text" class="form-control" value="{{$user->user_name}}" name="user_name" placeholder="UserName">
                    </div>
                    <div class="form-group">
                        <label >Chọn quyền:</label>
                        @foreach($permissions as $permission)
                     <div class="form-check">
                        <input type="checkbox" class="form-check-input" value="{{$permission->id}}"
                        {{$getAllPermissionUser->contains($permission->id) ? "checked" : ""}}
                        name="permission[]">
                        <label class="form-check-label">{{$permission->permission_name2}}</label>
                    </div>
                    @endforeach
                    </div>

                </div>
                <div class="col-md-6">

                   <div class="form-group">
                        <label >Address:</label>
                        <input type="text" class="form-control" value="{{$user->address}}" name="address" placeholder="Địa chỉ">
                    </div>
                    <div class="form-group">
                        <label >Phone</label>
                        <input type="number" name="phone" value="{{$user->phone}}" class="form-control" placeholder="Số điện thoại">
                    </div>
                    <div class="form-group">
                        <label >Ảnh đại diện:</label>
                        <img src="{{asset('/storage/'.substr($user->image,7))}}" alt="" style="width: 100px; height:100px" >
                        <input type="file" name="image" class="form-control-file">
                    </div>


                </div>



            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Chỉnh sửa thành viên</button>
            </div>
        </form>


    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

@endsection
