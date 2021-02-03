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
            <h6>Ngày khám bệnh: {{$prescription->exam_date}}</h6>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <h6>Họ tên bênh nhân: {{$prescription->patient->full_name}}</h6>
        </div>
        <div class="col-md-6">
            <h6>Họ tên người giám hộ: {{$prescription->patient->guardian_name}}</h6>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <h6>Ngày sinh: {{$prescription->patient->dob}}</h6>
        </div>
        <div class="col-md-6">
            <h6>Số điện thoại: {{$prescription->patient->phone_number}}</h6>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-6">
            <h6>Giới tính: {{$prescription->patient->phone_number =='1'?'Nam':'Nữ'}}</h6>
        </div>
        <div class="col-md-6">
            <h6>Địa chỉ: {{$prescription->patient->address}}</h6>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-12">
            <h6>Triệu chứng: {{$prescription->sympton}}</h6>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h6>Chuẩn đoán: {{$prescription->prognosis}}</h6>
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
                    <h6>Tên thuốc: {{$medicineNameArr[$index]->medicine_name}}</h6>
                </div>
                <div class="col-md-4">
                    <h6>SL:{{$prescription_medicine->amount}}</h6>
                </div>
                <div class="col-md-4">
                    <h6>{{$prescription_medicine->number_of_day}} ngày</h6>
                </div>
                <div class="col-md-12">
                    <p>
                        {{$prescription_medicine->morning !== null?"Sáng: ".$prescription_medicine->morning." viên ":"" }}{{($prescription_medicine->note_morning !== null)?$prescription_medicine->note_morning.", ":""}}
                        <br>
                        {{($prescription_medicine->midday !== null)?"Trưa: ".$prescription_medicine->midday." viên ":""}}{{($prescription_medicine->note_midday !== null)?$prescription_medicine->note_midday.", ":""}}
                        <br>
                        {{($prescription_medicine->afternoon !== null)?"Chiều: ".$prescription_medicine->afternoon." viên ":""}}{{($prescription_medicine->note_afternoon !== null)?$prescription_medicine->note_afternoon.", ":""}}
                        <br>
                        {{($prescription_medicine->evening !== null)?"Tối: ".$prescription_medicine->evening." viên ":""}}{{($prescription_medicine->note_evening !== null)?$prescription_medicine->note_evening:""}}

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
                <h6 class="name-text">Nguyễn Văn A</h6>
            </div>

        </div>
    </div>
    <br>
    <br>
    <div class="col-md-12">
        <div class="f" >
            <h6>Ghi chú</h6>
            <p>{{$prescription->note}}</p>
        </div>
    </div>

    <br><br>


</div>
<div class="button">
    <button class="btnprn btn pre-btn btn-primary">Print Preview</button>
    <button onclick="goBack()" class="btn btn-primary">Go Back</button>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.4.0/jQuery.print.min.js" integrity="sha512-7xDKQAHPsn2ckv5+3ZdDGQTxYSLl6rZYcU/oAV9VfW73ibD4Kbdf+IvG0Z+s7+1zCQyJwtJlJga/dDiuFAIwug==" crossorigin="anonymous"></script>
<script type="text/javascript">

        function goBack() {
        window.history.back();
    }
    $(document).ready(function(){


        $('.btnprn').click(function (e) {
            $('#print_this').print();
        })

    });
</script>

</body>

</html>
