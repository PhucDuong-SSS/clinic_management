@extends('layout/master') @section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Chọn thời gian</label>
                    <select class="form-control" id="datetime">
                       <option value="0" selected>---Chọn thời gian---</option>
                            <option value="1">Theo ngày</option>
                            <option value="2">Theo tháng </option>
                            <option value="3">Theo năm</option>
                        </select>



                </div>


            </div>
            <div class="col-md-6 ">
                <div class="form-group">
                    <label>Pick chọn thời gian</label>
                    <div class="input-group" id="set">

                    </div>
                </div>


            </div>


            <div class="col-md-12 ">
                <div class="text-center ">
                    <button id="show" type="button " class="btn btn-primary btn-lg btn3d "><span><i class="fas fa-search-dollar "></i>

                    </span></button>
                </div>
            </div>
            <br>
            <br>
            <br>
           <span id="content"></span>
        </div>
        <!-- /.container-fluid -->
</section>

@endsection @section('script')
<script>
    $(document).ready(function() {

        $(".customer ").toggle();

    });

    $(document).ready(function() {
        $("#a ").click(function() {
            $(".customer ").show();
        });
    });

    $(document).ready(function() {
        $("#datetime ").change(function() {
            let a = $("#datetime ").val();
            if(a == 3)
            {
                let set = `<select class="form-control" id="type_date" name="startyear">
                            <?php
                            for ($year = (int)date('Y'); 1900 <= $year; $year--): ?>
                              <option value="<?=$year;?>"><?=$year;?></option>
                            <?php endfor; ?>
                           </select>`;
                     $("#set").html(set);

            }
            if (a == 2) {
                let set = `<input id="type_date" type="month" class="form-control" />`
                $("#set").html(set);
            }
            if (a == 1 || a == 0) {
                let set = `<input id="type_date" type="date" class="form-control" />`
                $("#set").html(set);
            }
            $(".customer ").show();
        });

        $('body').on('click', '#show', function(e){
            e.preventDefault();
            let type = $("#datetime ").val();
            let date = $("#type_date ").val();
            if(date)
            {
            let filed= date.split('-');
            let year =filed[0];
            let month =filed[1];
            let day =filed[2];

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                type: "post",
                url: "{{ route('datereport.show') }}",
                data: {year:year, month:month, day:day },
                success: function (data) {
                    console.log(data)
                    $('#content').html(data.html);
                }
            });
            }
        });
    });

    $(document).ready(function() {
        $("#c ").click(function() {
            $(".customer ").hide();
        });
    });
</script>

@endsection
