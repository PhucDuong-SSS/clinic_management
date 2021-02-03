@extends('layout/master')
@section('content')
<section class="content">
    <div class="container-fluid">
        <form role="form" action="{{route('user.changeprofile',$user->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label >Họ và Tên:</label>
                        <input type="text" value="{{$user->full_name}}" class="form-control" name="full_name"  placeholder="Họ và tên">
                         @error('full_name')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email:</label>
                        <input type="email" value="{{$user->email}}" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
                        @error('email')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >UserName:</label>
                        <input type="text" value="{{$user->user_name}}" class="form-control" name="user_name" placeholder="UserName">
                        @error('user_name')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">

                   <div class="form-group">
                        <label >Address:</label>
                        <input type="text" value="{{$user->address}}" class="form-control" name="address" placeholder="Địa chỉ">
                        @error('address')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >Phone</label>
                        <input type="number" value="{{$user->phone}}" name="phone" class="form-control" placeholder="Số điện thoại">
                        @error('phone')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >Ảnh đại diện:</label>
                        <img src="{{asset('/storage/'.substr($user->image,7))}}" alt="" style="width: 100px; height:100px" >
                        <input type="file" name="image" class="form-control-file">
                        @error('image')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>


                </div>



            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>


    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

@endsection
