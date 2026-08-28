<?php
include("sidebar.php");
include("header.php");

?>


<?php
include("config.php");
if (isset($_POST['package'])) {

    $package_name = $_POST['package_name'];
    $package_img = trim($_FILES['package_img']['name']);
    $package_duration = $_POST['package_duration'];
    $package_des = $_POST['package_des'];
    $package_startprice = $_POST['package_startprice'];
    $package_type = $_POST['package_type'];
    $place_id = $_POST['place_id'];
    $hotel_id = $_POST['hotel_id'];
    $package_rate = $_POST['package_rate'];


    $sql = "insert into tbl_package(package_name,package_img,package_duration,package_des,package_startprice,package_type,place_id,hotel_id,package_rate)value('$package_name','$package_img','$package_duration','$package_des','$package_startprice','$package_type','$place_id','$hotel_id','$package_rate')";
    $result = db_query($con, $sql);
    if ($result) {
        echo "<script>alert('Package added succesfully');</script>";
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
                                   placeholder="Package name">
                        </div>


                        <?php
                        if (isset($_FILES['package_img'])) {
                            $file_name = $_FILES['package_img']['name'];
                            $file_tmp = $_FILES['package_img']['tmp_name'];
                            $file_size = $_FILES['package_img']['size'];
                            if ($_FILES['package_img']['size'] > 10526552) {
                                echo "<br>image size is greater";
                            } else {
                                if (move_uploaded_file($file_tmp, 'package/' . $file_name)) {

                                }
                            }
                        }
                        ?>

                        <div class="form-group">
                            <label for="exampleInputFile">Package image</label>
                            <input type="file" name="package_img" id="exampleInputFile">
                            <p class="help-block">Upload Image here</p>
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">Package Duration</label>
                            <input type="text" class="form-control" name="package_duration" id="exampleInputEmail1"
                                   placeholder="package duration">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">Package Description</label>
                            <input type="text" class="form-control" name="package_des" id="exampleInputEmail1"
                                   placeholder="package description">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">Package starting price</label>
                            <input type="text" class="form-control" name="package_startprice" id="exampleInputEmail1"
                                   placeholder="package startprice">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Package Type</label>
                            <input type="text" class="form-control" name="package_type" id="exampleInputEmail1"
                                   placeholder="package type">
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
                                   placeholder="Package Rate">
                        </div>


                        <button type="submit" class="btn btn-default" name="package">Submit</button>
                    </form>
                </div>
            </div>


            <div class="bs-example widget-shadow" data-example-id="bordered-table">
                <h4>Manage Package:</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Package Name</th>
                        <th>Package Image</th>
                        <th>Duration</th>
                        <th>Description</th>
                        <th>start price</th>
                        <th>Type</th>
                        <th>Place name</th>
                        <th>Hotel name</th>

                        <th>rate</th>


                        <th>delete</th>
                        <th>edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php
                        include("config.php");
                        $sql = "select * from tbl_package where isdeleted=0";
                        $result = db_query($con, $sql);

                        while ($rows = db_fetch_array($result))
                        {
                        ?>

                    <tr>
                        <td><?php echo $rows['package_name']; ?></td>
                        <td><img style="height:40px;width:40px;" src="package/<?php echo $rows['package_img']; ?>"></td>
                        <td><?php echo $rows['package_duration']; ?></td>
                        <td><?php echo $rows['package_des']; ?></td>

                        <td><?php echo $rows['package_startprice']; ?></td>
                        <td><?php echo $rows['package_type']; ?></td>


                        <td><?php $id = $rows['place_id'];
                            $sql1 = "select place_name from tbl_place where place_id = $id and isdeleted = 0";

                            $result1 = db_query($con, $sql1);
                            while ($row1 = db_fetch_array($result1)) {
                                echo $row1['place_name'];
                            } ?></td>


                        <td><?php $id = $rows['hotel_id'];
                            $sql1 = "select hotel_name from tbl_hotel where hotel_id = $id and isdeleted = 0";

                            $result1 = db_query($con, $sql1);
                            while ($row1 = db_fetch_array($result1)) {
                                echo $row1['hotel_name'];
                            } ?></td>

                        <td><?php echo $rows['package_rate']; ?></td>


                        <td><a href="package.php?package_id=<?php echo $rows['package_id']; ?>">
                                <img src="../assets/admin/images/delete.png"></a></td>


                        <td><a href="editpackage.php?package_id=<?php echo $rows['package_id']; ?>">
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
                if (isset($_GET['package_id'])) {
                    $package_id = $_GET['package_id'];
                    include 'config.php';
                    $query = "update tbl_package
 set isdeleted = 1 where package_id = '$package_id'";
                    $result = db_query($con, $query);
                    if ($result) {
                        echo "<script>alert('package deleted succesfully');</script>";
                        echo "<script language='javascript'>window.location.href='package.php';</script>";
                    }
                }
            }
            ?>









            <?php
            include("footer.php");


            ?>
					 
					 
					 
					 
					 
					 
					 
				 
					 
					 
					 
					 
					 
					 
				 