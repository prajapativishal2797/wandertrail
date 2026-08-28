<?php
include("sidebar.php");
include("header.php");

?>

<?php
include("config.php");


if (isset($_GET['package_id'])) {
    $package_id = $_GET['package_id'];
    $sql = "select * from tbl_package where isdeleted=0 and package_id='$package_id'";
    $result = db_query($con, $sql);
    while ($row = db_fetch_array($result)) {
        $package_name = $row['package_name'];
        $package_img = $row['package_img'];
        $package_duration = $row['package_duration'];
        $package_des = $row['package_des'];
        $package_startprice = $row['package_startprice'];
        $package_type = $row['package_type'];
        $place_id = $row['place_id'];
        $hotel_id = $row['hotel_id'];
        $package_rate = $row['package_rate'];

    }
}
?>



    <div id="page-wrapper">
    <div class="main-page">
    <div class="forms">
    <h2 class="title1">Package</h2>
    <div class="form-grids row widget-shadow" data-example-id="basic-forms">
        <div class="form-title">
            <h4>Insert Package:</h4>
        </div>


        <div class="form-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputEmail1">Package Name</label>
                    <input type="text" class="form-control" name="package_name" id="exampleInputEmail1"
                           value="<?php echo $package_name; ?>">
                </div>


                <div class="form-group">
                    <label for="exampleInputFile">Package image</label>
                    <img src="package/<?php echo $package_img; ?>"
                         style="height:100px;width:120px;display:inline;margin-right:20px;float:left;"/><br/><br/><input
                            type="file" name="package_img" id="package_img" style="float:left;"/></td>
                    <input type="hidden" name="package_img" id="package_img"
                           value="<?php if (isset($_SERVER['PHP_SELF'])) {
                               echo $package_img;
                           } ?>"/>

                </div>


                <br/>


                <div class="form-group">
                    <label for="exampleInputEmail1">Package Duration</label>
                    <input type="text" class="form-control" name="package_duration" id="exampleInputEmail1"
                           value="<?php echo $package_duration; ?>">
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">Package Description</label>
                    <input type="text" class="form-control" name="package_des" id="exampleInputEmail1"
                           value="<?php echo $package_des; ?>">
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">Package starting price</label>
                    <input type="text" class="form-control" name="package_startprice" id="exampleInputEmail1"
                           value="<?php echo $package_startprice; ?>">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Package Type</label>
                    <input type="text" class="form-control" name="package_type" id="exampleInputEmail1"
                           value="<?php echo $package_type; ?>">
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">Place Name</label>


                    <select name="place_id">
                        <option value="0">Select Place Name</option>
                        <?php
                        include("config.php");

                        $sql1 = "select * from tbl_place where isdeleted=0";
                        $result1 = db_query($con, $sql1);
                        while ($row = db_fetch_array($result1)) {
                            echo "<option value = '$row[0]'>$row[1]</option>";
                        }

                        ?>
                    </select>


                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">Hotel Name</label>


                    <select name="hotel_id">
                        <option value="0">Select Hotel Name</option>
                        <?php
                        include("config.php");

                        $sql1 = "select * from tbl_hotel where isdeleted=0";
                        $result1 = db_query($con, $sql1);
                        while ($row = db_fetch_array($result1)) {
                            echo "<option value = '$row[0]'>$row[1]</option>";
                        }

                        ?>
                    </select>


                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">package rate</label>
                    <input type="text" class="form-control" name="package_rate" id="exampleInputEmail1"
                           value="<?php echo $package_rate; ?>">
                </div>


                <button type="submit" class="btn btn-default" name="updatepackage">Submit</button>
            </form>
        </div>
    </div>


<?php

if (isset($_POST['updatepackage'])) {
    if ($_POST['updatepackage'] == 0) {

        $package_name = $_POST['package_name'];

        $package_img = trim($_FILES['package_img']['name']);


        if ($_FILES["package_img"]["name"] == '') {
            $package_img = $_POST['package_img'];
        } else {
            $package_img = $_FILES['package_img']['name'];
        }
        move_uploaded_file($package_img, 'package/' . $package_img);


        $package_duration = $_POST['package_duration'];
        $package_des = $_POST['package_des'];
        $package_startprice = $_POST['package_startprice'];
        $place_id = $_POST['place_id'];
        $package_rate = $_POST['package_rate'];


        $sql = "update tbl_package set package_name='$package_name',package_img='$package_img',package_duration='$package_duration',package_des='$package_des',package_startprice='$package_startprice',place_id='$place_id',package_rate='$package_rate' where isdeleted=0 and package_id='$package_id'";

        $result = db_query($con, $sql);
        if ($result) {
            echo "<script language='javascript'>alert('Package  edited successfully');</script>";
            echo "<script>window.location.href='package.php'</script>";

        }
    }
}

?>


<?php
include("footer.php");


?>