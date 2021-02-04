<div class="card-body" id="table-ajax-user">
    <table id="symptonTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên triệu chứng</th>
                <th></th>

            </tr>
        </thead>
        <tbody>
            @foreach($symptons as $key =>$sympton)
            <tr id = "sympton_id_{{$sympton->id}}">
                <td>{{ ++$key }}</td>
                <td>{{ $sympton->sympton_name }}</td>
                <td class="d-flex justify-content-center">
                    <a href="#" class="mr-2 editSympton" data-toggle="modal" data-target='#modal-default' data-id="{{ $sympton->id }}"> <i class="nav-icon fas fa-edit"></i> Sửa</a>
                    <a style="color: red" href="#" class="deleteSympton" data-toggle="tooltip" data-id="{{ $sympton->id }}"> <i class="nav-icon far fa-trash-alt" style="color: red"></i> Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
