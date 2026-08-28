<?php
include("sidebar.php");
include("header.php");

?>

<?php

include("config.php");
if (isset($_GET['place_id'])) {

    $place_id = $_GET['place_id'];
    $sql = "select * from tbl_place where isdeleted=0 and place_id='$place_id'";
    $result = db_query($con, $sql);
    while ($row = db_fetch_array($result)) {
        $place_name = $row['place_name'];
        $place_image = $row['place_image'];

    }
}
?>
    <div id="page-wrapper">
    <div class="main-page">
    <div class="forms">
    <h2 class="title1">Edit Place</h2>
    <div class="form-grids row widget-shadow" data-example-id="basic-forms">
        <div class="form-title">
            <h4>Insert Place:</h4>
        </div>
        <div class="form-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputEmail1">Place Name</label>
                    <input type="text" class="form-control" name="place_name" id="exampleInputEmail1"
                           value="<?php echo $place_name; ?>">
                </div>


                <div class="form-group">
                    <label for="exampleInputFile">Place Image</label>
                    <img src="placeimage/<?php echo $place_image; ?>"
                         style="height:100px;width:120px;display:inline;margin-right:20px;float:left;"/>
                    <br/><br/><input type="file" name="place_image" id="place_image" style="float:left;"/>
                    <input type="hidden" name="place_image" id="place_image"
                           value="<?php if (isset($_SERVER['PHP_SELF'])) {
                               echo $place_image;
                           } ?>"/>

                </div>
                </br></br></br></br>

                <button type="submit" class="btn btn-default" name="editplace">Edit</button>
            </form>
        </div>
    </div>


<?php
include("config.php");
if (isset($_POST['editplace'])) {


    $place_name = $_POST['place_name'];

    $place_image = trim($_FILES['place_image']['name']);


    if ($_FILES["place_image"]["name"] == '') {
        $place_image = $_POST['place_image'];
    } else {
        $place_image = $_FILES['place_image']['name'];
    }
    move_uploaded_file($place_image, 'placeimage/' . $place_image);


    $sql = "update tbl_place set place_name='$place_name',
place_image='$place_image'
 where isdeleted=0 and place_id='$place_id'";
    $result = db_query($con, $sql);
    if ($result) {
        echo "<script language='javascript'>alert('Place  edited successfully');</script>";
        echo "<script language='javascript'>window.location.href='place.php';</script>";
    }

}
?>


<?php
include("footer.php");


?>