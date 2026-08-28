<?php
global $pg;
$pg = 3;
?>
<?php
include("header.php");
?>
<section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
    <div class="container">
        <?php
        $sql = "select subplace_name from tbl_subplace where isdeleted = 0 and subplace_id='" . $_REQUEST['subplace_id'] . "' ";
        $result = db_query($con, $sql);
        while ($row = db_fetch_array($result)) {
            ?>
            <div class="text-left breadcrumbs-item"><a href="index.php">home</a><i>/</i><a href="destinations.php">All
                    Destination</a><i>/</i><a href=""
                                              class="last"><span>Place</span> <?php echo $row['subplace_name']; ?>
                </a>
                <h2><span>Place</span> <?php echo $row['subplace_name']; ?></h2>
            </div>
            <?php
        }
        ?>
    </div>
</section>


<div class="content-body">
    <div class="container page">
        <div class="row">

            <div class="col-md-8">
                <div class="main single-product">
                    <form method="post" action="#">
                        <?php
                        include("config.php");
                        ?>

                        <?php
                        $sql = "select pl.place_name,lgn.* from tbl_subplace lgn INNER JOIN tbl_place pl ON pl.place_id=lgn.place_id where lgn.isdeleted = 0 and subplace_id='" . $_REQUEST['subplace_id'] . "' ";
                        $result = db_query($con, $sql);
                        while ($row = db_fetch_array($result))
                        {
                        $Path = "subplace/" . $row['upload_pic1'];
                        ?>


                        <div class="images">

                            <a href="./admin/subplace/<?php echo $row['upload_pic1']; ?>" class="fancy">
                                <div class="pic">
                                    <?php echo "<img src='./admin/subplace/$row[5]'style='height:230px;width:auto;'>" ?>
                                    <div class="links"><i class="fa fa-expand"></i></div>
                                </div>
                            </a>
                            <div class="thumbnails clearfix">
                                <a
                                        href="./admin/subplace/<?php echo $row['upload_pic1']; ?>" class="fancy">

                                    <div class="pic thumbnail">
                                        <?php echo "<img src='./admin/subplace/$row[5]'style='height:60px;width:auto;'>" ?>
                                        <div class="links"><i class="fa fa-expand"></i></div>
                                    </div>
                                </a> <a
                                        href="./admin/subplace/<?php echo $row['upload_pic2']; ?>" class="fancy">

                                    <div class="pic thumbnail">
                                        <?php echo "<img src='./admin/subplace/$row[6]'style='height:60px;width:auto;'>" ?>
                                        <div class="links"><i class="fa fa-expand"></i></div>
                                    </div>
                                </a> <a
                                        href="./admin/subplace/<?php echo $row['upload_pic3']; ?>" class="fancy">

                                    <div class="pic thumbnail">
                                        <?php echo "<img src='./admin/subplace/$row[7]'style='height:60px;width:auto;'>" ?>
                                        <div class="links"><i class="fa fa-expand"></i></div>
                                    </div>
                                </a></div>

                        </div>


                        <div class="summary clearfix">

                            <h2 class="product-title mt-0">
                                <?php echo $row['subplace_name']; ?></h2>


                            <div class="cws_divider mb-10" style="margin-top:20px;margin-bottom:20px;"></div>
                            <p class="description-product" style="font-size:18px;">

                                Here Explore India Holiday team provide you the detailed and helpful information
                                about selected place.</p>
                            <div class="price-review"><a
                                        href="<?php echo h(auth_cta_url('user/rating.php?type=destination&item_id=' . $row['subplace_id'])); ?>"
                                        class="cws-button alt mb-20" style="font-size:18px;">Rate Now</a>

                            </div>
                            <div class="mb-0 mt-10 category-line" style="font-size:18px;">State: <a
                                        href="#"><?php echo $row['place_name']; ?></a></div>
                            <div class="mb-0 post-number" style="font-size:18px;">City: <span><a
                                            href="#"><?php echo $row['city']; ?></a></span></div>

                        </div>


                        <div class="tabs mt-30 mb-50" style="font-size:18px;">
                            <div class="block-tabs-btn clearfix">
                                <div data-tabs-id="tabs1" class="tabs-btn active">Description</div>
                                <div data-tabs-id="tabs2" class="tabs-btn">Tagline</div>
                                <div data-tabs-id="tabs3" class="tabs-btn">How to reach</div>
                                <div data-tabs-id="tabs4" class="tabs-btn">What's great</div>
                                <div data-tabs-id="tabs5" class="tabs-btn">Local food</div>
                            </div>

                            <div class="tabs-keeper" style="height:125px;">

                                <div data-tabs-id="cont-tabs1" class="container-tabs active">
                                    <p><?php echo $row['subplace_des']; ?></p>
                                </div>


                                <div data-tabs-id="cont-tabs2" class="container-tabs">
                                    <p><?php echo $row['tag_line']; ?></p>
                                </div>


                                <div data-tabs-id="cont-tabs3" class="container-tabs">
                                    <p><?php echo $row['modes_transport']; ?></p>
                                </div>


                                <div data-tabs-id="cont-tabs4" class="container-tabs">
                                    <p><?php echo $row['whats_great']; ?></p>
                                </div>


                                <div data-tabs-id="cont-tabs5" class="container-tabs">
                                    <p><?php echo $row['local_food']; ?></p>
                                </div>

                            </div>

                        </div>

                </div>
                <?php
                }
                ?>
                </form>
                    
