<?php
include("sidebar.php");
include("header.php");

?>

<?php
include("config.php");
global $subplace_id, $place_id, $subplace_name, $city, $upload_pic1, $upload_pic2, $upload_pic3, $tag_line, $subplace_des, $modes_transport, $besttime_visit, $whats_great, $local_food;

if (isset($_GET['subplace_id'])) {
    $subplace_id = $_GET['subplace_id'];
    $sql = "select * from tbl_subplace where isdeleted=0 and subplace_id='$subplace_id'";
    $result = db_query($con, $sql);
    while ($row = db_fetch_array($result)) {
        $place_id = $row['place_id'];
        $subplace_name = $row['subplace_name'];
        $city = $row['city'];
        $upload_pic1 = $row['upload_pic1'];
        $upload_pic2 = $row['upload_pic2'];
        $upload_pic3 = $row['upload_pic3'];


        $tag_line = $row['tag_line'];
        $subplace_des = $row['subplace_des'];
        $modes_transport = $row['modes_transport'];
        $besttime_visit = $row['besttime_visit'];
        $whats_great = $row['whats_great'];
        $local_food = $row['local_food'];


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
                           value="<?php echo $subplace_name; ?>">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">City Name</label>
                    <input type="text" class="form-control" name="city" id="exampleInputEmail1"
                           value="<?php echo $city; ?>">
                </div>


                <div class="form-group">
                    <label for="exampleInputFile">Upload Pic 1</label>
                    <img src="subplace/<?php echo $upload_pic1; ?>"
                         style="height:100px;width:120px;display:inline;margin-right:20px;float:left;"/><br/><br/><input
                            type="file" name="upload_pic1" id="upload_pic1" style="float:left;"/>
                    <input type="hidden" name="upload_pic1" id="upload_pic1"
                           value="<?php if (isset($_SERVER['PHP_SELF'])) {
                               echo $upload_pic1;
                           } ?>"/>
                </div>


                <br/><br/><br/>

                <div class="form-group">
                    <label for="exampleInputFile">Upload Pic 2</label>
                    <img src="subplace/<?php echo $upload_pic2; ?>"
                         style="height:100px;width:120px;display:inline;margin-right:20px;float:left;"/><br/><br/><input
                            type="file" name="upload_pic2" id="upload_pic2" style="float:left;"/>
                    <input type="hidden" name="upload_pic2" id="upload_pic2"
                           value="<?php if (isset($_SERVER['PHP_SELF'])) {
                               echo $upload_pic2;
                           } ?>"/>
                </div>


                <br/><br/><br/>


                <div class="form-group">
                    <label for="exampleInputFile">Upload Pic 3</label>
                    <img src="subplace/<?php echo $upload_pic3; ?>"
                         style="height:100px;width:120px;display:inline;margin-right:20px;float:left;"/><br/><br/><input
                            type="file" name="upload_pic3" id="upload_pic3" style="float:left;"/>
                    <input type="hidden" name="upload_pic3" id="upload_pic3"
                           value="<?php if (isset($_SERVER['PHP_SELF'])) {
                               echo $upload_pic3;
                           } ?>"/>
                </div>
                <br/><br/><br/>


                <div class="form-group">
                    <label for="exampleInputEmail1">Tag Line</label>
                    <input type="text" class="form-control" name="tag_line" id="exampleInputEmail1"
                           value="<?php echo $tag_line; ?>">
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">Subplace description</label>
                    <input type="text" class="form-control" name="subplace_des" id="exampleInputEmail1"
                           value="<?php echo $subplace_des; ?>">
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">modes of transport</label>
                    <input type="text" class="form-control" name="modes_transport" id="exampleInputEmail1"
                           value="<?php echo $modes_transport; ?>">
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">Best time to visit</label>
                    <input type="text" class="form-control" name="besttime_visit" id="exampleInputEmail1"
                           value="<?php echo $besttime_visit; ?>">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">whats great</label>
                    <input type="text" class="form-control" name="whats_great" id="exampleInputEmail1"
                           value="<?php echo $whats_great; ?>">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Local food</label>
                    <input type="text" class="form-control" name="local_food" id="exampleInputEmail1"
                           value="<?php echo $local_food; ?>">
                </div>


                <button type="submit" class="btn btn-default" name="editsubplace">Edit</button>
            </form>
        </div>
    </div>


<?php

if (isset($_POST['editsubplace'])) {
    if (($_POST['editsubplace']) == 0) {

        $place_id = $_POST['place_id'];
        $subplace_name = $_POST['subplace_name'];
        $city = $_POST['city'];

        $upload_pic1 = trim($_FILES['upload_pic1']['name']);
        if ($_FILES["upload_pic1"]["name"] == '') {
            $upload_pic1 = $_POST['upload_pic1'];
        } else {
            $upload_pic1 = $_FILES['upload_pic1']['name'];
        }
        move_uploaded_file($upload_pic1, 'subplace/' . $upload_pic1);


        $upload_pic2 = trim($_FILES['upload_pic2']['name']);
        if ($_FILES["upload_pic2"]["name"] == '') {
            $upload_pic2 = $_POST['upload_pic2'];
        } else {
            $upload_pic2 = $_FILES['upload_pic2']['name'];
        }
        move_uploaded_file($upload_pic2, 'subplace/' . $upload_pic2);


        $upload_pic3 = trim($_FILES['upload_pic3']['name']);
        if ($_FILES["upload_pic3"]["name"] == '') {
            $upload_pic3 = $_POST['upload_pic3'];
        } else {
            $upload_pic3 = $_FILES['upload_pic3']['name'];
        }
        move_uploaded_file($upload_pic3, 'subplace/' . $upload_pic3);


        $tag_line = $_POST['tag_line'];
        $subplace_des = $_POST['subplace_des'];
        $modes_transport = $_POST['modes_transport'];
        $besttime_visit = $_POST['besttime_visit'];
        $whats_great = $_POST['whats_great'];
        $local_food = $_POST['local_food'];


        $sql = "update tbl_subplace set place_id='$place_id',subplace_name='$subplace_name',city='$city',upload_pic1='$upload_pic1',upload_pic2='$upload_pic2',upload_pic3='$upload_pic3',tag_line='$tag_line',subplace_des='$subplace_des',modes_transport='$modes_transport',besttime_visit='$besttime_visit',whats_great='$whats_great',local_food='$local_food' where isdeleted=0 and subplace_id='$subplace_id'";

        $result = db_query($con, $sql);
        if ($result) {
            echo "<script language='javascript'>alert('Subplace  edited successfully');</script>";
            echo "<script>window.location.href='subplace.php'</script>";

        }
    }

}
?>


<?php
include("footer.php");


?>