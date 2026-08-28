<?php
global $pg;
$pg = 7;
?>
<?php
include("header.php");
?>
<section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs"
         style="margin-bottom:0px;">
    <div class="container">
        <div class="text-left breadcrumbs-item"><a href="index">home</a><i>/</i><a href="" class="last"><span>All</span>
                Tour Guides</a>
            <h2><span>All</span> Tour Guides</h2>
        </div>
    </div>
</section>


<section class="small-section cws_prlx_section bg-blue-40" style="margin-top:-2px;"><img
            src="assets/site/pic/parallax-2.jpg" alt class="cws_prlx_layer">
    <div class="container">
        <div class="row">
            <div class="col-md-8" style="margin-top:-70px;">
                <h6 class="title-section-top font-4">Explore</h6>
                <h2 class="title-section alt-2"><?php echo cms_text('guides', 'intro', 'title', 'Tour Guides'); ?></h2>
                <div class="cws_divider mb-25 mt-5"></div>
                <p><?php echo cms_text('guides', 'intro'); ?></p>
            </div>
        </div>
        <div class="row">

            <div class="owl-three-item">

                <?php
                if (isset($_REQUEST['start']))
                    $startno = $_REQUEST['start'];
                else
                    $startno = 0;

                $pagesize = 4;
                $i = 0;
                $pageno = 1;
                $SqlQuery = "select pl.upload_pic1,lgn.* from tbl_tourguide lgn INNER JOIN tbl_subplace pl ON pl.subplace_id=lgn.subplace_id LIMIT $startno,1";
                $SqlQuery1 = "select pl.upload_pic1,lgn.* from tbl_tourguide lgn INNER JOIN tbl_subplace pl ON pl.subplace_id=lgn.subplace_id where lgn.isdeleted=0";

                $SqlQueryRun = db_query($con, $SqlQuery);
                $SqlQueryRun1 = db_query($con, $SqlQuery1);

                $total_rows = db_num_rows($SqlQueryRun1);
                ?>

                <form method="post">
                    <?php
                    while ($rows = db_fetch_array($SqlQueryRun)) {
                        $i++;
                        ?>


                        <div class="testimonial-item">
                            <div class="testimonial-top"><a
                                        href="guide.php?guide_id=<?php echo $rows['guide_id']; ?>">
                                    <div class="pic">
                                        <?php echo "<img src='./admin/subplace/$rows[0]'style='height:180px;width:370px;'>" ?></div>
                                </a>
                                <div class="author">
                                    <?php echo "<img src='./admin/tourguide/$rows[4]'style='height:120px;width:120px;'>" ?></div>
                            </div>

                            <div class="testimonial-body">
                                <h5 class="title"><span><?php echo $rows['guide_name']; ?></span></h5>
                                <div class="stars stars-<?php echo round($rows['guide_rate']); ?>"></div>
                                <p class="align-center">Here the best tour guide provide by explore india holiday.</p><a
                                        href="guide.php?guide_id=<?php echo $rows['guide_id']; ?>"
                                        class="testimonial-button">Read more</a>
                            </div>
                        </div>
                        <?php
                    }
                    ?></form>
                <?php
                if (isset($_REQUEST['start']))
                    $startno1 = $_REQUEST['start'] + 1;
                else
                    $startno1 = $startno + 1;

                $i = 0;
                $pageno = 1;
                $SqlQuery = "select pl.upload_pic1,lgn.* from tbl_tourguide lgn INNER JOIN tbl_subplace pl ON pl.subplace_id=lgn.subplace_id LIMIT $startno1,1";
                $SqlQuery1 = "select pl.upload_pic1,lgn.* from tbl_tourguide lgn INNER JOIN tbl_subplace pl ON pl.subplace_id=lgn.subplace_id where lgn.isdeleted=0";

                $SqlQueryRun = db_query($con, $SqlQuery);
                $SqlQueryRun1 = db_query($con, $SqlQuery1);

                $total_rows = db_num_rows($SqlQueryRun1);
                ?>

                <form method="post">
                    <?php
                    while ($rows = db_fetch_array($SqlQueryRun)) {
                        $i++;
                        ?>


                        <div class="testimonial-item">
                            <div class="testimonial-top"><a
                                        href="guide.php?guide_id=<?php echo $rows['guide_id']; ?>">
                                    <div class="pic">
                                        <?php echo "<img src='./admin/subplace/$rows[0]'style='height:180px;width:370px;'>" ?></div>
                                </a>
                                <div class="author">
                                    <?php echo "<img src='./admin/tourguide/$rows[4]'style='height:120px;width:120px;'>" ?></div>
                            </div>

                            <div class="testimonial-body">
                                <h5 class="title"><span><?php echo $rows['guide_name']; ?></span></h5>
                                <div class="stars stars-<?php echo round($rows['guide_rate']); ?>"></div>
                                <p class="align-center">Here the best tour guide provide by explore india holiday.</p><a
                                        href="guide.php?guide_id=<?php echo $rows['guide_id']; ?>"
                                        class="testimonial-button">Read more</a>
                            </div>
                        </div>
                        <?php
                    }
                    ?></form>
                <?php
                if (isset($_REQUEST['start']))
                    $startno1 = $_REQUEST['start'] + 2;
                else
                    $startno1 = $startno + 2;

                $i = 0;
                $pageno = 1;
                $SqlQuery = "select pl.upload_pic1,lgn.* from tbl_tourguide lgn INNER JOIN tbl_subplace pl ON pl.subplace_id=lgn.subplace_id LIMIT $startno1,1";
                $SqlQuery1 = "select pl.upload_pic1,lgn.* from tbl_tourguide lgn INNER JOIN tbl_subplace pl ON pl.subplace_id=lgn.subplace_id where lgn.isdeleted=0";

                $SqlQueryRun = db_query($con, $SqlQuery);
                $SqlQueryRun1 = db_query($con, $SqlQuery1);

                $total_rows = db_num_rows($SqlQueryRun1);
                ?>

                <form method="post">
                    <?php
                    while ($rows = db_fetch_array($SqlQueryRun)) {
                        $i++;
                        ?>


                        <div class="testimonial-item">
                            <div class="testimonial-top"><a
                                        href="guide.php?guide_id=<?php echo $rows['guide_id']; ?>">
                                    <div class="pic">
                                        <?php echo "<img src='./admin/subplace/$rows[0]'style='height:180px;width:370px;'>" ?></div>
                                </a>
                                <div class="author">
                                    <?php echo "<img src='./admin/tourguide/$rows[4]'style='height:120px;width:120px;'>" ?></div>
                            </div>

                            <div class="testimonial-body">
                                <h5 class="title"><span><?php echo $rows['guide_name']; ?></span></h5>
                                <div class="stars stars-<?php echo round($rows['guide_rate']); ?>"></div>
                                <p class="align-center">Here the best tour guide provide by explore india holiday.</p><a
                                        href="guide.php?guide_id=<?php echo $rows['guide_id']; ?>"
                                        class="testimonial-button">Read more</a>
                            </div>
                        </div>
                        <?php
                    }
                    ?></form>
                <?php
                if (isset($_REQUEST['start']))
                    $startno1 = $_REQUEST['start'] + 3;
                else
                    $startno1 = $startno + 3;

                $i = 0;
                $pageno = 1;
                $SqlQuery = "select pl.upload_pic1,lgn.* from tbl_tourguide lgn INNER JOIN tbl_subplace pl ON pl.subplace_id=lgn.subplace_id LIMIT $startno1,1";
                $SqlQuery1 = "select pl.upload_pic1,lgn.* from tbl_tourguide lgn INNER JOIN tbl_subplace pl ON pl.subplace_id=lgn.subplace_id where lgn.isdeleted=0";

                $SqlQueryRun = db_query($con, $SqlQuery);
                $SqlQueryRun1 = db_query($con, $SqlQuery1);

                $total_rows = db_num_rows($SqlQueryRun1);
                ?>

                <form method="post">
                    <?php
                    while ($rows = db_fetch_array($SqlQueryRun)) {
                        $i++;
                        ?>

                        <div class="testimonial-item">
                            <div class="testimonial-top"><a
                                        href="guide.php?guide_id=<?php echo $rows['guide_id']; ?>">
                                    <div class="pic">
                                        <?php echo "<img src='./admin/subplace/$rows[0]'style='height:180px;width:370px;'>" ?></div>
                                </a>
                                <div class="author">
                                    <?php echo "<img src='./admin/tourguide/$rows[4]'style='height:120px;width:120px;'>" ?></div>
                            </div>

                            <div class="testimonial-body">
                                <h5 class="title"><span><?php echo $rows['guide_name']; ?></span></h5>
                                <div class="stars stars-<?php echo round($rows['guide_rate']); ?>"></div>
                                <p class="align-center">Here the best tour guide provide by explore india holiday.</p><a
                                        href="guide.php?guide_id=<?php echo $rows['guide_id']; ?>"
                                        class="testimonial-button">Read more</a>
                            </div>
                        </div>
                        <?php
                    }
                    ?></form>


            </div>
        </div>


        <br/><br/>
        <div class="row mt-20" style="margin-bottom:-50px;">
            <nav class="text-center">
                <ul class="pagination mt-0 mb-0">
                    <li><a href='guides.php?start=0' style="width:40px;">First</a></li>

                    <?php
                    for ($j = 0; $j < $total_rows; $j = $j + $pagesize) {
                        if ($startno == $j) {
                            ?>
                            <li><a class="active"><?php echo $pageno; ?></a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href='guides.php?start=<?php echo $j; ?>'><?php echo $pageno; ?></a></li>
                            <?php
                        }
                        $pageno++;
                    }
                    ?>


                    <li><a href='guides.php?start=<?php echo $j - $pagesize; ?>' style="width:40px;">Last</a></li>
                </ul>
            </nav>
        </div>


    </div>
</section>


<?php
include("footer.php");
?>
