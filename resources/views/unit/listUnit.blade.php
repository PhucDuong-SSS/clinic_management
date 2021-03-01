<?php
             $roleOfUser = DB::table('users')
            ->join('user_role', 'users.id', '=', 'user_role.id_user')
            ->join('roles', 'user_role.role_key', '=', 'roles.id')
            ->where('users.id', auth()->id())->select('roles.*')->get()->pluck('id');
            $permissionOfRole = DB::table('roles')
            ->join('role_permission', 'roles.id', '=', 'role_permission.role_key')
            ->join('permissions', 'role_permission.permission_key', '=', 'permissions.id')
            ->where('roles.id', $roleOfUser)
            ->select('permissions.*')->get()->pluck('id')->unique();
            $checkEditUnit = DB::table('permissions')->where('permission_name', 'edit_unit')->value('id');
            $checkDeleteUnit = DB::table('permissions')->where('permission_name', 'delete_unit')->value('id');
            $checkCreateUnit = DB::table('permissions')->where('permission_name', 'add_unit')->value('id');
?>

@extends('layout/master')
@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách Đơn vị</h3>
            @if($permissionOfRole->contains($checkCreateUnit))
            <a href="#" class="btn btn-primary float-right" id="createUnit" data-toggle="modal"
               data-target="#modal-default">Thêm+</a>
            @endif
        </div>
        <!-- /.card-header -->
        <div class="card-body" id="table-ajax-user">
            <table id="tableUnit" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên Đơn vị</th>
                    <th></th>

                </tr>
                </thead>
                <tbody id="unit_list">
                @foreach($units as $key =>$unit)
                    <tr id="unit_id_{{$unit->id}}">
                        <td>{{ ++$key }}</td>
                        <td>{{ $unit->unit_name }}</td>
                        <td class="d-flex justify-content-center">
                             @if($permissionOfRole->contains($checkEditUnit))
                            <a href="#" class="mr-2 editUnit" data-toggle="modal" data-id="{{ $unit->id }}"> <i
                                    class="nav-icon fas fa-edit"></i> Sửa</a>
                            @endif
                             @if($permissionOfRole->contains($checkDeleteUnit))
                            <a style="color: red" href="#" class="deleteUnit" data-toggle="tooltip"
                               data-id="{{ $unit->id }}"> <i class="nav-icon far fa-trash-alt"
                                                                style="color: red"></i> Xóa</a>
                            @endif
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
                    <form id="unitForm" name="userForm" class="form-horizontal">
                        <input type="hidden" name="unit_id" id="unit_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-6">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="unit_name" name="unit_name">
                                <span id="titleError" class="text-danger"></span>
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
            $('#tableUnit').DataTable({
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
            $('body').off('click', '#createUnit');
            $('body').on('click', '#createUnit', function (e) {
                e.preventDefault();
                var url = `/admin/unit`;


                $.get(`${url}`, function (data) {
                    $('#modalHeading').html('Thêm đơn vị'),
                        $('#unit_name').val(data.unit_name);
                    $('#btn-save').val("addUnit");
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
            $('body').off('click', '.editUnit');
            $('body').on('click', '.editUnit', function (event) {
                event.preventDefault();

                var url = `/admin/unit`;
                var unit_id = $(this).data('id');


                $.get(`${url}/${unit_id}/edit`, function (data) {
                    $('#modalHeading').html('Sửa đơn vị'),
                        $('#unit_id').val(data.units.id);
                    $('#unit_name').val(data.units.unit_name);
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


                var unit_id = $('#unit_id').val();
                var valSubmit = $(this).val();

                if (valSubmit == 'addUnit') {
                    $.ajax({
                        type: "POST",
                        url: "/admin/unit/create",
                        data: $("#unitForm").serialize(),

                        success: function (data) {
                            $('#unitForm').trigger("reset");
                            $('#modal-default').modal('hide');
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Bạn có muốn tiếp tục',
                                type: 'success',
                                confirmButtonText: 'OK'

                            })

                            let key = 0;

                            // render
                            document.querySelector("#unit_list").innerHTML =

                                data.units.reduce((docs, st) =>
                                    docs +
                                    ` <tr id="unit_id_${st.id}">
                                        <td>${++key}</td>
                                        <td>${st.unit_name}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="#" class="mr-2 editUnit" data-toggle="modal" data-target='#modal-default' data-id="${st.id}"> <i class="nav-icon fas fa-edit"></i> Sửa</a>
                                            <a style="color: #ff0000" href="#" class="deleteUnit" data-toggle="tooltip" data-id="${st.id}"> <i class="nav-icon far fa-trash-alt" style="color: #ff0000"></i> Xóa</a>
                                        </tr>
                                    `, ``);

                            initEventEditButtons();
                        },
                        error: function (data) {
                            let error = data.responseJSON.errors;
                            console.log(error)

                            if(error.unit_name) {
                                $('#unit_name').addClass('is-invalid');
                                $('#titleError').html(error.unit_name);

                            }
                        }
                    })
                }

                if (valSubmit == 'update') {
                    $.ajax({
                        data: $('#unitForm').serialize(),
                        url: `/admin/unit/${unit_id}/edit`,
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#unitForm').trigger("reset");
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Bạn có muốn tiếp tục',
                                type: 'success',
                                confirmButtonText: 'OK',

                            })

                            let key = 0;

                            // render
                            document.querySelector("#unit_list").innerHTML =
                                data.units.reduce((docs, st) =>
                                    docs +
                                    `<tr id="unit_id_${st.id}">
                                            <td>${++key}</td>
                                            <td>${st.unit_name}</td>
                                            <td class="d-flex justify-content-center">
                                                <a href="#" class="mr-2 editUnit" data-toggle="modal" data-target='#modal-default' data-id="${st.id}"> <i class="nav-icon fas fa-edit"></i> Sửa</a>
                                                <a style="color: #ff0000" href="#" class="deleteUnit" data-toggle="tooltip" data-id="${st.id}"> <i class="nav-icon far fa-trash-alt" style="color: #ff0000"></i> Xóa</a>
                                            </tr>
                                        `, ``);

                            initEventEditButtons();

                        },
                        error: function (data) {
                            let error = data.responseJSON.errors;
                            console.log(error)

                            if(error.unit_name) {
                                $('#unit_name').addClass('is-invalid');
                                $('#titleError').html(error.unit_name);
                            }
                        }
                    });
                }

            });

            //DELETE

            $('body').on('click', '.deleteUnit', function () {
                var unit_id = $(this).data('id');
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
                            url: `/admin/unit/destroy/${unit_id}`,
                            success: function (data) {

                                let key = 0;

                                document.querySelector("#unit_list").innerHTML =
                                    data.units.reduce((docs, st) =>
                                        docs +
                                        `
                                    <td>${++key}</td>
                                    <td>${st.unit_name}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="#" class="mr-2 editUnit" data-toggle="modal" data-target='#modal-default' data-id="${st.id}"> <i class="nav-icon fas fa-edit"></i> Sửa</a>
                                        <a style="color: red" href="#" class="deleteUnit" data-toggle="tooltip" data-id="${st.id}"> <i class="nav-icon far fa-trash-alt" style="color: red"></i> Xóa</a>
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
                                    'Muốn xóa bạn phải xóa hết các thuốc sử dụng đơn vị này'
                                )
                            }
                        })

                    }
                })


            });

        };


    </script>

@endsection
