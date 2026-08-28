<?php

ob_start();
require_once __DIR__ . '/../includes/session_bootstrap.php';
require_once __DIR__ . '/../includes/auth.php';
require_login('../login.php', 'admin');
?>


<!DOCTYPE HTML>
<html>
<head>
    <title>WanderTrail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="Glance Design Dashboard Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design"/>
    <script type="application/x-javascript"> addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        } </script>


    <link rel="icon" href="../assets/admin/images/favicon.ico">


    <link href="../assets/admin/css/bootstrap.css" rel='stylesheet' type='text/css'/>


    <link href="../assets/admin/css/style.css" rel='stylesheet' type='text/css'/>


    <link href="../assets/admin/css/font-awesome.css" rel="stylesheet">


    <link href='../assets/admin/css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>


    <script src="../assets/admin/js/jquery-1.11.1.min.js"></script>
    <script src="../assets/admin/js/modernizr.custom.js"></script>


    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext"
          rel="stylesheet">


    <script src="../assets/admin/js/Chart.js"></script>


    <script src="../assets/admin/js/metisMenu.min.js"></script>
    <script src="../assets/admin/js/custom.js"></script>
    <link href="../assets/admin/css/custom.css" rel="stylesheet">
    <link href="../assets/site/css/eg-tokens.css?v=20260817-1" rel="stylesheet">
    <link href="../assets/site/css/eg-ui.css?v=20260817-1" rel="stylesheet">

    <style>
        #chartdiv {
            width: 100%;
            height: 295px;
        }
    </style>

    <script src="../assets/admin/js/pie-chart.js" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#demo-pie-1').pieChart({
                barColor: '#2dde98',
                trackColor: '#eee',
                lineCap: 'round',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-2').pieChart({
                barColor: '#8e43e7',
                trackColor: '#eee',
                lineCap: 'butt',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-3').pieChart({
                barColor: '#ffc168',
                trackColor: '#eee',
                lineCap: 'square',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });


        });

    </script>


    <link href="../assets/admin/css/owl.carousel.css" rel="stylesheet">
    <script src="../assets/admin/js/owl.carousel.js"></script>
    <script>
        $(document).ready(function () {
            $("#owl-demo").owlCarousel({
                items: 3,
                lazyLoad: true,
                autoPlay: true,
                pagination: true,
                nav: true,
            });
        });
    </script>

</head>
<body class="cbp-spmenu-push">
<div class="main-content">
    <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">

        <aside class="sidebar-left">
            <nav class="navbar navbar-inverse">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse"
                            aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <h1><a class="navbar-brand" href="index.php"><span class="fa fa-map-marker"></span> Wander<span
                                    class="dashboard_text">Trail</span></a></h1>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="treeview">
                            <a href="index.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>


                        <li class="treeview">
                            <a href="manageuser.php">
                                <i class="fa fa-user"></i> <span>Active User</span>
                            </a>
                        </li>


                        <li class="treeview">
                            <a href="place.php">
                                <i class="fa fa-suitcase"></i> <span>Manage Place</span>
                            </a>
                        </li>

                        <li class="treeview">
                            <a href="subplace.php">
                                <i class="fa fa-tripadvisor"></i> <span>Manage Sub Place</span>
                            </a>
                        </li>

                        <li class="treeview">
                            <a href="content.php">
                                <i class="fa fa-edit"></i> <span>Manage Page Content</span>
                            </a>
                        </li>


                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bed"></i>
                                <span>Manage Hotel</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="hotel.php"><i class="fa fa-angle-right"></i>Manage Hotel</a></li>
                                <li><a href="hotelbooking.php"><i class="fa fa-angle-right"></i>Manage Booking</a></li>
                                <li><a href="hotelpayment.php"><i class="fa fa-angle-right"></i>manage payment</a></li>
                            </ul>
                        </li>


                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-hourglass-half"></i>
                                <span>Manage Package</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="package.php"><i class="fa fa-angle-right"></i>Manage Package</a></li>
                                <li><a href="booking.php"><i class="fa fa-angle-right"></i>Manage Booking</a></li>
                                <li><a href="packagepayment.php"><i class="fa fa-angle-right"></i>Package payment</a>
                                </li>
                            </ul>
                        </li>


                        <li class="treeview">
                            <a href="feedback.php">
                                <i class="fa fa-comments"></i><span>Manage Feedback</span>
                            </a>
                        </li>

                        <li class="treeview">
                            <a href="rate.php">
                                <i class="fa fa-star"></i><span>Manage rating</span>
                            </a>
                        </li>


                </div>

            </nav>
        </aside>
    </div>
