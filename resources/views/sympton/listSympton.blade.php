@extends('layout/master')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách triệu chứng</h3>
        {{-- <a href="javascript:void(0)" class="btn btn-primary float-right" id="createSympton" data-toggle="modal"  data-target="#CreateSymptonModal">Thêm+</a> --}}
    </div>
    <!-- /.card-header -->
    <div class="card-body" id="table-ajax-user">
        <table id="tableSympton" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên triệu chứng</th>
                    <th></th>

                </tr>
            </thead>
            <tbody id="sympton_list">
                @foreach($symptons as $key =>$sympton)
                <tr id = "sympton_id_{{$sympton->id}}">
                    <td>{{ ++$key }}</td>
                    <td>{{ $sympton->sympton_name }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="#" class="mr-2 editSympton" data-toggle="modal"  data-id="{{ $sympton->id }}"> <i class="nav-icon fas fa-edit"></i> Sửa</a>
                        <a style="color: red" href="#" class="deleteSympton" data-toggle="tooltip" data-id="{{ $sympton->id }}"> <i class="nav-icon far fa-trash-alt" style="color: red"></i> Xóa</a>
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
                <h4 class="modal-title">Sửa triệu chứng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="symptonForm" name="userForm" class="form-horizontal">
                    <input type="hidden" name="sympton_id" id="sympton_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-6">Triệu chứng</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="sympton_name" name="sympton_name" value="#">
                            <span id="titleError" class="alert-message"></span>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button id="btn-close-modal" type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
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
      $(function(){
          $('#tableSympton').DataTable({
              "reponsive":true,
              "autoWidth":false
          });
      });
  </script>
<script>

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
        });
        //EDIT
        initEventEditButtons();
    });


    function initEventEditButtons() {
        $('#btn-close-modal').click();
        $('body').off('click','.editSympton');
        $('body').on('click','.editSympton',function(event){
            event.preventDefault();

            var url = `/admin/sympton`;
            var sympton_id = $(this).data('id');

            $.get(`${url}/${sympton_id}/edit`,function(data){
                $('#sympton_id').val(data.symptons.id);
                $('#sympton_name').val(data.symptons.sympton_name);
                $('#btn-save').val("update");
                $('#modal-default').modal('show');
            });
        });

        $('#btn-save').click(function (e) {
            e.preventDefault();
            Swal.fire({
            title: 'Thành công!',
            text: 'Bạn có muốn tiếp tục',
            type: 'success',
            confirmButtonText: 'OK'

        })

            var sympton_id = $('#sympton_id').val();

            $.ajax({
            data: $('#symptonForm').serialize(),
            url: `/admin/sympton/${sympton_id}/edit`,
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#symptonForm').trigger("reset");

                let key = 0;

                // render
                document.querySelector("#sympton_list").innerHTML =
                data.sympton.reduce((docs, st) =>
                docs +
                `
                    <td>${++key}</td>
                    <td>${st.sympton_name}</td>
                    <td class="d-flex justify-content-center">
                        <a href="#" class="mr-2 editSympton" data-toggle="modal" data-target='#modal-default' data-id="${st.id}"> <i class="nav-icon fas fa-edit"></i> Sửa</a>
                        <a style="color: red" href="#" class="deleteSympton" data-toggle="tooltip" data-id="${st.id}"> <i class="nav-icon far fa-trash-alt" style="color: red"></i> Xóa</a>
                    </tr>
                `, ``);

                initEventEditButtons();

            },
            error: function (data) {
            }
            });
        });

        //DELETE

        $('body').on('click','.deleteSympton',function(){
            var sympton_id = $(this).data('id');
            // confirm('Bạn có chắc muốn xóa mục này?');
            Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        console.log(result.value)
                        if (result.value) {
                        $.ajax({
                            type:"DELETE",
                            url: `/admin/sympton/${sympton_id}/destroy`,
                            success: function(data){

                                let key = 0;

                                document.querySelector("#sympton_list").innerHTML =
                                data.sympton.reduce((docs, st) =>
                                docs +
                                `
                                    <td>${++key}</td>
                                    <td>${st.sympton_name}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="#" class="mr-2 editSympton" data-toggle="modal" data-target='#modal-default' data-id="${st.id}"> <i class="nav-icon fas fa-edit"></i> Sửa</a>
                                        <a style="color: red" href="#" class="deleteSympton" data-toggle="tooltip" data-id="${st.id}"> <i class="nav-icon far fa-trash-alt" style="color: red"></i> Xóa</a>
                                    </tr>
                                `,``
                                );
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                        )
                },
                error:function(data){
                    console.log('Error',data);
                }
            })

                        }
})


        });
    };




</script>

@endsection
