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
            $checkListUser = DB::table('permissions')->where('permission_name', 'list_user')->value('id');
            $checkListUnit = DB::table('permissions')->where('permission_name', 'list_unit')->value('id');
            $checkListRole= DB::table('permissions')->where('permission_name', 'list_role')->value('id');
            $checkListMed = DB::table('permissions')->where('permission_name', 'list_med')->value('id');
            $checkListLot = DB::table('permissions')->where('permission_name', 'list_lot')->value('id');
            $checkListMedCategory = DB::table('permissions')->where('permission_name', 'list_medCategory')->value('id');
            $checkListAlmostOver = DB::table('permissions')->where('permission_name', 'list_almostOver')->value('id');
            $checkListSymton = DB::table('permissions')->where('permission_name', 'list_symton')->value('id');
            $checkSetting = DB::table('permissions')->where('permission_name', 'list_setting')->value('id');
            $checkReport = DB::table('permissions')->where('permission_name', 'report_revenue')->value('id');
            $checkListPrescription = DB::table('permissions')->where('permission_name', 'list_prescription')->value('id');
            $checkCreatePrescription = DB::table('permissions')->where('permission_name', 'add_prescription')->value('id');

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4" >

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            @if(isset(Illuminate\Support\Facades\Auth::user()->image))
               <div class="image">
                   <a href="{{route('home.index')}}">
                <img src="{{Illuminate\Support\Facades\Auth::user()->getUrl()}}.{{(Illuminate\Support\Facades\Auth::user()->image))}}" style="object-fit:contain;width: 50px;height: 50px" class="img-circle elevation-2" alt="User Image">
                   </a>
            </div>
             @endif
            @if(isset(Illuminate\Support\Facades\Auth::user()->full_name))
            <div class="info">
                <a href="{{route('home.index')}}" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->full_name}}</a>
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
                        <i class="fas fa-users"></i>&nbsp;
                        <p>
                            Danh sách thành viên
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('user.changeprofileform')}}" class="nav-link">
                        <i class="fas fa-user-edit"></i>&nbsp;
                        <p>
                            Đổi thông tin cá nhân
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('user.changepasswordform')}}" class="nav-link">
                        <i class="fas fa-key"></i>&nbsp;
                        <p>
                            Đổi mật khẩu
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{($permissionOfRole->contains($checkListPrescription) | $permissionOfRole->contains($checkCreatePrescription)) ? '': 'd-none'}}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-file-alt"></i>&nbsp;
                        <p>
                            Quản lý đơn thuốc
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item
                        {{$permissionOfRole->contains($checkListPrescription) ? '': 'd-none'}}">
                            <a href="{{route('prescription.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách đơn thuốc</p>
                            </a>
                        </li>
                        <li class="nav-item {{$permissionOfRole->contains($checkCreatePrescription) ? '': 'd-none'}}">
                            <a href="{{route('prescription.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tạo đơn thuốc mới</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview
                {{$permissionOfRole->contains($checkReport) ? '': 'd-none'}}
                ">
                    <a href="#" class="nav-link">
                        <i class="far fa-money-bill-alt"></i>&nbsp;
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


                <li class="nav-item has-treeview
                {{$permissionOfRole->contains($checkListSymton) ? '': 'd-none'}}
                ">
                    <a href="{{route('sympton.index')}}" class="nav-link">
                        <i class="fas fa-stethoscope"></i>&nbsp;
                        <p>
                            Triệu chứng
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview
                {{$permissionOfRole->contains($checkListMedCategory) ? '': 'd-none'}}
                    ">
                    <a href="{{route('medCategory.index')}}" class="nav-link">
                        <i class="fas fa-list-alt"></i>
                        <p>
                            Danh mục
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{$permissionOfRole->contains($checkListLot) ? '': 'd-none'}}">
                    <a href="{{route('lots.index')}}" class="nav-link">
                        <i class="fas fa-boxes"></i>&nbsp;
                        <p>
                            Nhập thuốc
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{$permissionOfRole->contains($checkListMed) ? '': 'd-none'}}">
                    <a href="{{route('med.index')}}" class="nav-link">
                        <i class="fas fa-capsules"></i>&nbsp;
                        <p>
                            Thuốc
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview
                {{$permissionOfRole->contains($checkListAlmostOver) ? '': 'd-none'}}
                    ">
                    <a href="{{route('med.aboutToExpire')}}" class="nav-link">
                        <i class="fas fa-exclamation-circle"></i>&nbsp;
                        <p>
                            Thuốc sắp hết
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{$permissionOfRole->contains($checkListUnit) ? '': 'd-none'}}">
                    <a href="{{route('unit.index')}}" class="nav-link">
                        <i class="far fa-list-alt"></i>&nbsp;
                        <p>
                            Đơn vị
                        </p>
                    </a>
                </li>
                {{-- Cấu hình trang --}}
                <li class="nav-item has-treeview
                {{$permissionOfRole->contains($checkSetting) ? '': 'd-none'}}
                    ">
                    <a href="{{route('setting.index')}}" class="nav-link">
                        <i class="fas fa-user-cog"></i>&nbsp;
                        <p>
                            Cấu hình
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview
                {{$permissionOfRole->contains($checkListRole) ? '': 'd-none'}}
                ">
                    <a href="{{route('role.index')}}" class="nav-link">
                        <i class="fas fa-user-tag"></i>&nbsp;
                        <p>
                            Quyền
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{route('admin.logout')}}" class="nav-link">
                     <i class="fas fa-sign-out-alt"></i>
                        <p>
                            Đăng xuất
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

</aside>
