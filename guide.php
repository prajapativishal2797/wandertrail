<?php
global $pg;
$pg = 7;
?>
<?php
include("header.php");
?>
<section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
    <div class="container">
        <div class="text-left breadcrumbs-item"><a href="index.php">home</a><i>/</i><a href="" class="last"><span>Tour Guide</span>
                Information</a>
            <h2><span>Tour Guide</span> Information</h2>
        </div>
    </div>
</section>

<section class="page-section pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="title-section"><span>Tour</span> Guide</h2>
                <div class="cws_divider mb-25 mt-5"></div>
            </div>
        </div>
    </div>
</section>


<div class="content-body" style="margin-top:-180px;">

    <section class="page-section pb-40">
        <div class="container clearfix">


            <?php
            include("config.php");
            ?>

            <?php
            global $guide_id, $guide_email, $gudie_name;
            $requestedGuideId = request_int('guide_id');
            $sql = "select pl.subplace_name,lgn.* from tbl_tourguide lgn INNER JOIN tbl_subplace pl ON pl.subplace_id=lgn.subplace_id where lgn.isdeleted = 0 and guide_id=?";
            $result = db_query($con, $sql, [$requestedGuideId]);
            while ($row = db_fetch_array($result))
            {
            $Path = "./admin/tourguide/" . $row['guide_image'];
            $guide_id = $requestedGuideId;
            $subplace_name = $row['subplace_name'];
            $guide_email = $row['guide_email'];
            $guide_name = $row['guide_name'];
            $guide_contact = $row['guide_contact'];
            $language_known = $row['language_known'];
            $guide_rate = $row['guide_rate'];
            ?>
            <form method="POST">
                <div class="pic img-float-left"><img src="<?php echo $Path ?>" style="height:300px;width:300px;" alt>
                    <div class="hover-effect alt"></div>
                    <div class="links"><a href="assets/site/pic/team/350x350-1%402x.jpg"
                                          class="link-icon alt flaticon-interface fancy"></a><a href="#"
                                                                                                class="link-icon alt flaticon-tool"></a>
                    </div>
                </div>

                <div class="overflow-h">

                    <h2 class="title-section mt-10 mb-20 mt-md-0"><span><?php echo e($guide_name); ?></span></h2>
                    <?= favorite_button($con, 'guide', (int)$guide_id, 'guide.php?guide_id=' . (int)$guide_id) ?>


                    <ul class="style-2 mb-30" style="font-size:16px;">
                        <li><b>Work Place :</b> <?php echo $subplace_name; ?></li>
                        <li><b>Contact Number :</b> <?php echo $guide_contact; ?></li>
                        <li><b>Languages Known :</b> <?php echo $language_known; ?></li>
                        <li><b>Guide Rating :</b>
                            <div class="stars stars-<?php echo $row['guide_rate']; ?>"></div>
                        </li>
                    </ul>
                    <p class="post-info"><a
                                href="enquiry.php?type=general&reference_id=<?php echo (int)$guide_id; ?>"
                                class="cws-button alt mb-20">Contact this guide</a></p>


                    <?php
                    }
                    ?>


                </div>
            </form>


        </div>

    </section>
</div>
<?php
include("footer.php");
?>
