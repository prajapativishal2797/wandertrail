<?php
global $pg;
$pg = 6;
?>
<?php
include("header.php");
?>

    <section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
        <div class="container">
            <div class="text-left breadcrumbs-item"><a href="index.php">home</a><i>/</i><a href="" class="last"><span>Frequently</span>
                    Asked Questions</a>
                <h2><span>Frequently</span> Asked Questions</h2>
            </div>
        </div>
    </section>
    <br/><br/>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="trans-uppercase mb-10">Frequently Asked Questions</h4>
                <div class="cws_divider mb-30"></div>
            </div>
        </div>
    </div>


    <script src="assets/site/js/jquery-1.11.1.min.js"></script>


    <script type="text/javascript" src="assets/site/js/move-top.js"></script>
    <script type="text/javascript" src="assets/site/js/easing.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();
                $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1000);
            });
        });
    </script>


    <ul class="faq">
        <?php
        include("config.php");
        $sql = "select * from tbl_faq where isdeleted = 0 ORDER BY viewcount DESC ";
        $result = db_query($con, $sql);
        while ($row = db_fetch_array($result)) {
            $question = $row['faq_que'];
            $answer = $row['faq_ans'];

            ?>


            <li><a href="#" onclick="return viewcount(<?php echo $row["faq_id"]; ?>);" title="click here" class="item1"
                   style="font-size:18px; color:#444444; margin-left:70px; font-weight:bold; margin-right:65px;"><i
                            class="fa fa-question-circle" aria-hidden="true"></i> <?php echo $question; ?></a>
                <ul>
                    <li class="subitem1"><p
                                style="font-size:18px; color:#444444; margin-left:70px; margin-right:70px;"><?php echo $answer; ?></p>
                    </li>
                </ul>
            </li>


            <?php
        }
        ?>

        <script type="text/javascript">
            $(function () {

                var menu_ul = $('.faq > li > ul'),
                    menu_a = $('.faq > li > a');

                menu_ul.hide();

                menu_a.click(function (e) {
                    e.preventDefault();
                    if (!$(this).hasClass('active')) {
                        menu_a.removeClass('active');
                        menu_ul.filter(':visible').slideUp('normal');
                        $(this).addClass('active').next().stop(true, true).slideDown('normal');
                    } else {
                        $(this).removeClass('active');
                        $(this).next().stop(true, true).slideUp('normal');
                    }
                });

            });
        </script>
    </ul>

    </div>
    </div>
    <br/><br/>


    <script language="javascript">
        function viewcount(id) {

            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                }
            };
            xmlhttp.open("GET", "faq_viewcount_update.php?faqid=" + id, true);
            xmlhttp.send();

        }
    </script>

<?php
include("footer.php");
?>