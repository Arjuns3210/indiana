<!DOCTYPE html>
<html class="loading" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="author" content="MYPCOTINFOTECH">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('public/backend/img/logo.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900%7CMontserrat:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/css/mypcot.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/fonts/feather/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/fonts/simple-line-icons/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/vendors/css/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/vendors/css/prism.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/vendors/css/switchery.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/css/themes/layout-dark.css') }}">
    <link rel="stylesheet" href="{{ url('public/backend/css/plugins/switchery.css') }}">
    <link rel="stylesheet" href="{{ url('public/backend/vendors/css/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/css/pages/charts-apex.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/css/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('public/backend/css/datepicker.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ url('public/backend/vendors/css/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css"
          integrity="sha512-rRQtF4V2wtAvXsou4iUAs2kXHi3Lj9NE7xJR77DE7GHsxgY9RTWy93dzMXgDIG8ToiRTD45VsDNdTiUagOFeZA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="{{ url('public/backend/vendors/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/backend/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('public/backend/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ url('public/backend/vendors/js/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('public/backend/vendors/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('public/backend/js/bootbox.min.js') }}"></script>
    <!-- added by arjun -->
    <script src="{{ url('public/backend/vendors/ckeditor5/ckeditor.js')}}"></script>
    <script src="{{ url('public/backend/vendors/js/datepicker.min.js') }}"></script>
</head>
<body class="vertical-layout vertical-menu auth-page 2-columns" data-menu="vertical-menu" data-col="2-columns"
      id="container">
<nav class="navbar navbar-expand-lg navbar-light header-navbar navbar-fixed mt-2">
    <div class="container-fluid navbar-wrapper">
        <div class="navbar-header d-flex pull-left">
            <div class="navbar-toggle menu-toggle d-xl-none d-block float-left align-items-center justify-content-center"
                 data-toggle="collapse"><i class="ft-menu font-medium-3"></i></div>
            <li class="nav-item mr-2 d-none d-lg-block">
                {{-- <a class="nav-link apptogglefullscreen" id="navbar-fullscreen" href="javascript:;">
                    <i class="ft-maximize font-medium-3" style="color:black !important"></i>
                </a> --}}
                </li>

                <h5 class="translateLable padding-top-sm padding-left-sm pt-1"  data-translate="welcome_to_admin_panel">Hello {{session('data')['name']}} ({{session('data')['nick_name']}})</h5>
            </div>
            <div class="navbar-container pull-right">
                <div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <div class="d-none d-xl-block">
                            <div class="col-sm-12">
                                <a href="profile" class="mr-1"><span class="mr-1" style="font-size: 24px; color: #aaa;">|</span><i title="Edit Profile" class="fa fa-user-circle-o fa-lg" style="color:brown;"></i></a>

                                <a href="updatePassword"><span class="mr-1" style="font-size: 24px; color: #aaa;">|</span><i title="Change Password" class="fa fa-key fa-lg" style="color:brown;"></i></a>

                                <a href="logout"><span class="mr-1" style="font-size: 24px; color: #aaa;">|</span><i title="Logout" class="fa fa-power-off fa-lg" style="color:brown;"></i></a>
                            </div>
                        </div>
                        <li class="dropdown nav-item d-xl-none d-block"><a id="dropdownBasic3" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-toggle"><i class="ft-user font-medium-3 blue-grey darken-4"></i>
                            <div class="dropdown-menu text-left dropdown-menu-right m-0 pb-0 dropdownBasic3Content" aria-labelledby="dropdownBasic2">
                                <a class="dropdown-item" href="profile">
                                    <div class="d-flex align-items-center"><i class="ft-edit mr-2"></i><span>Edit Profile</span></div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="updatePassword">
                                    <div class="d-flex align-items-center"><i class="ft-edit mr-2"></i><span>Update Password</span></div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout">
                                    <div class="d-flex align-items-center"><i class="ft-power mr-2"></i><span>Logout</span></div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <div class="app-sidebar menu-fixed" data-background-color="man-of-steel" data-image="{{ url('public/backend/img/sidebar-bg/01.jpg') }}" data-scroll-to-active="true">
            <div class="sidebar-header">
                <div class="logo clearfix">
                    <a class="logo-text float-left" href="dashboard">
                        <div class="logo-img" style="">
                            <img src="{{ url('public/backend/img/logo_withBG.png') }}" alt="Logo"/><span class="text-white text bold" style="font-size: smaller; text-transform: capitalize;">&nbsp;Indiana</span>
                        </div>
                    </a>
                    <a class="nav-toggle d-none d-lg-none d-xl-block is-active" id="sidebarToggle" href="javascript:;"><i class="toggle-icon ft-toggle-right" data-toggle="collapsed"></i></a>
                    <a class="nav-close d-block d-lg-block d-xl-none" id="sidebarClose" href="javascript:;"><i class="ft-x"></i></a>
                </div>
            </div>
            <div class="sidebar-content main-menu-content scroll">
                @php
                //$lastParam =  last(request()->segments());
                //GET OATH :: Request::path()
                    $lastParam =  Request::segment(2);
                    $permissions = Session::get('permissions');
                    $count = count($permissions);
                    $permission_array = array();
                    $user_id = session('data')['id'];
                    $user = \App\Models\Admin::where('id',$user_id)->first();

                @endphp
                @for($i=0; $i<$count; $i++)
                    @php
                        $permission_array[$i] = $permissions[$i]->codename;
                    @endphp
                @endfor
                <div class="nav-container">
                    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                        <li class="nav-item {{ Request::path() ==  'dashboard' ? 'active' : ''  }}">
                            <a href="dashboard"><i class="ft-home"></i><span class="menu-title" data-i18n="Documentation">Dashboard</span></a>
                        </li>

                                    @if(in_array('staff', $permission_array) || session('data')['role_id'] == 1)
                                        <li class="{{ Request::path() ==  'webadmin/staff' ? 'active' : ''  }}">
                                            <a href="staff" class="menu-item"><i class="icon-users"></i><span class="menu-title" data-i18n="">Manage Staff</span></a>
                                        </li>
                                    @endif
                        @if(in_array('product', $permission_array) || session('data')['role_id'] == 1)
                            <li class="{{ Request::path() ==  'webadmin/product' ? 'active' : ''  }}">
                                <a href="product" class="menu-item"><i class="fa fa-product-hunt"></i><span class="menu-title" data-i18n="">Product</span></a>
                            </li>
                        @endif
                        @if(in_array('abp', $permission_array) || session('data')['role_id'] == 1)
                            <li class="nav-item {{ $lastParam ==  'abp' ? 'active' : ''  }} abp-menu">
                            <li class="{{ Request::path() ==  'webadmin/abp_list' ? 'active' : ''  }} abp-menu">
                                <a href="abp_list" class="menu-item"><i class="ft-grid"></i><span class="menu-title" data-i18n="">OBP</span></a>
                            </li>
                        @endif
                        @if(in_array('region', $permission_array) || (session('data')['role_id'] == 1 && $user->is_head == 1))
                            <li class="nav-item {{ $lastParam ==  'region' ? 'active' : ''  }} region-menu">
                            <li class="{{ Request::path() ==  'webadmin/region_list' ? 'active' : ''  }} abp-menu">
                                <a href="region_list" class="menu-item"><i class="ft-grid"></i><span class="menu-title" data-i18n="">Region</span></a>
                            </li>
                        @endif

                        @if(session('data')['role_id'] == 1  || in_array('enquiry', $permission_array))
                            <li class="nav-item {{ $lastParam ==  'enquiry' ? 'active' : ''  }} enquiry-menu">
                               <li class="{{ Request::path() ==  'webadmin/enquiry_list' ? 'active' : ''  }} enquiry-menu">
                                            <a href="enquiry_list" class="menu-item"><i class="ft-grid"></i><span class="menu-title" data-i18n="">Enquiry</span></a>
                                </li>

                        @endif
                        @if(in_array('mipo', $permission_array) || session('data')['role_id'] == 1)
                        <li class="nav-item {{ Request::path() ==  'webadmin/mipo' ? 'active' : ''  }} mipo-menu">
                            <a href="mipo" class="menu-item"><i class="fa fa-file-text-o" aria-hidden="true"></i><span class="menu-title" data-i18n="Mipo">Mipo</span></a>
                        </li>
                        @endif
                        @if(in_array('daily_remarks', $permission_array) || session('data')['role_id'] == 1)
                        <li class="{{ Request::path() ==  'webadmin/daily_remarks' ? 'active' : ''  }}">
                            <a href="remarks" class="menu-item"><i class="ft-save"></i><span class="menu-title" data-i18n="Mipo">Daily Remark</span></a>
                        </li>
                        @endif

                        @if(session('data')['role_id'] == 1  ||
                            in_array('mis_report', $permission_array) ||
                            in_array('abp_weekly_report', $permission_array) ||
                            in_array('data_report', $permission_array) ||
                            in_array('engineer_achievement_report', $permission_array) ||
                            in_array('typist_achievement_report', $permission_array) ||
                            in_array('mipo_data_report', $permission_array)||
                            in_array('abp_variance_report', $permission_array)||
                            in_array('abp_tracker_report', $permission_array)

                        )
                            <li class="has-sub nav-item {{ $lastParam ==  'report' ? 'open' : ''  }} {{ $lastParam ==  'report' ? 'open' : ''  }}">
                                <a href="javascript:;" class="dropdown-parent"><i class="icon-user-following">  </i><span data-i18n="" class="menu-title">Reports</span></a>
                                <ul class="menu-content">
                                    @if(in_array('mis_report', $permission_array) || session('data')['role_id'] == 1)
                                        <li class="{{ Request::path() ==  'webadmin/mis_report' ? 'active' : ''  }}">
                                            <a href="mis_report" class="menu-item"><i class="fa fa-circle fs_i"></i>MIS Report</a>
                                        </li>
                                    @endif
                                    @if(in_array('data_report', $permission_array) || session('data')['role_id'] == 1)
                                        <li class="{{ Request::path() ==  'webadmin/data_report' ? 'active' : ''  }}">
                                            <a href="data_report" class="menu-item"><i class="fa fa-circle fs_i"></i>Enquiry Data Report</a>
                                        </li>
                                    @endif
                                    @if( in_array('mipo_data_report', $permission_array) || session('data')['role_id'] == 1)
                                        <li class="{{ Request::path() ==  'webadmin/mipo_report' ? 'active' : ''  }}">
                                            <a href="mipo_report" class="menu-item"><i class="fa fa-circle fs_i"></i>Mipo
                                                Report</a>
                                        </li>
                                        @endif
                                        @if( in_array('abp_variance_report', $permission_array) ||session('data')['role_id'] == 1)
                                            <li class="{{ Request::path() ==  'webadmin/abp_report' ? 'active' : ''  }}">
                                                <a href="abp_report" class="menu-item"><i class="fa fa-circle fs_i"></i>Abp
                                                    Variance Report</a>
                                            </li>
                                        @endif
                                        @if(in_array('abp_weekly_report', $permission_array) || session('data')['role_id'] == 1)
                                            <li class="{{ Request::path() ==  'webadmin/abp_weekly_report' ? 'active' : ''  }}">
                                                <a href="abp_weekly_report" class="menu-item"><i
                                                            class="fa fa-circle fs_i"></i>ABP Weekly Report</a>
                                            </li>
                                        @endif
                                        @if(in_array('abp_tracker_report', $permission_array) || session('data')['role_id'] == 1)
                                            <li class="{{ Request::path() ==  'webadmin/abp_tracker_report' ? 'active' : ''  }}">
                                                <a href="abp_tracker_report" class="menu-item"><i
                                                            class="fa fa-circle fs_i"></i>ABP Tracker Report</a>
                                            </li>
                                        @endif
                                        @if(in_array('engineer_achievement_report', $permission_array) || session('data')['role_id'] == 1)
                                            <li class="{{ Request::path() ==  'webadmin/engineer_achievement_report' ? 'active' : ''  }}">
                                                <a href="engineer_achievement_report" class="menu-item"><i
                                                            class="fa fa-circle fs_i"></i>Engineer Achievement
                                                    Report</a>
                                            </li>
                                        @endif

                                        @if(in_array('typist_achievement_report', $permission_array) || session('data')['role_id'] == 1)
                                            <li class="{{ Request::path() ==  'webadmin/typist_achievement_report' ? 'active' : ''  }}">
                                                <a href="typist_achievement_report" class="menu-item"><i
                                                        class="fa fa-circle fs_i"></i>Typist Achievement Report</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif


                        <li class="nav-item {{ $lastParam ==  'logout' ? 'active' : ''  }}">
                            <a href="logout"><i class="fa fa-power-off"></i><span class="menu-title" >Logout</span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="sidebar-background"></div>
        </div>
        <div class="main-panel">
            @yield('content')
            <footer class="footer">
                <p class="clearfix text-muted m-0"><span>Copyright &copy; 2022 &nbsp;</span><span class="d-none d-sm-inline-block"> All rights reserved.</span></p>
            </footer>
            <button class="btn btn-primary scroll-top" type="button"><i class="ft-arrow-up"></i></button>
        </div>
        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>
    </div>
</body>
<script src="{{ url('public/backend/vendors/js/switchery.min.js') }}"></script>
<script src="{{ url('public/backend/vendors/js/apexcharts.min.js') }}"></script>
<script src="{{ url('public/backend/js/charts-apex.js') }}"></script>
<script src="{{ url('public/backend/js/core/app-menu.js') }}"></script>
<script src="{{ url('public/backend/js/core/app.js') }}"></script>
<script src="{{ url('public/backend/js/notification-sidebar.js') }}"></script>
<script src="{{ url('public/backend/js/customizer.js') }}"></script>
<script src="{{ url('public/backend/js/scroll-top.js') }}"></script>
<script src="{{ url('public/backend/js/scripts.js') }}"></script>
<script src="{{ url('public/backend/js/mypcot.min.js') }}"></script>
<script src="{{ url('public/backend/js/select2.min.js') }}"></script>
<script src="{{ url('public/backend/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ url('public/backend/js/dropzone.min.js') }}"></script>
<script src="{{ url('public/backend/vendors/js/pickadate/picker.js') }}"></script>
<script src="{{ url('public/backend/vendors/js/pickadate/picker.date.js') }}"></script>
<script src="{{ url('public/backend/vendors/js/pickadate/picker.time.js') }}"></script>
<script src="{{ url('public/backend/vendors/js/daterangepicker/moment.min.js') }}"></script>
<script src="{{ url('public/backend/vendors/js/daterangepicker/daterangepicker.min.js') }}"></script>
<script src="{{ url('public/backend/js/ajax-custom.js') }}"></script>
</html>
<script>
    var currentDate = new Date();
    var year = currentDate.getFullYear();
    var month = ("0" + (currentDate.getMonth() + 1)).slice(-2); // Adding 1 and padding with 0 if necessary
    var day = ("0" + currentDate.getDate()).slice(-2); // Padding with 0 if necessary

    var formattedDate = day + '-' + month + '-' + year;
    // console.log(formattedDate);

    var sessionData = <?php echo json_encode(session()->all()); ?>;
    var expiryDate = sessionData.data.pwd_expiry_date;
    // console.log(sessionData.data.pwd_expiry_date); // Access the entire session data object

    if (expiryDate == formattedDate) {
        confirm('Your password is Expire');
    }
</script>