@extends('layout/master')
@section('content')
<section class="content">
    <div class="container-fluid">
        <form role="form"  @if(isset($patient)) action="{{route('prescription.storeExam',$id_prescription)}}"@else action="{{route('prescription.store')}}"   @endif method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tên bệnh nhân</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Tên bệnh nhân" @if(isset($patient)) value="{{$patient->full_name}}" @endif>
                        @error('full_name')
                        <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh:</label>
                        <input name="dob" type="date" class="form-control" placeholder="Ngày sinh" @if(isset($patient)) value="{{$patient->dob}}" @endif>
                        @error('dob')
                        <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Giới tính:</label><br>
                        @if(isset($patient))
                            @if($patient->gender == 1)
                        <label>
                            <input type="radio" checked name="gender" value="1"> Nam
                        </label>
                        <label>
                            <input type="radio" name="gender" value="0">Nữ
                        </label>
                            @else
                                <label>
                                    <input type="radio" checked name="gender" value="1"> Nam
                                </label>
                                <label>
                                    <input type="radio" checked name="gender" value="0">Nữ
                                </label>
                            @endif
                        @else
                            <label>
                                <input type="radio" checked name="gender" value="1"> Nam
                            </label>
                            <label>
                                <input type="radio" name="gender" value="0">Nữ
                            </label>
                        @endif

                        @error('gender')
                        <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Người giám hộ:</label>
                        <input name="guardian_name" type="text" class="form-control" placeholder="Tên người giám hộ" @if(isset($patient)) value="{{$patient->guardian_name}}" @endif>
                        @error('guardian_name')
                        <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại:</label>
                        <input name="phone_number" type="number" class="form-control" placeholder="Số điện thoại"  @if(isset($patient)) value="{{$patient->phone_number}}" @endif >
                        @error('phone_number')
                        <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ:</label>
                        <input name="address" type="text" class="form-control" placeholder="Địa chỉ" @if(isset($patient)) value="{{$patient->address}}" @endif>
                        @error('address')
                        <div style="color: red">*{{ $message }}</div>
                        @enderror
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

                                        <button type="button" id="reset" class="btn btn-primary"  data-target="#modal-default">
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
                        @error('prognosis')
                        <div style="color: red">*{{ $message }}</div>
                        @enderror
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
                        <div class="card-body table-responsive p-0" >
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
                                        <td>{{($item['morning'])?"Sáng: ".$item['morning']." viên ":"" }}{{($item['note_morning'])?$item['note_morning']:""}} {{($item['midday'])?" Trưa: ".$item['midday']." viên ":"" }}{{($item['note_midday'])?$item['note_midday']:""}} {{($item['afternoon'])?" Chiều: ".$item['afternoon']." viên ":"" }}{{($item['note_afternoon'])?$item['note_afternoon']:""}} {{($item['evening'])?" Tối: ".$item['evening']." viên ":"" }} {{($item['note_evening'])?$item['note_evening']:""}}</td>
                                        <td>{{$item['number_of_day']}}</td>
                                        <td>{{$item['amount']}}</td>
                                        <td>{{$item['totalPrice']}}</td>
                                        <td><button id="delete" type="button" class="btn btn-danger delete" data-id="{{$item['medicine']->id}}">Xóa</button>
                                        </td>
                                    </tr>
                                @endforeach
                                    <tr>
                                        <td colspan="5">Tổng tiền : <strong>{{$newPrescriptionMedicine->totalPrice}} đ</strong>  </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <button type="button" style="margin: 25px 25px" id="reset_add_medicine" class="btn btn-primary"  data-target="#modal-lg">
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
                        <textarea name="note[]" class="form-control" rows="3" placeholder="Nhập ghi chú"></textarea>
                        @error('note')
                        <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tiền khám</label>
                        <input type="number" name="exam_price" class="form-control" placeholder="Nhập tiền khám">
                        @error('exam_price')
                        <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ngày khám</label>
                        <input type="date" name="exam_date" class="form-control" placeholder="Nhập ngày khám">
                        @error('exam_date')
                        <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed text-nowrap" id="preexam_content">
                                <tbody>
                                @if(isset($prescriptions_time))
                                    @foreach($prescriptions_time as $index=>$prescription)
                                        <tr>
                                            <td>Ngày tái khám lần: {{$index+1}}</td>
                                            <td>{{$prescription->exam_date}}</td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>

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
                <button type="submit" class="btn btn-primary">Tạo đơn thuốc</button>
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
                                <input type="number" min="1" id="time" name="time" class="form-control" placeholder="Nhập lần tái khám">
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
                                <div class="text-danger text-center symptonErr"></div>
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

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Lượng thuốc buối sáng</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="morning" name="morning" min="1" max="100" placeholder="Nhập số lượng thuốc cho buổi sáng"  maxlength="50">
                                <div class="text-danger text-left morningErr"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Ghi chú thuốc buối sáng </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="note_morning" name="note_morning" placeholder="Ghi chú cho buổi sáng"  maxlength="255">
                                <div class="text-danger text-left note_morningErr"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Lượng thuốc buối trưa</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="midday" name="midday" min="1" max="100" placeholder="Nhập số lượng thuốc cho buổi trưa"  maxlength="50">
                                <div class="text-danger text-left middayErr"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Ghi chú thuốc buối trưa </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="note_midday" name="note_midday" placeholder="Ghi chú cho buổi trưa"  maxlength="255">
                                <div class="text-danger text-left note_middayErr"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Lượng thuốc buối chiều</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="afternoon" min="1" max="100" name="afternoon" placeholder="Nhập số lượng thuốc cho buổi chiều"  maxlength="50">
                                <div class="text-danger text-left afternoonErr"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Ghi chú thuốc buối chiều </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="note_afternoon" name="note_afternoon" placeholder="Ghi chú thuốc cho buổi chiều"  maxlength="255">
                                <div class="text-danger text-left note_afternoonErr"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Lượng thuốc buối tối</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="evening" name="evening" min="1" placeholder="Nhập số lượng thuốc cho buổi tối"  maxlength="50">
                                <div class="text-danger text-left eveningErr"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Ghi chú thuốc buối tối </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="note_evening" name="note_evening" placeholder="Ghi chú thuốc cho buổi tối"  maxlength="255">
                                <div class="text-danger text-left note_eveningErr"></div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Số lượng ngày dùng </label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="number_of_day" name="number_of_day" value="1" min="1" placeholder="Thời gian dùng cho thuốc"  maxlength="255">
                                <div class="text-danger text-left number_of_dayErr"></div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Tiền tạm tính</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="calc_price" name="calc_price" value="" maxlength="255">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-12 control-label">Nhập số tiền thực tính</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" id="sell_price" name="sell_price" placeholder="Nhâp sô tiền"  maxlength="255">
                                <div class="text-danger text-left sell_priceErr"></div>

                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default"   data-dismiss="modal">Close</button>
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
            $('#reset').click(function (){
                $('#sympton_name').removeClass('is-invalid');
                $('.symptonErr').html('');
            });
            $('#reset_add_medicine').click(function (){
                const inputs = $('.form-control');
                const errors = $('.text-danger');
                $.each(inputs,function (idx,input){
                    $(input).removeClass('is-invalid');
                });
                $.each(errors,function (idx,error){
                    $(error).html('');
                });
            });
            //show form add sympton
            $('#reset').click(function (){
                $('#modal-default').modal('show');

            })
            // Ajaax add sympton then html() into form
            $('#add_sympton').click(function(e) {
              const sympton_name =  $('#sympton_name').val();

                    let _url     = `/admin/sympton/add-sympton-ajax`;

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
                            $('#container').append(data.html);
                            $('#sympton_name').val('');
                            $('#modal-default').modal('hide');
                            swal('Thành công!', data.success, "success");

                        },
                        error: function (xhr){
                            let errors = xhr.responseJSON.errors;
                            if(errors.sympton_name){
                                $('.symptonErr').html(errors.sympton_name[0]);
                                $('#sympton_name').addClass('is-invalid');
                            }

                        }
                    });


            })
            // Ajax add reexam then append form
            $('#add_preexam').on('click',function(e) {
                const datePreExam =  $('#preexam').val();
                const timePreExam =  $('#time').val();

                let content = `<tr id="${timePreExam}}">
                                    <td>Ngày tái khám lần ${timePreExam}</td>
                                      <input type="hidden" name="note[]" value="${timePreExam}">
                                    <td>${datePreExam}</td>
                                    <input type="hidden" name="note[]" value="${datePreExam}">
                                    <td><button id="delete_pre_exam" type="button" class="btn btn-danger delete_pre_exam" data-id="${timePreExam}">Xóa</button></td>
                                </tr>
                `
                $('#preexam_content')
                    .append(content);


            })

            //Hien form them thuoc
            $('#reset_add_medicine').click(function (){
                $('#modal-lg').modal('show');

            })
            //Ajax add prescription
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
                             $('#data_prescription').html(data.PrescriptionMedicine);
                            $('#modal-lg').modal('hide');
                            $('#morning').val('');
                            $('#midday').val('');
                            $('#evening').val('');
                            $('#note_morning').val('');
                            $('#note_midday').val('');
                            $('#note_afternoon').val('');
                            $('#note_evening').val('');
                            $('#sell_price').val('');
                            $('#number_of_day').val('');
                            $('#calc_price').val('');
                            swal('Thành công!', data.success, "success");

                        },

                        error: function (xhr){
                            let errors = xhr.responseJSON.errors;
                            if(errors.morning){
                                $('.morningErr').html(errors.morning[0]);
                                $('#morning').addClass('is-invalid');
                            }
                            if(errors.midday){
                                $('.middayErr').html(errors.midday[0]);
                                $('#midday').addClass('is-invalid');
                            }
                            if(errors.afternoon){
                                $('.afternoonErr').html(errors.afternoon[0]);
                                $('#afternoon').addClass('is-invalid');
                            }
                            if(errors.evening){
                                $('.eveningErr').html(errors.evening[0]);
                                $('#evening').addClass('is-invalid');
                            }
                            if(errors.note_morning){
                                $('.note_morningErr').html(errors.note_morning[0]);
                                $('#note_morning').addClass('is-invalid');
                            }
                            if(errors.note_midday){
                                $('.note_middayErr').html(errors.note_midday[0]);
                                $('#note_midday').addClass('is-invalid');
                            }
                            if(errors.note_afternoon){
                                $('.note_afternoonErr').html(errors.note_afternoon[0]);
                                $('#note_afternoon').addClass('is-invalid');
                            }
                            if(errors.note_evening){
                                $('.note_eveningErr').html(errors.note_evening[0]);
                                $('#note_evening').addClass('is-invalid');
                            }
                            if(errors.number_of_day){
                                $('.number_of_dayErr').html(errors.number_of_day[0]);
                                $('#number_of_day').addClass('is-invalid');
                            }
                            if(errors.sell_price){
                                $('.sell_priceErr').html(errors.sell_price[0]);
                                $('#sell_price').addClass('is-invalid');
                            }

                        }

                    });


            })

            $('body').on('click','.delete',function(e) {

                const id =   $(this).data("id");


                Swal.fire({
                    title: 'Xóa thuốc?',
                    text: "Bạn muốn xóa thuốc này ra khỏi bảng!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    console.log(result.value)
                    if (result.value) {
                        let _url = `/admin/prescription-medicine/delete-prescription-medicine/${id}`;

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: _url,
                            type: "delete",
                            dataType: "json",
                            success: function (data) {
                                console.log(data);
                                $('#data_prescription').html(data.PrescriptionMedicine);

                            },

                        });
                    }
                })

            })

            function changeCalcPrice() {
                let medicine_id = $('#medicine_id').val();
                let morning = $('#morning').val();
                let midday = $('#midday').val();
                let afternoon = $('#afternoon').val();
                let evening = $('#evening').val();
                let number_of_day = $('#number_of_day').val()

                let _url     = `/admin/medicine/get-sell-price`;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: _url,
                    type:"POST",
                    data:{
                        medicine_id : medicine_id,
                        morning : morning,
                        midday : midday,
                        afternoon : afternoon,
                        evening : evening,
                        number_of_day:number_of_day
                    },
                    dataType:"json",
                    success:function(data) {
                        $('#calc_price').val(data.calc_price);
                    },

                });

            }

            $('#morning').keyup(function(e) {
                changeCalcPrice();
            });

            $('#midday').keyup(function(e) {
                changeCalcPrice();
            });
            $('#afternoon').keyup(function(e) {
                changeCalcPrice();
            });
            $('#evening').keyup(function(e) {
                changeCalcPrice();
            });
            $('#number_of_day').keyup(function(e) {
                changeCalcPrice();
            });
            $('#medicine_id').change(function() {
                changeCalcPrice();
            });
            // delete row of table
            $('body').on('click', '.delete_pre_exam', function(){
                $(this).closest('tr').remove();
            });

        });


    </script>

@endsection
