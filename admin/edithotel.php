<?php
include("sidebar.php");
include("header.php");

?>

<?php
include("config.php");
global $hotel_id, $hotel_name, $place_id, $hotel_des, $hotel_price, $hotel_image, $hotel_category, $hotel_address, $hotel_status, $airport_pickup, $car_parking, $extra_breakfast;

if (isset($_GET['hotel_id'])) {
    $hotel_id = $_GET['hotel_id'];
    $sql = "select * from tbl_hotel where isdeleted=0 and hotel_id='$hotel_id'";
    $result = db_query($con, $sql);
    while ($row = db_fetch_array($result)) {
        $hotel_name = $row['hotel_name'];
        $place_id = $row['place_id'];
        $hotel_des = $row['hotel_des'];
        $hotel_price = $row['hotel_price'];
        $hotel_image = $row['hotel_image'];
        $hotel_category = $row['hotel_category'];
        $hotel_address = $row['hotel_address'];
        $hotel_status = $row['hotel_status'];
        $airport_pickup = $row['airport_pickup'];
        $car_parking = $row['car_parking'];
        $extra_breakfast = $row['extra_breakfast'];

    }
}
?>


<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Hotel</h2>
            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Edit Hotel:</h4>
                </div>


                <div class="form-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hotel Name</label>
                            <input type="text" class="form-control" name="hotel_name" id="exampleInputEmail1"
                                   value="<?php echo $hotel_name; ?>">
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
                            <label for="exampleInputEmail1">hotel description</label>
                            <input type="text" class="form-control" name="hotel_des" id="exampleInputEmail1"
                                   value="<?php echo $hotel_des; ?>">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">hotel price</label>
                            <input type="text" class="form-control" name="hotel_price" id="exampleInputEmail1"
                                   value="<?php echo $hotel_price; ?>"">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputFile">Hotel image</label>
                            <img src="hotel/<?php echo $hotel_image; ?>"
                                 style="height:100px;width:120px;display:inline;margin-right:20px;float:left;"/><br/><br/><input
                                    type="file" name="hotel_image" id="hotel_image" style="float:left;"/>
                            <td><input type="hidden" name="hotel_image" id="hotel_image"
                                       value="<?php if (isset($_SERVER['PHP_SELF'])) {
                                           echo $hotel_image;
                                       } ?>"/>
                        </div>


                        <br/><br/><br/>

                        <div class="form-group">
                            <label for="exampleInputEmail1">hotel_category</label>
                            <input type="text" class="form-control" name="hotel_category" id="exampleInputEmail1"
                                   value="<?php echo $hotel_category; ?>">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">hotel_address</label>
                            <input type="text" class="form-control" name="hotel_address" id="exampleInputEmail1"
                                   value="<?php echo $hotel_address; ?>">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">hotel_status</label>
                            <input type="text" class="form-control" name="hotel_status" id="exampleInputEmail1"
                                   value="<?php echo $hotel_status; ?>">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">Airpot pick up</label>
                            <input type="text" class="form-control" name="airport_pickup" id="exampleInputEmail1"
                                   value="<?php echo $airport_pickup; ?>">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">car_parking</label>
                            <input type="text" class="form-control" name="car_parking" id="exampleInputEmail1"
                                   value="<?php echo $car_parking; ?>">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">Extra breakfast</label>
                            <input type="text" class="form-control" name="extra_breakfast" id="exampleInputEmail1"
                                   value="<?php echo $extra_breakfast; ?>">
                        </div>

                        <button type="submit" class="btn btn-default" name="update">Submit</button>
                    </form>
                </div>
            </div>


            <?php
            if (isset($_POST['update'])) {

                if ($_POST['update'] == 0) {


                    $hotel_name = $_POST['hotel_name'];
                    $place_id = $_POST['place_id'];
                    $hotel_des = $_POST['hotel_des'];
                    $hotel_price = $_POST['hotel_price'];
                    $hotel_image = trim($_FILES['hotel_image']['name']);


                    if ($_FILES["hotel_image"]["name"] == '') {
                        $hotel_image = $_POST['hotel_image'];
                    } else {
                        $hotel_image = $_FILES['hotel_image']['name'];
                    }
                    move_uploaded_file($hotel_image, 'hotel/' . $hotel_image);


                    $hotel_category = $_POST['hotel_category'];
                    $hotel_address = $_POST['hotel_address'];
                    $hotel_status = $_POST['hotel_status'];
                    $airport_pickup = $_POST['airport_pickup'];
                    $car_parking = $_POST['car_parking'];
                    $extra_breakfast = $_POST['extra_breakfast'];


                    if (($hotel_image == " ") && ($hotel_name == "")) {
                        echo "<script language = 'javascript'> alert('fill detail');</script>";
                    }


                    $sql = "update tbl_hotel set hotel_name='$hotel_name',place_id='$place_id',hotel_des='$hotel_des',hotel_price='$hotel_price',hotel_image='$hotel_image',hotel_category='$hotel_category',hotel_address='$hotel_address',hotel_status='$hotel_status',airport_pickup='$airport_pickup',car_parking='$car_parking',extra_breakfast='$extra_breakfast' where  hotel_id='$hotel_id'";

                    $result = db_query($con, $sql);
                    if ($result) {

                        echo "<script language='javascript'>alert('Hotel  edited successfully');</script>";
                        echo "<script>window.location.href='hotel.php'</script>";

                    }
                }
            }

            ?>


            <?php
            include("footer.php");


            ?>
