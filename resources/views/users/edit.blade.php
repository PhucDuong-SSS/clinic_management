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
                        @error('full_name')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email:</label>
                        <input type="email" class="form-control" value="{{$user->email}}" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
                        @error('email')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >UserName:</label>
                        <input type="text" class="form-control" value="{{$user->user_name}}" name="user_name" placeholder="UserName">
                        @error('user_name')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >Chọn quyền:</label>
                        <select name="role_key" class="form-control" >
                            <option disabled selected >--Chọn--</option>
                            @foreach($roles as $role)
                        <option value="{{$role->id}}"
                            {{$roleOfUser->contains($role->id) ? "selected" : ""}}
                            >{{$role->display_name}}</option>
                         @endforeach
                        </select>
                    </div>

                </div>
                <div class="col-md-6">

                   <div class="form-group">
                        <label >Address:</label>
                        <input type="text" class="form-control" value="{{$user->address}}" name="address" placeholder="Địa chỉ">
                        @error('address')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >Phone</label>
                        <input type="number" name="phone" value="{{$user->phone}}" class="form-control" placeholder="Số điện thoại">
                        @error('phone')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
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
