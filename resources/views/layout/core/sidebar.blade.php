
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="index3.html" class="brand-link">
        <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>


    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            @if(isset(Illuminate\Support\Facades\Auth::user()->image))
               <div class="image">
                <img src="{{asset('/storage/'.substr(Illuminate\Support\Facades\Auth::user()->image,7))}}" style="object-fit:contain;width: 50px;height: 50px" class="img-circle elevation-2" alt="User Image">
            </div>
             @endif
            @if(isset(Illuminate\Support\Facades\Auth::user()->full_name))
            <div class="info">
                <a href="#" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->full_name}}</a>
            </div>
            @endif
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview
                {{$permissionOfRole->contains($checkListUser) ? '': 'd-none'}}
                "
                >
                    <a href="{{route('user.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Danh sách thành viên
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('user.changepasswordform')}}" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Đổi mật khẩu
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('user.changeprofileform')}}" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Đổi thông tin cá nhân
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Quản lý đơn thuốc
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('prescription.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách đơn thuốc</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('prescription.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tạo đơn thuốc mới</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="far fa-money-bill-alt"></i>
                        <p>
                            Báo cáo doanh thu
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('report.show')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Doanh thu</p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- Cấu hình trang --}}
                <li class="nav-item has-treeview">
                    <a href="{{route('setting.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Cấu hình
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('sympton.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Triệu chứng
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('med.aboutToExpire')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                           Các thuốc sắp hết
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('medCategory.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Danh mục
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('lots.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Nhập thuốc
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('med.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Thuốc
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{$permissionOfRole->contains($checkListUnit) ? '': 'd-none'}}">
                    <a href="{{route('unit.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Đơn vị
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('admin.logout')}}" class="nav-link">
                        Logout
                    </a>
                </li>
            </ul>
        </nav>

    </div>

</aside>
