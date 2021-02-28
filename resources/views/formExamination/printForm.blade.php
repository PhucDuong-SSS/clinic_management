<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Phiếu khám bệnh</title>
    <style>
        .heading-title{
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .name-doctor{
            display: flex;
            justify-content:flex-end;
            margin-right: 50px !important;
        }
        .name{
            display:flex ;
            margin-right: 140px;
            justify-content: center;
            flex-direction: column;
        }
        .name-text {
            display: block;
            text-align: center;
        }
        .button {
            display: flex;
            justify-content: center;
            margin-bottom: 50px;

        }
        .pre-btn{
            margin-right: 30px;
        }


    </style>
</head>
<body>
<div style="margin-left: 50px" class="container" id="print_this">

    <div class="row">
        <div class="col-md-12">
            <div class="heading">
                <div class="heading-title">
                    <h3>Phiếu khám bệnh</h3>
                </div>
            </div>
        </div>

    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <strong>Ngày khám bệnh: </strong> &ensp; {{$prescription->exam_date}}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <strong>Họ tên bênh nhân: </strong> &ensp; {{$prescription->patient->full_name}}
        </div>
        <div class="col-md-6">
            <strong>Họ tên người giám hộ: </strong> &ensp; {{$prescription->patient->guardian_name}}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6 flex-row d-flex">
                <strong>Ngày sinh:</strong> &ensp;     {{$prescription->patient->dob}}  &ensp;  ({{ $user_age }})

        </div>
        <div class="col-md-6">
            <strong>Số điện thoại:</strong> &ensp;  {{$prescription->patient->phone_number}}
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-6">
            <strong>Giới tính:</strong> &ensp; {{$prescription->patient->gender =='1'?'Nam':'Nữ'}}
        </div>
        <div class="col-md-6">
            <strong>Địa chỉ:</strong> &ensp;{{$prescription->patient->address}}
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">
            <strong>Triệu chứng:</strong> &ensp; {{$prescription->sympton}}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <strong>Chuẩn đoán:</strong> {{$prescription->prognosis}}
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2">
            <h6>Toa thuốc:</h6>
        </div>
        <div class="col-md-10">
            <div class="row">
                @foreach($prescription_medicines as $index=> $prescription_medicine)
                <div class="col-md-4">
                    <h6>{{$medicineNameArr[$index]->medicine_name}}</h6>
                </div>
                <div class="col-md-4">
                    <h6>SL:{{$prescription_medicine->amount}}</h6>
                </div>
                <div class="col-md-4">
                    <h6>{{$prescription_medicine->number_of_day}} ngày</h6>
                </div>
                <div class="col-md-12">
                    <p>
                        {{$prescription_medicine->morning != 0?"Sáng: ".$prescription_medicine->morning." viên ":"" }}{{($prescription_medicine->note_morning !== null)?$prescription_medicine->note_morning.", ":""}}

                        {{($prescription_medicine->midday != 0)?"Trưa: ".$prescription_medicine->midday." viên ":""}}{{($prescription_medicine->note_midday !== null)?$prescription_medicine->note_midday.", ":""}}

                        {{($prescription_medicine->afternoon != 0)?"Chiều: ".$prescription_medicine->afternoon." viên ":""}}{{($prescription_medicine->note_afternoon !== null)?$prescription_medicine->note_afternoon.", ":""}}

                        {{($prescription_medicine->evening != 0)?"Tối: ".$prescription_medicine->evening." viên ":""}}{{($prescription_medicine->note_evening !== null)?$prescription_medicine->note_evening:""}}
                        <br>
                    </p>

                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-12">
            <h6>Tổng chi phí: {{$totalPrice}}đ</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 name-doctor">
            <div class="name" >
                <h6 class="name-text">Người chuẩn đoán và kê đơn</h6>
                <br>
                <br>
                <br>
                <br>
                {{-- <h6 class="name-text">Nguyễn Văn A</h6> --}}
            </div>

        </div>
    </div>
    <br>
    <br>
    <div class="col-md-12">
        <div class="f" >
            <h6>Ghi chú</h6>

            <p>{!! $noteValue !!}</p>
        </div>
    </div>

    <br><br>


</div>
<div class="button">
    <button class="btnprn btn pre-btn btn-primary">Print Preview</button>
    <a href="{{ route('prescription.index') }}"><button  class="btn btn-primary">Go Back</button></a>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.4.0/jQuery.print.min.js" integrity="sha512-7xDKQAHPsn2ckv5+3ZdDGQTxYSLl6rZYcU/oAV9VfW73ibD4Kbdf+IvG0Z+s7+1zCQyJwtJlJga/dDiuFAIwug==" crossorigin="anonymous"></script>
<script type="text/javascript">

        function goBack() {
        window.history.back(-1);
    }
    $(document).ready(function(){


        $('.btnprn').click(function (e) {
            $('#print_this').print();
        })

    });
</script>

</body>

</html>
