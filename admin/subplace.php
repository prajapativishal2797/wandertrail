<?php
include("sidebar.php");
include("header.php");

?>


<?php
include("config.php");
if (isset($_POST['subplace'])) {

    $place_id = $_POST['place_id'];
    $subplace_name = $_POST['subplace_name'];
    $city = $_POST['city'];
    $upload_pic1 = trim($_FILES['upload_pic1']['name']);
    $upload_pic2 = trim($_FILES['upload_pic2']['name']);
    $upload_pic3 = trim($_FILES['upload_pic3']['name']);
    $tag_line = $_POST['tag_line'];
    $subplace_des = $_POST['subplace_des'];
    $modes_transport = $_POST['modes_transport'];
    $besttime_visit = $_POST['besttime_visit'];
    $whats_great = $_POST['whats_great'];
    $local_food = $_POST['local_food'];


    $sql = "insert into tbl_subplace(place_id,subplace_name,city,upload_pic1,upload_pic2,upload_pic3,tag_line,subplace_des,modes_transport,besttime_visit,whats_great,local_food)value('$place_id','$subplace_name','$city','$upload_pic1','$upload_pic2','$upload_pic3','$tag_line','$subplace_des','$modes_transport','$besttime_visit','$whats_great','$local_food')";
    $result = db_query($con, $sql);
    if ($result) {
        echo "<script>alert('Sub Place added succesfully');</script>";
    }

}
?>


