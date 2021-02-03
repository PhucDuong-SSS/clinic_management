@extends('layout/master')
@section('content')
<section class="content">
    <div class="container-fluid">
        <form role="form" action="{{route('prescription.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tên bệnh nhân</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Tên bệnh nhân">
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh:</label>
                        <input name="dob" type="date" class="form-control" placeholder="Ngày sinh">
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
                        <input name="guardian_name" type="text" class="form-control" placeholder="Tên người giám hộ">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại:</label>
                        <input name="phone_number" type="number" class="form-control" placeholder="Số điện thoại">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ:</label>
                        <input name="address" type="text" class="form-control" placeholder="Địa chỉ">
                    </div>

                </div>
                <div class="card card-default col-12">
                    <!-- /.card-header -->

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Triệu Chứng</label>
                                    <div id="container" class="row">
                                        @foreach($symptons as $sympton)
                                        <div class="col-sm-3">
                                            <!-- checkbox -->
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input name="sympton_name[]" value="{{$sympton->sympton_name}}" class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">{{$sympton->sympton_name}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                                            Thêm triệu chứng
                                        </button>
                                    <!-- /.card -->
                                </div>

                                </div>

                            </div>

                        </div>

                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Chuẩn đoán</label>
                        <textarea name="prognosis" class="form-control" rows="3" placeholder="Nhập chuẩn đoán"></textarea>
                    </div>
                </div>

            </div>
                <br>
                <div class="row">
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
                                        <th>Hành động </th>
                                    </tr>
                                </thead>
                                <tbody id="data_prescription">
                                @if(isset($newPrescriptionMedicine->items))
                                @foreach($newPrescriptionMedicine->items as $item)
                                    <tr>
                                        <td>{{$item['medicine']->medicine_name}}</td>
                                        <td>{{$item['morning']}},{{$item['note_morning']}},{{$item['midday']}},{{$item['note_midday']}},{{$item['afternoon']}},{{$item['note_afternoon']}},{{$item['evening']}},{{$item['note_evening']}}</td>
                                        <td>{{$item['number_of_day']}}</td>
                                        <td>{{$item['amount']}}</td>
                                        <td>{{$item['totalPrice']}}</td>
                                        <td><button id="delete" type="button" class="btn btn-danger delete" data-id="{{$item['medicine']->id}}">Xóa</button>
                                        </td>
                                    </tr>
                                @endforeach
                                    <tr>
                                        <td colspan="5">Tổng tiền : {{$newPrescriptionMedicine->totalPrice}}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
                                Thêm thuốc
                            </button>

                        </div>

                        <!-- /.card-body -->
                    </div>
                </div>
                </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea name="note" class="form-control" rows="3" placeholder="Nhập ghi chú"></textarea>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tiền khám</label>
                        <input type="number" name="exam_price" class="form-control" placeholder="Nhập tiền khám">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ngày khám</label>
                        <input type="date" name="exam_date" class="form-control" placeholder="Nhập ngày khám">
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed text-nowrap" id="preexam_content">


                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-preexam">
                                    Thêm ngày tái khám
                                </button>
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
    <div class="modal fade" id="modal-preexam">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm ngày tái khám</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="userForm" class="form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-6">Tái khám lần</label>
                            <div class="col-sm-12">
                                <input type="number" id="time" name="time" class="form-control" placeholder="Nhập lần tái khám">
                                <span id="titleError" class="alert-message"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-6">Ngày tái khám</label>
                            <div class="col-sm-12">
                                <input type="date" id="preexam" name="preexam" class="form-control" placeholder="Ngày tái khám">
                                <span id="titleError" class="alert-message"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button id="add_preexam" type="button" class="btn btn-primary">Thêm</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm triệu chứng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="userForm" class="form-horizontal">
                        <input type="hidden" name="post_id" id="post_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-6">Triệu chứng</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="sympton_name" name="sympton_name" placeholder="Nhập triệu chứng">
                                <span id="titleError" class="alert-message"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button id="add_sympton" type="button" class="btn btn-primary">Thêm</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm thuốc</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="productForm" name="productForm" class="form-horizontal" method="POST" >
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-sm-12 control-label">Tên thuốc</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="medicine_id" id="medicine_id" >
                                    @foreach($medicines as $medicine)
                                    <option value="{{$medicine->id}}">{{$medicine->medicine_name}}</option>

                                    @endforeach
                                </select>
                                <input type="hidden" name="unit_sell_price" id="unit_sell_price" value="10000">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Lượng thuốc buối sáng</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="morning" name="morning" placeholder="Nhập số lượng thuốc cho buổi sáng"  maxlength="50">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Ghi chú thuốc buối sáng </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="note_morning" name="note_morning" placeholder="Ghi chú cho buổi sáng"  maxlength="255">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Lượng thuốc buối trưa</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="midday" name="midday" placeholder="Nhập số lượng thuốc cho buổi sáng"  maxlength="50">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Ghi chú thuốc buối trưa </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="note_midday" name="note_midday" placeholder="Ghi chú cho buổi sáng"  maxlength="255">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Lượng thuốc buối chiều</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="afternoon" name="afternoon" placeholder="Nhập số lượng thuốc cho buổi chiều"  maxlength="50">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Ghi chú thuốc buối chiều </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="note_afternoon" name="note_afternoon" placeholder="Ghi chú thuốc cho buổi chiều"  maxlength="255">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Lượng thuốc buối tối</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="evening" name="evening" placeholder="Nhập số lượng thuốc cho buổi tối"  maxlength="50">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Ghi chú thuốc buối tối </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="note_evening" name="note_evening" placeholder="Ghi chú thuốc cho buổi tối"  maxlength="255">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Số lượng ngày dùng </label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="number_of_day" name="number_of_day" placeholder="Thời gian dùng cho thuốc"  maxlength="255">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Nhập số tiền</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="sell_price" name="sell_price" placeholder="Nhâp sô tiền"  maxlength="255">
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="add_prescription" type="button" class="btn btn-primary">Thêm thuốc</button>
                        </div>


                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

