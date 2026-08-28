<?php
global $pg;
$pg = 1;
?>
<?php
include("header.php");
?>

<?php

include_once('Converter.php');

$converter = new Converter();

$rates = $converter->getRates();

?>
<section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
    <div class="container">
        <div class="text-left breadcrumbs-item"><a href="index.php">home</a><i>/</i><a href="" class="last"><span>Currency</span>
                Converter</a>
            <h2><span>Currency</span> Converter</h2>
        </div>
    </div>
</section>
<br/><br/>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4 class="trans-uppercase mb-10">Currency convertor</h4>
            <div class="cws_divider mb-30"></div>
        </div>
    </div>
    <div class="review-content pattern relative">
        <div class="row">
            <h5 class="trans-uppercase mb-10" style="color:#444444;text-align:center;margin-bottom:30px;">welcome
                to<span style="color:#ffc107;
          text-transform:none;"> Currency Convertor</span></h4>
        </div>

        <form class="form clearfix" method="POST" action="getconvert.php" style="color:#444444;">
            <div class="row">
                <div class="col-md-4">
                    <label>Enter Amount:</label>
                    <input type="text" name="amount" size="40" aria-required="true" class="form-row form-row-first"
                           required/>
                </div>
                <div class="col-md-4">
                    <label>From:</label>
                    <select name="currency_from" aria-required="true" class="form-row form-row-first">
                        <?php
                        foreach ($rates as $key => $currency) {
                            ?>
                            <option value="<?php echo $key; ?>"><?php echo $key ?></option>
                            <?php
                        }

                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>To:</label>
                    <select name="currency_to" aria-required="true" class="form-row form-row-first">
                        <?php
                        foreach ($rates as $key => $currency) {
                            ?>
                            <option value="<?php echo $key; ?>"><?php echo $key ?></option>
                            <?php
                        }

                        ?>
                    </select>
                </div>
                <div class="col-md-6">

                    <input type="submit" name="convert" value="Convert" class="cws-button alt float-right">
                </div>
                <?php
                if (isset($_SESSION['value'])) {
                    ?>
                    <div class="col-md-6">

                        <input type="submit" name="convert" class="cws-button alt float-right" value="
                  <?php
                        echo $_SESSION['value']['amount'] . ' ' . $_SESSION['value']['from'] . ' is equal to ' . $_SESSION['value']['result'] . ' ' . $_SESSION['value']['to'];
                        ?>
                " style="margin-right:100px;"></div>
                    <?php
                    unset($_SESSION['value']);
                }
                ?>
            </div>
        </form>

    </div>

</div>
<br/><br/>
<?php
include("footer.php");
?>
