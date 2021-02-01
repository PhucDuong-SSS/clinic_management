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
                            <input type="text" name="name_doctor" id="inputName" value="{{$settingApps->name_doctor}}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Học vị</label>
                            <input type="text" name="degree" id="inputName" value="{{$settingApps->degree}}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Tên phòng khám</label>
                            <input type="text" name="name_clinic" id="inputName" value="{{$settingApps->name_clinic}}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Số điện thoại</label>
                            <input type="number" name="phone" id="inputName" value="{{$settingApps->phone}}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputName">Địa chỉ</label>
                            <input type="text" name="address" id="inputName" value="{{$settingApps->address}}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Sửa" class="btn btn-success">
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
