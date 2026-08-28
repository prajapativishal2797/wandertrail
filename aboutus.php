<?php
global $pg;
$pg = 2;
?>
<?php
include("header.php");
?>
<section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
    <div class="container">
        <div class="text-left breadcrumbs-item">
            <a href="index.php">home</a>
            <i>/</i>
            <a href="" class="last">
                <span>About</span>Us
            </a>
            <h2><span>About</span> Us</h2>
        </div>
    </div>
</section>


<div class="content-body">

    <section class="small-section cws_prlx_section bg-white-80 pb-0">
        <img src="assets/site/pic/parallax-4.jpg" alt class="cws_prlx_layer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-md-60">

                    <h2 class="title-section-top alt gray">About</h2>
                    <h2 class="title-section alt gray mb-20 font-bold"><?php echo cms_text('about', 'intro', 'title', 'WanderTrail'); ?></h2>

                    <p class="mb-30" style="text-align:justify;"><?php echo cms_text('about', 'intro'); ?></p>
                    <div class="cws_divider short mb-30"></div>
                    <h3 class="font-medium font-5"></h3>
                </div>
                <div class="col-md-6 flex-item-end"><img src="assets/site/pic/promo-2.png" alt class="mt-minus-100">
                </div>
            </div>
        </div>
    </section>


    <section class="small-section">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-xs-6 mt-20 mb-80">
                            <div class="counter-block"><i class="counter-icon flaticon-suntour-world"></i>
                                <div class="counter-name-wrap">
                                    <?php
                                    include 'config.php';
                                    $query1 = "select * from tbl_package where isdeleted = 0";
                                    $result1 = db_query($con, $query1);
                                    $count1 = db_num_rows($result1);

                                    ?>
                                    <div data-count="<?php echo $count1; ?>" class="counter">0</div>
                                    <div class="counter-name">Tours</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 mt-20 mb-80">
                            <div class="counter-block"><i class="counter-icon flaticon-suntour-fireworks"></i>
                                <div class="counter-name-wrap">

                                    <?php
                                    include 'config.php';
                                    $query1 = "select * from tbl_subplace where isdeleted = 0";
                                    $result1 = db_query($con, $query1);
                                    $count1 = db_num_rows($result1);

                                    ?>
                                    <div data-count="<?php echo $count1; ?>" class="counter">0</div>
                                    <div class="counter-name">Holidays</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 mb-80">
                            <div class="counter-block"><i class="counter-icon flaticon-suntour-hotel"></i>
                                <div class="counter-name-wrap">
                                    <?php
                                    include 'config.php';
                                    $query1 = "select * from tbl_hotel where isdeleted = 0";
                                    $result1 = db_query($con, $query1);
                                    $count1 = db_num_rows($result1);

                                    ?>
                                    <div data-count="<?php echo $count1; ?>" class="counter">0</div>
                                    <div class="counter-name">Hotels</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 mb-80">
                            <div class="counter-block"><i class="counter-icon flaticon-suntour-ship"></i>
                                <div class="counter-name-wrap">
                                    <?php
                                    include 'config.php';
                                    $query1 = "select * from tbl_subplace where isdeleted = 0";
                                    $result1 = db_query($con, $query1);
                                    $count1 = db_num_rows($result1);

                                    ?>
                                    <div data-count="<?php echo $count1; ?>" class="counter">0</div>
                                    <div class="counter-name">Cruises</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="counter-block"><i class="counter-icon flaticon-suntour-airplane"></i>
                                <div class="counter-name-wrap">
                                    <?php
                                    include 'config.php';
                                    $query1 = "select * from tbl_subplace where isdeleted = 0";
                                    $result1 = db_query($con, $query1);
                                    $count1 = db_num_rows($result1);

                                    ?>
                                    <div data-count="<?php echo $count1; ?>" class="counter">0</div>
                                    <div class="counter-name">Flights</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="counter-block"><i class="counter-icon flaticon-suntour-car"></i>
                                <div class="counter-name-wrap">
                                    <?php
                                    include 'config.php';
                                    $query1 = "select * from tbl_subplace where isdeleted = 0";
                                    $result1 = db_query($con, $query1);
                                    $count1 = db_num_rows($result1);

                                    ?>
                                    <div data-count="<?php echo $count1; ?>" class="counter">0</div>
                                    <div class="counter-name">Cars</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 mt-md-40">
                    <div class="tabs">
                        <div class="block-tabs-btn clearfix">
                            <div data-tabs-id="tabs1" class="tabs-btn active">About us</div>
                            <div data-tabs-id="tabs2" class="tabs-btn">Our mission</div>
                            <div data-tabs-id="tabs3" class="tabs-btn">Our vision</div>
                        </div>

                        <div class="tabs-keeper">

                            <div data-tabs-id="cont-tabs1" class="container-tabs active" style="height:280px;">
                                <h6 class="trans-uppercase"><?php echo cms_text('about', 'about', 'title', 'About Us'); ?></h6>
                                <p style="text-align:justify;"><?php echo cms_text('about', 'about'); ?></p>

                            </div>


                            <div data-tabs-id="cont-tabs2" class="container-tabs" style="height:280px;">
                                <h6 class="trans-uppercase"><?php echo cms_text('about', 'mission', 'title', 'Our Mission'); ?></h6>
                                <p><?php echo cms_text('about', 'mission'); ?></p>

                            </div>


                            <div data-tabs-id="cont-tabs3" class="container-tabs" style="height:280px;">
                                <h6 class="trans-uppercase"><?php echo cms_text('about', 'vision', 'title', 'Our Vision'); ?></h6>
                                <p>Become the 1st leading ground operator in the region and our clients’ best partner,
                                    always providing the best possible product, with the highest quality of services,
                                    and demonstrating faithfully our commitment towards social and environmental
                                    responsibility.
                                    We are seeking for excellence in service and will provide quality service at a cost
                                    that will enable us to remain competitive.
                                    Aggressively solicit new and growing target groups.
                                    Expand our relationship with hotels and tour guides within India.</p>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    
    
    
