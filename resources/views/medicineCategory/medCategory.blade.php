@extends('layout/master')
@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách loại thuốc</h3>
            <a href="#" class="btn btn-primary float-right" id="createMedCatorgy" data-toggle="modal"
               data-target="#modal-default">Thêm+</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body" id="table-ajax-user">
            <table id="tableMedCategory" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Loại thuốc</th>
                    <th>Mô tả</th>
                    <th></th>

                </tr>
                </thead>
                <tbody id="medCategory_list">
                @foreach($medCategories as $key =>$medCategory)
                    <tr id="medCategory_id_{{$medCategory->id}}">
                        <td>{{ ++$key }}</td>
                        <td>{{ $medCategory->med_category_name }}</td>
                        <td>{{ $medCategory->description }}</td>
                        <td class="d-flex justify-content-center">
                            <a href="#" class="mr-2 editMedCategory" data-toggle="modal" data-id="{{ $medCategory->id }}"> <i
                                    class="nav-icon fas fa-edit"></i> Sửa</a>
                            <a style="color: red" href="#" class="deleteMedCategory" data-toggle="tooltip"
                               data-id="{{ $medCategory->id }}"> <i class="nav-icon far fa-trash-alt"
                                                                style="color: red"></i> Xóa</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- medium modal -->
    <div class="modal fade in" id="modal-default" data-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="medCategoryForm" name="userForm" class="form-horizontal">
                        <input type="hidden" name="medCategory_id" id="medCategory_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-6">Tên loại thuốc:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="med_category_name" name="med_category_name">
                                <span id="titleError" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-6">Miêu tả:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="description" name="description">
                                <span id="titleError1" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button id="btn-close-modal" type="button" class="btn btn-default" data-dismiss="modal">
                                Đóng
                            </button>
                            <button id="btn-save" type="button" class="btn btn-primary">Sửa</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection
