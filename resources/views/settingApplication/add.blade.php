@extends('layout/master')
@section('content')

   <!-- Main content -->
   <section class="content">
    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card card-primary" style="100%">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName">Tên bác sĩ</label>
                            <input type="text" name="name_doctor" id="inputName" placeholder="Nhập tên bác sĩ"
                                   class="form-control">
                                   @error('name_doctor')
                                   <div style="color: red">*{{ $message }}</div>
                                   @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputName">Học vị</label>
                            <input type="text" name="degree" id="inputName" placeholder="Nhập học vị"
                                   class="form-control">
                                   @error('degree')
                                   <div style="color: red">*{{ $message }}</div>
                                   @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputName">Tên phòng khám</label>
                            <input type="text" name="name_clinic" id="inputName" placeholder="Nhập tên phòng khám"
                                   class="form-control">
                                   @error('name_clinic')
                                   <div style="color: red">*{{ $message }}</div>
                                   @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputName">Số điện thoại</label>
                            <input type="number" name="phone" id="inputName" placeholder="Nhập số điện thoại"
                                   class="form-control">
                                   @error('phone')
                                   <div style="color: red">*{{ $message }}</div>
                                   @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputName">Địa chỉ</label>
                            <input type="text" name="address" id="inputName" placeholder="Nhập địa chỉ"
                                   class="form-control">
                                   @error('address')
                                   <div style="color: red">*{{ $message }}</div>
                                   @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Thêm" class="btn btn-success">
                            <a href="{{route('setting.index')}}" class="btn btn-secondary">Trở về</a>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </form>
</section>
@endsection