</section>




@endsection
@section('script')
    <script>

        $(document).ready(function() {
            $('#add_sympton').click(function(e) {
              const sympton_name =  $('#sympton_name').val()
                const content = `<div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input name="sympton[]" value="${sympton_name}" class="form-check-input" type="checkbox">
                                                    <label class="form-check-label">${sympton_name}</label>
                                                </div>
                                            </div>
                                        </div>
                `
                $('#container')
                    .append(content);

                if (sympton_name) {
                    let _url     = `/admin/sympton/add-sympton`;

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: _url,
                        type:"POST",
                        data : {
                            sympton_name:sympton_name,
                        },
                        dataType:"json",
                        success:function(data) {
                            $('#sympton_name').val('');
                            $('#modal-default').modal('hide');
                        },
                    });
                }else{
                    alert('danger');
                }

            })

            $('#add_preexam').click(function(e) {
                const datePreExam =  $('#preexam').val();
                const timePreExam =  $('#time').val();

                let content = `<tr>
                                    <td>Ngày tái khám lần ${timePreExam}</td>
                                    <td>${datePreExam}</td>
                                </tr>
                `
                $('#preexam_content')
                    .append(content);


            })

            $('#add_prescription').click(function(e) {

                const medicine_id =  $('#medicine_id').val();
                const morning =  $('#morning').val();
                const midday =  $('#midday').val();
                const afternoon =  $('#afternoon').val();
                const evening =  $('#evening').val();
                const note_morning =  $('#note_morning').val();
                const note_midday =  $('#note_midday').val();
                const note_afternoon =  $('#note_afternoon').val();
                const note_evening =  $('#note_evening').val();
                const number_of_day =  $('#number_of_day').val();
                const sell_price =  $('#sell_price').val();
                const unit_sell_price =  $('#unit_sell_price').val();
                let _url     = `/admin/prescription-medicine/add-prescription-medicine`;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: _url,
                        type:"POST",
                        data : {
                            medicine_id:medicine_id,
                            morning:morning,
                            midday:midday,
                            afternoon:afternoon,
                            evening:evening,
                            note_morning:note_morning,
                            note_midday:note_midday,
                            note_afternoon:note_afternoon,
                            note_evening:note_evening,
                            number_of_day:number_of_day,
                            sell_price:sell_price,
                            unit_sell_price:unit_sell_price,
                        },
                        dataType:"json",
                        success:function(data) {
                            console.log(data.PrescriptionMedicine);
                             $('#data_prescription').html(data.PrescriptionMedicine);
                             $('#modal-lg').modal('hide');
                            $('#morning').val('');
                            $('#midday').val('');
                            $('#evening').val('');
                            $('#note_morning').val('');
                            $('#note_midday').val('');
                            $('#note_afternoon').val('');
                            $('#note_evening').val('');

                        },
                    });


            })

            $('.delete').click(function(e) {

                const id =   $(this).data("id");
                confirm("Bạn có muốn xóa!");

                let _url     = `/admin/prescription-medicine/delete-prescription-medicine/${id}`;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: _url,
                    type:"delete",

                    dataType:"json",
                    success:function(data) {
                        console.log(data);
                        $('#data_prescription').html(data.PrescriptionMedicine);

                    },
                });


            })



        });
        //Khi ajax không load lai trang
        $(document).ajaxStop(function(){



            $('.delete').click(function(e) {
                const id =   $(this).data("id");
                confirm("Bạn có muốn xóa!");

                let _url     = `/admin/prescription-medicine/delete-prescription-medicine/${id}`;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: _url,
                    type:"DELETE",

                    dataType:"json",
                    success:function(data) {
                        console.log(data);
                        $('#data_prescription').html(data.PrescriptionMedicine);

                    },
                });


            })


        });

    </script>
@endsection
