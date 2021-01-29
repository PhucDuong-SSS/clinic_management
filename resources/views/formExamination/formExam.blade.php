@extends('master')
@section('content')
<section class="content">
    <div class="container-fluid">
        <form role="form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tên bệnh nhân</label>
                        <input type="text" class="form-control" placeholder="Tên bệnh nhân">
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh:</label>
                        <input type="date" class="form-control" placeholder="Ngày sinh">
                    </div>
                    <div class="form-group">
                        <label>Giới tính:</label><br>
                        <label>
                            <input type="radio" name="gender" value="1"> Nam
                        </label>
                        <label>
                            <input type="radio" name="gender" value="0">Nữ
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Người giám hộ:</label>
                        <input type="text" class="form-control" placeholder="Tên người giám hộ">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại:</label>
                        <input type="number" class="form-control" placeholder="Số điện thoại">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ:</label>
                        <input type="text" class="form-control" placeholder="Địa chỉ">
                    </div>

                </div>
                <div class="card card-default">
                    <div class="card-header">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Triệu Chứng</label>
                                    <select class="duallistbox" multiple="multiple">
                                        <option>Alabama</option>
                                        <option>Alaska</option>
                                        <option>California</option>
                                        <option>Delaware</option>
                                        <option>Tennessee</option>
                                        <option>Texas</option>
                                        <option>Washington</option>
                                    </select>
                                    <label>Triệu chứng khác:</label>
                                    <textarea name="" id="" cols="100%" rows="2">
                                    </textarea>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
                <br>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Toa thuốc:</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 200px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Tên Thuốc</th>
                                        <th>Liều uống</th>
                                        <th>Ngày</th>
                                        <th>Tổng số viên</th>
                                        <th>Tổng giá trị</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Pennicilin</td>
                                        <td>Sáng 1, Chiều 1, Tối 1 sau khi ăn</td>
                                        <td>5</td>
                                        <td>15</td>
                                        <td>70.000</td>
                                    </tr>
                                    <tr>
                                        <td>Paracetamon</td>
                                        <td>Sáng 1, Chiều 1, Tối 1 sau khi ăn</td>
                                        <td>3</td>
                                        <td>9</td>
                                        <td>60000</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thuốc:</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Thuốc</th>
                                        <th>
                                            <select name="" id=""></select>
                                        </th>
                                        <th>Phát thuốc cho: </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sáng</td>
                                        <td>1 viên/gói/ml/ống</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>Trưa</td>
                                        <td>1 viên/gói/ml/ống</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>Chiều</td>
                                        <td>1 viên/gói/ml/ống</td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>Tối</td>
                                        <td>1 viên/gói/ml/ống</td>
                                        <td><input type="text"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-12">
                    <label>Ghi chú:</label>
                    <textarea name="" id="" cols="100%" rows="2">
                                    </textarea>
                </div>


                <div class="col-12">
                    <label for="">Tiền khám:</label>
                    <input type="text">
                </div>

                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed text-nowrap">

                                <tr>
                                    <td>Ngày khám bệnh:</td>
                                    <td>
                                        20/12/2020
                                    </td>

                                </tr>


                                <tr>
                                    <td>Ngày tái khám lần 1</td>
                                    <td>1/1/2021</td>

                                </tr>
                                <tr>
                                    <td>Ngày tái khám lần 2</td>
                                    <td>5/3/2021</td>
                                </tr>


                                <button class="btn btn-primary">Thêm ngày tái khám:</button>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Xuât phiếu điều trị</button>
            </div>
        </form>


    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@endsection
