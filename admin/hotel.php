<?php
include("sidebar.php");
include("header.php");

?>


<?php
include("config.php");
if (isset($_POST['hotel'])) {

    $hotel_name = $_POST['hotel_name'];
    $place_id = $_POST['place_id'];
    $hotel_des = $_POST['hotel_des'];
    $hotel_price = $_POST['hotel_price'];
    $hotel_image = trim($_FILES['hotel_image']['name']);
    $hotel_category = $_POST['hotel_category'];
    $hotel_address = $_POST['hotel_address'];
    $airport_pickup = $_POST['airport_pickup'];
    $car_parking = $_POST['car_parking'];
    $extra_breakfast = $_POST['extra_breakfast'];


    $sql = "insert into tbl_hotel(hotel_name,place_id,hotel_des,hotel_price,hotel_image,hotel_category,hotel_address,hotel_status,airport_pickup,car_parking,extra_breakfast)value('$hotel_name','$place_id','$hotel_des','$hotel_price','$hotel_image','$hotel_category','$hotel_address','available','$airport_pickup','$car_parking','$extra_breakfast')";
    $result = db_query($con, $sql);
    if ($result) {
        echo "<script>alert('Hotel added succesfully');</script>";

    }
}
?>


<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Hotel</h2>
            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Insert Hotel:</h4>
                </div>


                <div class="form-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hotel Name</label>
                            <input type="text" class="form-control" name="hotel_name" id="exampleInputEmail1"
                                   placeholder="Hotel name">
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
                                   placeholder="Hotel description">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">hotel price</label>
                            <input type="text" class="form-control" name="hotel_price" id="exampleInputEmail1"
                                   placeholder="Hotel Price">
                        </div>


                        <?php
                        if (isset($_FILES['hotel_image'])) {
                            $file_name = $_FILES['hotel_image']['name'];
                            $file_tmp = $_FILES['hotel_image']['tmp_name'];
                            $file_size = $_FILES['hotel_image']['size'];
                            if ($_FILES['hotel_image']['size'] > 10526552) {
                                echo "<br>image size is greater";
                            } else {
                                if (move_uploaded_file($file_tmp, 'hotel/' . $file_name)) {

                                }
                            }
                        }
                        ?>

                        <div class="form-group">
                            <label for="exampleInputFile">Hotel image</label>
                            <input type="file" name="hotel_image" id="exampleInputFile">
                            <p class="help-block">Upload Image here</p>
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">hotel_category</label>
                            <input type="text" class="form-control" name="hotel_category" id="exampleInputEmail1"
                                   placeholder="Hotel category">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">hotel_address</label>
                            <input type="text" class="form-control" name="hotel_address" id="exampleInputEmail1"
                                   placeholder="Hotel address">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">hotel_status</label>
                            <input type="text" class="form-control" name="hotel_status" id="exampleInputEmail1"
                                   placeholder="status">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">Airpot pick up</label>
                            <input type="text" class="form-control" name="airport_pickup" id="exampleInputEmail1"
                                   placeholder="Airport pickup">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">car_parking</label>
                            <input type="text" class="form-control" name="car_parking" id="exampleInputEmail1"
                                   placeholder="car Parking">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">Extra breakfast</label>
                            <input type="text" class="form-control" name="extra_breakfast" id="exampleInputEmail1"
                                   placeholder="Extra breakfast">
                        </div>

                        <button type="submit" class="btn btn-default" name="hotel">Submit</button>
                    </form>
                </div>
            </div>


            <div class="bs-example widget-shadow" data-example-id="bordered-table">
                <h4>Manage Hotel:</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th> Name</th>
                        <th>place name</th>


                        <th>Desc</th>
                        <th>price</th>

                        <th>Image</th>
                        <th>category</th>

                        <th>Address</th>

                        <th>status</th>
                        <th>Airport pick up</th>
                        <th>car parking</th>

                        <th>Extra breakfast</th>


                        <th>delete</th>
                        <th>edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php
                        include("config.php");
                        $sql = "select pl.place_name,lgn.* from tbl_hotel lgn INNER JOIN tbl_place pl ON pl.place_id=lgn.place_id where lgn.isdeleted=0";
                        $result = db_query($con, $sql);

                        while ($rows = db_fetch_array($result))
                        {
                        ?>

                    <tr>
                        <td><?php echo $rows['hotel_name']; ?></td>
                        <td><?php echo $rows['place_name']; ?></td>
                        <td><?php echo $rows['hotel_des']; ?></td>
                        <td><?php echo $rows['hotel_price']; ?></td>
                        <td><img style="height:40px;width:40px;" src="hotel/<?php echo $rows['hotel_image']; ?>"></td>
                        <td><?php echo $rows['hotel_category']; ?></td>
                        <td><?php echo $rows['hotel_address']; ?></td>
                        <td><?php echo $rows['hotel_status']; ?></td>
                        <td><?php echo $rows['airport_pickup']; ?></td>
                        <td><?php echo $rows['car_parking']; ?></td>
                        <td><?php echo $rows['extra_breakfast']; ?></td>

                        <td><a href="hotel.php?hotel_id=<?php echo $rows['hotel_id']; ?>">
                                <img src="../assets/admin/images/delete.png"></a></td>


                        <td><a href="edithotel.php?hotel_id=<?php echo $rows['hotel_id']; ?>">
                                <img src="../assets/admin/images/edit.png"></a></td>


                    </tr>
                    </tr>
                    <?php
                    }
                    ?>
                    </tr>
                    </tbody>
                </table>
            </div>


            <?php
            if (isset($_SERVER['PHP_SELF'])) {
                if (isset($_GET['hotel_id'])) {
                    $hotel_id = $_GET['hotel_id'];
                    include 'config.php';
                    $query = "update tbl_hotel
 set isdeleted = 1 where hotel_id = '$hotel_id'";
                    $result = db_query($con, $query);
                    if ($result) {
                        echo "<script>alert('Hotel deleted succesfully');</script>";
                        echo "<script language='javascript'>window.location.href='hotel.php';</script>";
                    }
                }
            }
            ?>









            <?php
            include("footer.php");


            ?>
					 
					 
					 
					 
					 
					 
					 
				 