<?php
include("sidebar.php");
include("header.php");

?>

<?php
include("config.php");
if (isset($_POST['place'])) {


    $place_name = $_POST['place_name'];
    $place_image = trim($_FILES['place_image']['name']);


    $sql = "insert into tbl_place(place_name,place_image)value('$place_name','$place_image')";
    $result = db_query($con, $sql);
    if ($result) {

        echo "<script>alert('Place added succesfully');</script>";
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
                    <input type="text" class="form-control" name="place_name" id="exampleInputEmail1"
                           placeholder="Place Name">
                </div>


                <?php
                if (isset($_FILES['place_image'])) {
                    $file_name = $_FILES['place_image']['name'];
                    $file_tmp = $_FILES['place_image']['tmp_name'];
                    $file_size = $_FILES['place_image']['size'];
                    if ($_FILES['place_image']['size'] > 10526552) {
                        echo "<br>image size is greater";
                    } else {
                        if (move_uploaded_file($file_tmp, 'placeimage/' . $file_name)) {

                        }
                    }
                }
                ?>

                <div class="form-group">
                    <label for="exampleInputFile">Place Image</label>
                    <input type="file" name="place_image" id="exampleInputFile">
                    <p class="help-block">Upload Place Image here</p>
                </div>


                <button type="submit" class="btn btn-default" name="place">Submit</button>
            </form>
        </div>
    </div>


    <div class="bs-example widget-shadow" data-example-id="bordered-table">
        <h4>Manage Place:</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>place name</th>
                <th>place image</th>
                <th>delete</th>
                <th>edit</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                include("config.php");
                $sql = "select * from tbl_place where isdeleted=0";
                $result = db_query($con, $sql);

                while ($row = db_fetch_array($result))
                {
                ?>

            <tr>
                <td><?php echo $row['place_name']; ?></td>
                <td><img src="placeimage/<?php echo $row['place_image']; ?>" style="height:50px;width:50px;"></td>


                <td><a href="place.php?place_id=<?php echo $row['place_id']; ?>"><img
                                src="../assets/admin/images/delete.png"></img></a></td>

                <td><a href="editplace.php?place_id=<?php echo $row['place_id']; ?>"><img
                                src="../assets/admin/images/edit.png"></img></a></td>
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
    if (isset($_GET['place_id'])) {
        $place_id = $_GET['place_id'];
        include 'config.php';
        $query = "update tbl_place
 set isdeleted = 1 where place_id = '$place_id'";
        $result = db_query($con, $query);
        if ($result) {
            echo "<script>alert('Place deleted succesfully');</script>";
            echo "<script language='javascript'>window.location.href='place.php';</script>";
        }
    }
}
?>


<?php
include("footer.php");


?>