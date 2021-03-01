@extends('layout/master')
@section('content')
<section class="content">
    <div class="container-fluid">
        <form role="form" action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label >Tên chức vụ:</label>
                        <input type="text" class="form-control" value="" name="role_name"  placeholder="Tên chức vụ">
                         @error('role_name')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >Tên hiển Thị:</label>
                        <input type="text" class="form-control" value="" name="display_name"  placeholder="Tên hiển thị">
                         @error('display_name')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>


                </div>
                <div class="col-12">
                    <label >Chọn quyền:</label>
                   <div class="form-group d-flex" style="flex-wrap: wrap;">
                        @foreach($permissions as $permission)
                     <div class="form-check col-md-3">
                        <input type="checkbox" class="form-check-input" value="{{$permission->id}}" name="permission[]">
                        <label class="form-check-label">{{$permission->display_name}}</label>
                    </div>
                    @endforeach
                    </div>

                </div>



            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Thêm Chức vụ</button>
            </div>
        </form>


    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

@endsection