@section('script')
    <script>
        $(function () {
            $('#tableMedCategory').DataTable({
                "reponsive": true,
                "autoWidth": false
            });
        });
    </script>
    <script>

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
        });

        //EDIT
        initEventEditButtons();


        function initEventEditButtons() {

            //ADD
            $('#btn-close-modal').click();
            $('body').off('click', '#createMedCatorgy');
            $('body').on('click', '#createMedCatorgy', function (e) {
                e.preventDefault();
                var url = `/admin/medCategory`;


                $.get(`${url}`, function (data) {
                    $('#modalHeading').html('Thêm loại thuốc'),
                        $('#med_category_name').val(data.med_category_name);
                    $('#description').val(data.description);
                    $('#btn-save').val("addMedCategory");
                    $('#btn-save').html('Thêm');
                    $('#modal-default').modal('show');
                    const inputs = $('.form-control');
                    const errors = $('.text-danger');
                    $.each(inputs, function (indx, input){
                        $(input).removeClass('is-invalid');
                    })
                    $.each(errors,function (idx,error){
                        $(error).html('');
                    })

                });


            });

            // EDIT
            $('#btn-close-modal').click();
            $('body').off('click', '.editMedCategory');
            $('body').on('click', '.editMedCategory', function (event) {
                event.preventDefault();

                var url = `/admin/medCategory`;
                var medCategory_id = $(this).data('id');



                $.get(`${url}/${medCategory_id}/edit`, function (data) {
                    $('#modalHeading').html('Sửa loại thuốc'),
                        $('#medCategory_id').val(data.medCategories.id);
                    $('#med_category_name').val(data.medCategories.med_category_name);
                    $('#description').val(data.medCategories.description);
                    $('#btn-save').val("update");
                    $('#btn-save').html("Sửa");
                    $('#modal-default').modal('show');
                    const inputs = $('.form-control');
                    const errors = $('.text-danger');
                    $.each(inputs, function (indx, input){
                        $(input).removeClass('is-invalid');
                    })
                    $.each(errors,function (idx,error){
                        $(error).html('');
                    })
                });
            });

            $('#btn-save').off('click');
            $('#btn-save').click(function (e) {
                e.preventDefault();


                var medCategory_id = $('#medCategory_id').val();
                var valSubmit = $(this).val();

                if (valSubmit == 'addMedCategory') {
                    $.ajax({
                        type: "POST",
                        url: "/admin/medCategory/add-med-category",
                        data: $("#medCategoryForm").serialize(),

                        success: function (data) {
                            $('#medCategoryForm').trigger("reset");
                            $('#modal-default').modal('hide');
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Bạn có muốn tiếp tục',
                                type: 'success',
                                confirmButtonText: 'OK'

                            })

                            let key = 0;

                            // render
                            document.querySelector("#medCategory_list").innerHTML =

                                data.medCategories.reduce((docs, st) =>
                                    docs +
                                    ` <tr id="medCategory_id_${st.id}">
                                        <td>${++key}</td>
                                        <td>${st.med_category_name}</td>
                                        <td>${st.description}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="#" class="mr-2 editMedCategory" data-toggle="modal" data-target='#modal-default' data-id="${st.id}"> <i class="nav-icon fas fa-edit"></i> Sửa</a>
                                            <a style="color: #ff0000" href="#" class="deleteMedCategory" data-toggle="tooltip" data-id="${st.id}"> <i class="nav-icon far fa-trash-alt" style="color: #ff0000"></i> Xóa</a>
                                        </tr>
                                    `, ``);

                            initEventEditButtons();
                        },
                        error: function (data) {
                            let error = data.responseJSON.errors;
                            console.log(error);
                            if(error.med_category_name) {
                                $('#med_category_name').addClass('is-invalid');
                                $('#titleError').html(error.med_category_name);

                            }
                            if(error.description) {
                                $('#description').addClass('is-invalid');
                                $('#titleError1').html(error.description);

                            }
                        }
                    })
                }

                if (valSubmit == 'update') {
                    $.ajax({
                        data: $('#medCategoryForm').serialize(),
                        url: `/admin/medCategory/${medCategory_id}/edit`,
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#medCategoryForm').trigger("reset");
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Bạn có muốn tiếp tục',
                                type: 'success',
                                confirmButtonText: 'OK',

                            })

                            let key = 0;

                            // render
                            document.querySelector("#medCategory_list").innerHTML =

                                data.medCategories.reduce((docs, st) =>
                                    docs +
                                    `<tr id="medCategory_id_${st.id}">
                                            <td>${++key}</td>
                                            <td>${st.med_category_name}</td>
                                             <td>${st.description}</td>
                                            <td class="d-flex justify-content-center">
                                                <a href="#" class="mr-2 editMedCategory" data-toggle="modal" data-target='#modal-default' data-id="${st.id}"> <i class="nav-icon fas fa-edit"></i> Sửa</a>
                                                <a style="color: #ff0000" href="#" class="deleteMedCategory" data-toggle="tooltip" data-id="${st.id}"> <i class="nav-icon far fa-trash-alt" style="color: #ff0000"></i> Xóa</a>
                                            </tr>
                                        `, ``);

                            initEventEditButtons();

                        },
                        error: function (data) {
                            let error = data.responseJSON.errors;

                            if(error.med_category_name) {
                                $('#med_category_name').addClass('is-invalid');
                                $('#titleError').html(error.med_category_name);
                            }
                            if(error.description) {
                                $('#description').addClass('is-invalid');
                                $('#titleError1').html(error.description);

                            }
                        }
                    });
                }

            });

            //DELETE

            $('body').on('click', '.deleteMedCategory', function () {
                var medCategory_id = $(this).data('id');
                // confirm('Bạn có chắc muốn xóa mục này?');
                Swal.fire({
                    title: 'Bạn có chắc không?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    console.log(result.value)
                    if (result.value) {
                        $.ajax({
                            type: "DELETE",
                            url: `/admin/medCategory/${medCategory_id}/destroy`,
                            success: function (data) {

                                let key = 0;

                                document.querySelector("#medCategory_list").innerHTML =
                                    data.medCategories.reduce((docs, st) =>
                                        docs +
                                        `
                                    <td>${++key}</td>
                                    <td>${st.med_category_name}</td>
                                    <td>${st.description}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="#" class="mr-2 editMedCategory" data-toggle="modal" data-target='#modal-default' data-id="${st.id}"> <i class="nav-icon fas fa-edit"></i> Sửa</a>
                                        <a style="color: red" href="#" class="deleteMedCategory" data-toggle="tooltip" data-id="${st.id}"> <i class="nav-icon far fa-trash-alt" style="color: red"></i> Xóa</a>
                                    </tr>
                                `, ``
                                    );
                                Swal.fire(
                                    'Đã xóa!',
                                    'Xóa thành công.',
                                    'success'
                                )
                            },
                            error: function (data) {
                                console.log('Error', data);
                                 Swal.fire(
                                    'Bạn không thể xóa!',
                                    'Muốn xóa bạn phải xóa hết các thuốc có loại thuốc này'
                                )
                            }
                        })

                    }
                })


            });

        };


    </script>

@endsection
