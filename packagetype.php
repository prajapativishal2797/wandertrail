<?php
global $pg;
$pg = 4;
?>
<?php
include("header.php");
?>
    <section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
        <div class="container">
            <div class="text-left breadcrumbs-item"><a href="index.php">home</a><i>/</i><a href="" class="last"><span>All</span>
                    Packages</a>
                <h2><span>All</span> Packages</h2>
            </div>
        </div>
    </section>


    <div class="content-body">
        <div class="container page">
            <div class="row">
                <div class="col-md-12">
                    <div class="row blog-col">
                        <div class="row mb-50" style="margin-bottom:10px;margin-left:2px;">
                            <div class="col-md-8">
                                <h6 class="title-section-top font-4">Explore</h6>
                                <h2 class="title-section alt-2" style="color:#444444;"><span style="color:#444444;">Attractive</span>
                                    Packages</h2>
                                <div class="cws_divider mb-25 mt-5"></div>

                            </div>
                        </div>

                        <?php
                        if (isset($_REQUEST['start']))
                            $startno = $_REQUEST['start'];
                        else
                            $startno = 0;

                        $pagesize = 4;
                        $i = 0;
                        $pageno = 1;
                        $SqlQuery = "select pl.place_name,lgn.* from tbl_package lgn INNER JOIN tbl_place pl ON pl.place_id=lgn.place_id where lgn.isdeleted=0 and lgn.package_type='" . $_REQUEST['type'] . "' LIMIT $startno,$pagesize";
                        $SqlQuery1 = "select pl.place_name,lgn.* from tbl_package lgn INNER JOIN tbl_place pl ON pl.place_id=lgn.place_id where lgn.isdeleted=0 and lgn.package_type='" . $_REQUEST['type'] . "'";

                        $SqlQueryRun = db_query($con, $SqlQuery);
                        $SqlQueryRun1 = db_query($con, $SqlQuery1);

                        $total_rows = db_num_rows($SqlQueryRun1);
                        ?>

                        <form method="post">
                            <?php
                            while ($rows = db_fetch_array($SqlQueryRun)) {
                                $i++;
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 mb-30" style="margin-bottom:10px;">

                                    <div class="blog-item clearfix border boxed" style="border-color:#eee;">

                                        <div class="blog-media"><a
                                                    href="package.php?package_id=<?php echo $rows['package_id']; ?>">
                                                <div class="pic">
                                                    <?php echo "<img src='./admin/package/$rows[3]'style='height:250px;width:300px;'>" ?></div>
                                            </a></div>

                                        <div class="blog-item-body clearfix">
                                            <a
                                                    href="package.php?package_id=<?php echo $rows['package_id']; ?>">
                                                <?php
                                                $pname = $rows['package_name'];
                                                if (strlen($pname) > 20)
                                                    $pname = substr($pname, 0, 20) . '...'; ?>
                                                <h6 class="blog-title"><?php echo $pname; ?></h6></a>
                                            <div class="blog-item-data"><?php echo $rows['package_duration']; ?></div>

                                            <?php
                                            $str = $rows['package_des'];
                                            if (strlen($str) > 70)
                                                $str = substr($str, 0, 70) . '...'; ?>
                                            <p style="text-align:justify;"><?php echo $str; ?></p><a
                                                    href="package.php?package_id=<?php echo $rows['package_id']; ?>"
                                                    class="blog-button">Read more</a>
                                        </div>
                                    </div>

                                </div>

                                <?php
                            }
                            ?>
                    </div>


                    <div class="row mt-20">
                        <nav class="text-center">
                            <ul class="pagination mt-0 mb-0">
                                <li><a href='packages.php?start=0' style="width:40px;">First</a></li>

                                <?php
                                for ($j = 0; $j < $total_rows; $j = $j + $pagesize) {
                                    if ($startno == $j) {
                                        ?>
                                        <li><a class="active"><?php echo $pageno; ?></a></li>
                                        <?php
                                    } else {
                                        ?>
                                        <li><a href='packages.php?start=<?php echo $j; ?>'><?php echo $pageno; ?></a>
                                        </li>
                                        <?php
                                    }
                                    $pageno++;
                                }
                                ?>


                                <li><a href='packages.php?start=<?php echo $j - $pagesize; ?>'
                                       style="width:40px;">Last</a>
                                </li>
                            </ul>
                        </nav>
                    </div>


                </div>
            </div>
        </div>
    </div>

<?php
include("footer.php");
?>