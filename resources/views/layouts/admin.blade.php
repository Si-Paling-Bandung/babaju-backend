<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">
    <meta name="author" content="Alejandro RH">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Admin Health Learning Platform</title>

    @stack('upper-css')

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link href="{{ asset('img/logo.png') }}" rel="icon" type="image/png">

    @stack('css')
    @stack('third_party_stylesheets')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('img/logo.png') }}" rel="icon" type="image/png" alt="" width="125px">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Nav::isRoute('home') }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{ __('Dashboard') }}</span></a>
            </li>


            <!-- Trainer / Admin Only -->
            @if (Auth::user() && (Auth::user()->role == 'tenaga_kesehatan' || Auth::user()->role == 'trainer' || Auth::user()->role == 'admin'))


                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Heading -->
                <div class="sidebar-heading">
                    {{ __('Learning Management') }}
                </div>

                <!-- Nav Item - Grade -->
                <li class="nav-item {{ Nav::isRoute('grade*') }}">
                    <a class="nav-link" href="{{ route('grade') }}">
                        <i class="fas fa-fw fa-list-ol"></i>
                        <span>{{ __('Overview Grade') }}</span>
                    </a>
                </li>

                <!-- Nav Item - Detail Grade -->
                <li class="nav-item {{ Nav::isRoute('detail.grade*') }}">
                    <a class="nav-link" href="{{ route('detail.grade') }}">
                        <i class="fas fa-fw fa-user-circle"></i>
                        <span>{{ __('Detail Grade') }}</span>
                    </a>
                </li>

            @endif

            <!-- Admin Only -->
            @if (Auth::user() && Auth::user()->role == 'admin')
                <!-- Nav Item - Profile -->
                <li class="nav-item {{ Nav::isRoute('topic*') }}">
                    <a class="nav-link" href="{{ route('topic') }}">
                        <i class="fas fa-fw fa-book"></i>
                        <span>{{ __('Courses') }}</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    {{ __('User Management') }}
                </div>

                <!-- Nav Item - Profile -->
                <li class="nav-item {{ Nav::isRoute('user*') }}">
                    <a class="nav-link" href="{{ route('user') }}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>{{ __('Users') }}</span>
                    </a>
                </li>

                <!-- Nav Item - Instance -->
                <li class="nav-item {{ Nav::isRoute('instance*') }}">
                    <a class="nav-link" href="{{ route('instance') }}">
                        <i class="fas fa-fw fa-plus-square"></i>
                        <span>{{ __('Puskesmas') }}</span>
                    </a>
                </li>

                <!-- Nav Item - Local Officials -->
                <li class="nav-item {{ Nav::isRoute('local-official*') }}">
                    <a class="nav-link" href="{{ route('local-official') }}">
                        <i class="fas fa-fw fa-user-tie"></i>
                        <span>{{ __('Local Officials') }}</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Heading -->
                <div class="sidebar-heading">
                    {{ __('Admin Management') }}
                </div>

                <!-- Nav Item - Announcement -->
                <li class="nav-item {{ Nav::isRoute('announcement*') }}">
                    <a class="nav-link" href="{{ route('announcement') }}">
                        <i class="fas fa-fw fa-bell"></i>
                        <span>{{ __('Announcement') }}</span>
                    </a>
                </li>

                <!-- Nav Item - Config -->
                <li class="nav-item {{ Nav::isRoute('config*') }}">
                    <a class="nav-link" href="{{ route('config') }}">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>{{ __('Config') }}</span>
                    </a>
                </li>

                <!-- Nav Item - Logs -->
                <li class="nav-item {{ Nav::isRoute('logs*') }}">
                    <a class="nav-link" href="{{ route('logs') }}">
                        <i class="fas fa-fw fa-copy"></i>
                        <span>{{ __('Logs') }}</span>
                    </a>
                </li>

                <!-- Nav Item - Backup -->
                <li class="nav-item {{ Nav::isRoute('backup*') }}">
                    <a class="nav-link" href="{{ route('backup') }}">
                        <i class="fas fa-fw fa-undo"></i>
                        <span>{{ __('Backup') }}</span>
                    </a>
                </li>

            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Logout Sidebar -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    {{ __('Logout') }}
                </a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <figure class="img-profile rounded-circle avatar font-weight-bold"
                                    data-initial="{{ Auth::user()->name[0] }}"></figure>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Settings') }}
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Activity Log') }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    {{ __('Logout') }}
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('main-content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; CISDI 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    @stack('upper-script')

    <!-- Scripts -->
    @if (Nav::isRoute('user.update') || Nav::isRoute('user.create'))
        {{-- Nothing --}}
    @else
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    @endif
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    @stack('script')
    @stack('third_party_scripts')
</body>

</html>