<div id="page-wrapper">
    <div class="main-page">
        <div class="forms">
            <h2 class="title1">Place</h2>
            <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                <div class="form-title">
                    <h4>Insert Place:</h4>
                </div>
                <div class="form-body">
                    <form method="POST" enctype="multipart/form-data">
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
                            <label for="exampleInputEmail1">Subplace Name</label>
                            <input type="text" class="form-control" name="subplace_name" id="exampleInputEmail1"
                                   placeholder="subplace name">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">City Name</label>
                            <input type="text" class="form-control" name="city" id="exampleInputEmail1"
                                   placeholder="City Name">
                        </div>


                        <?php
                        if (isset($_FILES['upload_pic1'])) {
                            $file_name = $_FILES['upload_pic1']['name'];
                            $file_tmp = $_FILES['upload_pic1']['tmp_name'];
                            $file_size = $_FILES['upload_pic1']['size'];
                            if ($_FILES['upload_pic1']['size'] > 10526552) {
                                echo "<br>image size is greater";
                            } else {
                                if (move_uploaded_file($file_tmp, 'subplace/' . $file_name)) {

                                }
                            }
                        }
                        ?>

                        <div class="form-group">
                            <label for="exampleInputFile">Upload Pic 1</label>
                            <input type="file" name="upload_pic1" id="exampleInputFile">
                            <p class="help-block">Upload Image here</p>
                        </div>


                        <?php
                        if (isset($_FILES['upload_pic2'])) {
                            $file_name = $_FILES['upload_pic2']['name'];
                            $file_tmp = $_FILES['upload_pic2']['tmp_name'];
                            $file_size = $_FILES['upload_pic2']['size'];
                            if ($_FILES['upload_pic2']['size'] > 10526552) {
                                echo "<br>image size is greater";
                            } else {
                                if (move_uploaded_file($file_tmp, 'subplace/' . $file_name)) {

                                }
                            }
                        }
                        ?>

                        <div class="form-group">
                            <label for="exampleInputFile">Upload Pic 2</label>
                            <input type="file" name="upload_pic2" id="exampleInputFile">
                            <p class="help-block">Upload Image here</p>
                        </div>


                        <?php
                        if (isset($_FILES['upload_pic3'])) {
                            $file_name = $_FILES['upload_pic3']['name'];
                            $file_tmp = $_FILES['upload_pic3']['tmp_name'];
                            $file_size = $_FILES['upload_pic3']['size'];
                            if ($_FILES['upload_pic3']['size'] > 10526552) {
                                echo "<br>image size is greater";
                            } else {
                                if (move_uploaded_file($file_tmp, 'subplace/' . $file_name)) {

                                }
                            }
                        }
                        ?>


                        <div class="form-group">
                            <label for="exampleInputFile">Upload Pic 3</label>
                            <input type="file" name="upload_pic3" id="exampleInputFile">
                            <p class="help-block">Upload Image here</p>
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">Tag Line</label>
                            <input type="text" class="form-control" name="tag_line" id="exampleInputEmail1"
                                   placeholder="Tag line">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">Subplace description</label>
                            <input type="text" class="form-control" name="subplace_des" id="exampleInputEmail1"
                                   placeholder="subplace des">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">modes of transport</label>
                            <input type="text" class="form-control" name="modes_transport" id="exampleInputEmail1"
                                   placeholder="modes of transport">
                        </div>


                        <div class="form-group">
                            <label for="exampleInputEmail1">Best time to visit</label>
                            <input type="text" class="form-control" name="besttime_visit" id="exampleInputEmail1"
                                   placeholder="Best time to visit">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">whats great</label>
                            <input type="text" class="form-control" name="whats_great" id="exampleInputEmail1"
                                   placeholder="whats great">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Local food</label>
                            <input type="text" class="form-control" name="local_food" id="exampleInputEmail1"
                                   placeholder="Local food">
                        </div>


                        <button type="submit" class="btn btn-default" name="subplace">Submit</button>
                    </form>
                </div>
            </div>


            <div class="bs-example widget-shadow" data-example-id="bordered-table" style="overflow:scroll;">
                <h4>Manage Subplace:</h4>
                <table class="table table-bordered">
                    <thead>

                    <tr>
                        <th>Place Name</th>
                        <th>sub place name</th>
                        <th>city</th>
                        <th>pic1</th>
                        <th>pic2</th>
                        <th>pic3</th>
                        <th>Tag Line</th>
                        <th>Subplace Desc</th>
                        <th>transport</th>
                        <th>best time to visit</th>
                        <th>whats great</th>
                        <th>local food</th>
                        <th>delete</th>
                        <th>edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php
                        include("config.php");
                        $sql = "select pl.place_name,lgn.* from tbl_subplace lgn INNER JOIN tbl_place pl ON pl.place_id=lgn.place_id where lgn.isdeleted=0";
                        $result = db_query($con, $sql);

                        while ($rows = db_fetch_array($result))
                        {
                        ?>

                    <tr>
                        <td><?php echo $rows['place_name']; ?></td>
                        <td><?php echo $rows['subplace_name']; ?></td>
                        <td><?php echo $rows['city']; ?></td>

                        <td><img style="height:40px;width:40px;" src="subplace/<?php echo $rows['upload_pic1']; ?>">
                        </td>
                        <td><img style="height:40px;width:40px;" src="subplace/<?php echo $rows['upload_pic2']; ?>">
                        </td>
                        <td><img style="height:40px;width:40px;" src="subplace/<?php echo $rows['upload_pic3']; ?>">
                        </td>
                        <td><?php echo $rows['tag_line']; ?></td>
                        <td><?php echo $rows['subplace_des']; ?></td>
                        <td><?php echo $rows['modes_transport']; ?></td>
                        <td><?php echo $rows['besttime_visit']; ?></td>
                        <td><?php echo $rows['whats_great']; ?></td>
                        <td><?php echo $rows['local_food']; ?></td>

                        <td><a href="subplace.php?subplace_id=<?php echo $rows['subplace_id']; ?>">
                                <img src="../assets/admin/images/delete.png"></a></td>


                        <td><a href="editsubplace.php?subplace_id=<?php echo $rows['subplace_id']; ?>">
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
                if (isset($_GET['subplace_id'])) {
                    $subplace_id = $_GET['subplace_id'];
                    include 'config.php';
                    $query = "update tbl_subplace
 set isdeleted = 1 where subplace_id = '$subplace_id'";
                    $result = db_query($con, $query);
                    if ($result) {
                        echo "<script>alert('Subplace deleted succesfully');</script>";
                        echo "<script language='javascript'>window.location.href='subplace.php';</script>";
                    }
                }
            }
            ?>









            <?php
            include("footer.php");


            ?>
					 
					 
					 
					 
					 
					 
					 
				 