<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sleek - Admin Dashboard Template</title>

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet"/>
    <link href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css" rel="stylesheet" />

    <!-- PLUGINS CSS STYLE -->
    <link href="assets/plugins/toaster/toastr.min.css" rel="stylesheet" />
    <link href="assets/plugins/nprogress/nprogress.css" rel="stylesheet" />
    <link href="assets/plugins/flag-icons/css/flag-icon.min.css" rel="stylesheet"/>
    <link href="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <link href="assets/plugins/ladda/ladda.min.css" rel="stylesheet" />
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />

    <!-- SLEEK CSS -->
    <link id="sleek-css" rel="stylesheet" href="assets/css/sleek.css" />



    <!-- FAVICON -->
    <link href="assets/img/favicon.png" rel="shortcut icon" />

    <!--
      HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
    -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="assets/plugins/nprogress/nprogress.js"></script>
</head>

<body class="sidebar-fixed sidebar-dark header-light header-fixed" id="body">
<script>
    NProgress.configure({ showSpinner: false });
    NProgress.start();
</script>

<div class="mobile-sticky-body-overlay"></div>

<div class="wrapper">

    <!--
====================================
——— LEFT SIDEBAR WITH FOOTER
=====================================
-->
    <aside class="left-sidebar bg-sidebar">
        <div id="sidebar" class="sidebar sidebar-with-footer">
            <!-- Aplication Brand -->
            <div class="app-brand">
                <a href="/index.html">
                    <svg
                        class="brand-icon"
                        xmlns="http://www.w3.org/2000/svg"
                        preserveAspectRatio="xMidYMid"
                        width="30"
                        height="33"
                        viewBox="0 0 30 33"
                    >
                        <g fill="none" fill-rule="evenodd">
                            <path
                                class="logo-fill-blue"
                                fill="#7DBCFF"
                                d="M0 4v25l8 4V0zM22 4v25l8 4V0z"
                            />
                            <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                        </g>
                    </svg>
                    <span class="brand-name">Ekspedisi Dashboard</span>
                </a>
            </div>
            <!-- begin sidebar scrollbar -->
            <div class="sidebar-scrollbar">

                <!-- sidebar menu -->
                <ul class="nav sidebar-inner" id="sidebar-menu">



                    <li  class="has-sub active expand" >
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#dashboard"
                           aria-expanded="false" aria-controls="dashboard">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span class="nav-text">Dashboard</span> <b class="caret"></b>
                        </a>
                    </li>

                    <li  class="has-sub active expand" >
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#dashboard"
                           aria-expanded="false" aria-controls="dashboard">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span class="nav-text">Profile</span> <b class="caret"></b>
                        </a>
                    </li>

                    <li  class="has-sub active expand" >
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#dashboard"
                           aria-expanded="false" aria-controls="dashboard">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span class="nav-text">Setting</span> <b class="caret"></b>
                        </a>
                    </li>



                    <li  class="has-sub" >
                        <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#authentication"
                           aria-expanded="false" aria-controls="authentication">
                            <span class="nav-text">Authentication</span> <b class="caret"></b>
                        </a>
                        <ul  class="collapse"  id="authentication">
                            <div class="sub-menu">

                                <li >
                                    <a href="sign-in.html">Sign In</a>
                                </li>

                                <li >
                                    <a href="sign-up.html">Sign Up</a>
                                </li>

                            </div>
                        </ul>
                    </li>


                </ul>

            </div>

            <hr class="separator" />

        </div>
    </aside>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCn8TFXGg17HAUcNpkwtxxyT9Io9B_NcM" defer></script>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/toaster/toastr.min.js"></script>
    <script src="assets/plugins/slimscrollbar/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/charts/Chart.min.js"></script>
    <script src="assets/plugins/ladda/spin.min.js"></script>
    <script src="assets/plugins/ladda/ladda.min.js"></script>
    <script src="assets/plugins/jquery-mask-input/jquery.mask.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
    <script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>
    <script src="assets/plugins/daterangepicker/moment.min.js"></script>
    <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="assets/plugins/jekyll-search.min.js"></script>
    <script src="assets/js/sleek.js"></script>
    <script src="assets/js/chart.js"></script>
    <script src="assets/js/date-range.js"></script>
    <script src="assets/js/map.js"></script>
    <script src="assets/js/custom.js"></script>


</div>
</body>
