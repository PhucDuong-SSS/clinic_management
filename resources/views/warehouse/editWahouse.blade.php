@extends('layout/master')
@section('content')
<section class="content">
    <div class="container-fluid">
        <form role="form" action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="col-sm-6">Mã đơn hàng:</label>
                            <input type="text" value="{{$lot->code}}" class="form-control" id="code" name="code">
                        @error('code')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6">Tên thuốc:</label>
                            <select id="medicine" name="medicine">
                                <option disabled selected multiple="">--Chọn--</option>
                                @foreach($medicines as $medicine)
                                    <option value="{{$medicine->id}}"
                                        {{($medicine->medicine_name == $lot->medicines->medicine_name) ? "selected":""}} >{{$medicine->medicine_name}}</option>
                                @endforeach
                            </select>
                         @error('medicine')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6">Số lượng:</label>
                        <input type="number" value="{{$lot->medicine_amount}}" class="form-control" id="medicine_amount" name="medicine_amount">
                        @error('medicine_amount')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="name" class="col-sm-6">Ngày sản xuất:</label>
                        <input type="date" value="{{$lot->expired_date}}" class="form-control" id="expired_date" name="expired_date">
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6">Ngày hết hạn:</label>
                        <input type="date" value="{{$lot->receipt_date}}" class="form-control" id="receipt_date" name="receipt_date">
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6">Tông giá:</label>
                        <input type="number" value="{{$lot->total_price}}" class="form-control" id="total_price" name="total_price">
                        @error('total_price')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>

                </div>



            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Sửa</button>
            </div>
        </form>


    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

@endsection
