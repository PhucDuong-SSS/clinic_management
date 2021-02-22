@extends('layout/master')
@section('content')
<section class="content">
    <div class="container-fluid">
        <form role="form" action="" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="col-sm-6">Tên loại thuốc:</label>
                            <select id="category" name="category">
                                <option disabled selected multiple="">--Chọn--</option>
                                @foreach($medCategories as $category)
                                    <option value="{{$category->id}}"
                                        {{(old('category') == $category->id) ? "selected":""}} >{{$category->med_category_name}}</option>
                                @endforeach
                            </select>
                         @error('category')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6">Tên thuốc:</label>
                            <input type="text" value="{{old('medicine_name')}}" class="form-control" id="medicine_name" name="medicine_name">
                        @error('medicine_name')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-6">Giá bán:</label>
                        <input type="number" value="{{old('sell_price')}}" class="form-control" id="sell_price" name="sell_price">
                        @error('sell_price')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="name" class="col-sm-6">Đơn vị:</label>
                        <select id="unit" name="unit">
                            <option disabled selected multiple="">--Chọn--</option>
                            @foreach($units as $unit)
                                <option value="{{$unit->id}}"
                              {{(old('unit') == $unit->id) ? "selected":""}}
                                    >{{$unit->unit_name}}</option>
                            @endforeach
                        </select>
                         @error('unit')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >Image:</label>
                        <input type="file" name="image" class="form-control-file">
                        @error('image')
                                   <div style="color: red">*{{ $message }}</div>
                        @enderror
                    </div>

                </div>



            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Thêm thuốc</button>
            </div>
        </form>


    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

@endsection
