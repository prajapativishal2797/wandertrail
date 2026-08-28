<?php
include("sidebar.php");
include("header.php");

?>

<?php
include("config.php");
$query1 = "select * from tbl_hotel where isdeleted=0";
$result1 = db_query($con, $query1);
$count = db_num_rows($result1);


$query1 = "select * from tbl_package where isdeleted=0";
$result1 = db_query($con, $query1);
$count1 = db_num_rows($result1);


$query1 = "select * from tbl_feedback where isdeleted=0";
$result1 = db_query($con, $query1);
$count2 = db_num_rows($result1);


$query10 = "select * from tbl_subplace where isdeleted=0";
$result20 = db_query($con, $query10);
$count5 = db_num_rows($result20);

$query1 = "select * from tbl_register where isdeleted=0";
$result1 = db_query($con, $query1);
$count4 = db_num_rows($result1);

?>


<div id="page-wrapper">
    <div class="main-page">
        <div class="col_3">
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-dollar icon-rounded"></i>
                    <div class="stats">
                        <h5><strong><?php echo $count; ?></strong></h5>
                        <span>Total Hotel</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-laptop user1 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong><?php echo $count1; ?></strong></h5>
                        <span>Total Package</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-money user2 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong><?php echo $count5; ?></strong></h5>
                        <span>Feedback</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget widget1">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-pie-chart dollar1 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong><?php echo $count2; ?></strong></h5>
                        <span>Subplace</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 widget">
                <div class="r3_counter_box">
                    <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                    <div class="stats">
                        <h5><strong><?php echo $count4; ?></strong></h5>
                        <span>Total Users</span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>


        <script src="../assets/admin/js/amcharts.js"></script>
        <script src="../assets/admin/js/serial.js"></script>
        <script src="../assets/admin/js/export.min.js"></script>
        <link rel="stylesheet" href="../assets/admin/css/export.css" type="text/css" media="all"/>
        <script src="../assets/admin/js/light.js"></script>


        <script src="../assets/admin/js/index1.js"></script>

        <div class="charts">
            <div class="mid-content-top charts-grids">
                <div class="middle-content">
                    <h4 class="title">Welcome to the WanderTrail Admin Panel</h4>

                    <div id="owl-demo" class="owl-carousel text-center">
                        <div class="item">
                            <img class="lazyOwl img-responsive" data-src="../assets/admin/images/slider/slider1.jpg"
                                 alt="name">
                        </div>
                        <div class="item">
                            <img class="lazyOwl img-responsive" data-src="../assets/admin/images/slider/slider2.jpg"
                                 alt="name">
                        </div>
                        <div class="item">
                            <img class="lazyOwl img-responsive" data-src="../assets/admin/images/slider/slider3.jpg"
                                 alt="name">
                        </div>
                        <div class="item">
                            <img class="lazyOwl img-responsive" data-src="../assets/admin/images/slider/slider4.jpg"
                                 alt="name">
                        </div>
                        <div class="item">
                            <img class="lazyOwl img-responsive" data-src="../assets/admin/images/slider/slider5.jpg"
                                 alt="name">
                        </div>
                        <div class="item">
                            <img class="lazyOwl img-responsive" data-src="../assets/admin/images/slider/slider6.jpg"
                                 alt="name">
                        </div>
                        <div class="item">
                            <img class="lazyOwl img-responsive" data-src="../assets/admin/images/slider/slider7.jpg"
                                 alt="name">
                        </div>

                    </div>
                </div>

            </div>
        </div>


        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>

</div>

</div>
</div>

<?php
include("footer.php");
?>
