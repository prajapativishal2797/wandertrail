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

    <style>
        #chartdiv {
            width: 100%;
            height: 295px;
        }
    </style>

    <script src="../assets/admin/js/pie-chart.js" type="text/javascript">
    </script>


    <link rel="shortcut icon" href="../assets/admin/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../assets/admin/images/favicon.ico" type="image/x-icon">


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
                    <h1><a class="navbar-brand" href="index.html"><span class="fa fa-area-chart"></span> Wander<span
                                    class="dashboard_text">Trail</span></a></h1>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li class="treeview">
                            <a href="index.html">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>


                        <li class="treeview">
                            <a href="place.php ">
                                <i class="fa fa-dashboard"></i> <span>Manage place</span>
                            </a>
                        </li>


                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>Components</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="grids.html"><i class="fa fa-angle-right"></i> Grids</a></li>
                                <li><a href="media.html"><i class="fa fa-angle-right"></i> Media Css</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="charts.html">
                                <i class="fa fa-pie-chart"></i>
                                <span>Charts</span>
                                <span class="label label-primary pull-right">new</span>
                            </a>
                        </li>
                        <li class="treeview">
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>UI Elements</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="general.html"><i class="fa fa-angle-right"></i> General</a></li>
                                <li><a href="icons.html"><i class="fa fa-angle-right"></i> Icons</a></li>
                                <li><a href="buttons.html"><i class="fa fa-angle-right"></i> Buttons</a></li>
                                <li><a href="typography.html"><i class="fa fa-angle-right"></i> Typography</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="widgets.html">
                                <i class="fa fa-th"></i> <span>Widgets</span>
                                <small class="label pull-right label-info">08</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Forms</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="forms.html"><i class="fa fa-angle-right"></i> General Forms</a></li>
                                <li><a href="validation.html"><i class="fa fa-angle-right"></i> Form Validations</a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Tables</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="tables.html"><i class="fa fa-angle-right"></i> Simple tables</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-envelope"></i> <span>Mailbox </span>
                                <i class="fa fa-angle-left pull-right"></i><small class="label pull-right label-info1">08</small><span
                                        class="label label-primary1 pull-right">02</span></a>
                            <ul class="treeview-menu">
                                <li><a href="inbox.html"><i class="fa fa-angle-right"></i> Mail Inbox </a></li>
                                <li><a href="compose.html"><i class="fa fa-angle-right"></i> Compose Mail </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Examples</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="login.html"><i class="fa fa-angle-right"></i> Login</a></li>
                                <li><a href="signup.html"><i class="fa fa-angle-right"></i> Register</a></li>
                                <li><a href="404.html"><i class="fa fa-angle-right"></i> 404 Error</a></li>
                                <li><a href="500.html"><i class="fa fa-angle-right"></i> 500 Error</a></li>
                                <li><a href="blank-page.html"><i class="fa fa-angle-right"></i> Blank Page</a></li>
                            </ul>
                        </li>

                    </ul>
                </div>

            </nav>
        </aside>
    </div>
