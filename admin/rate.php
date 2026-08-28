<?php
include("sidebar.php");
include("header.php");

?>


<br/><br/><br/>


<div class="bs-example widget-shadow" data-example-id="bordered-table" style="overflow:scroll;margin-left:17%;">
    <h4>Hotel Booking:</h4>
    <table class="table table-bordered">
        <thead>

        <tr>
            <th>email id</th>
            <th>Hotel Name</th>

            <th>Rating score</th>


        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            include("config.php");


            $sql = "select * from tbl_rate where isdeleted=0";
            $result = db_query($con, $sql);
            while ($row = db_fetch_array($result))
            {
            ?>
        <tbody>
        <tr>

            <td><?php $id = $row['hotel_id'];
                $sql1 = "select hotel_name from tbl_hotel where hotel_id = $id and isdeleted = 0";
                $result1 = db_query($con, $sql1);
                while ($row1 = db_fetch_array($result1)) {
                    echo $row1['hotel_name'];
                } ?></td>


            <td><?php $id = $row['user_id'];
                $sql1 = "select email_id from tbl_register where user_id = $id and isdeleted = 0";
                $result1 = db_query($con, $sql1);
                while ($row1 = db_fetch_array($result1)) {
                    echo $row1['email_id'];
                } ?></td>


            <td><?php echo $row['ratings_score']; ?></td>


        </tr>
        </tbody>
        <?php
        }
        ?>
    </table>
</div>
</form>


<?php
if (isset($_SERVER['PHP_SELF'])) {
    if (isset($_GET['ratings_id'])) {
        $ratings_id = $_GET['ratings_id'];
        include 'config.php';
        $query = "update tbl_rate
 set isdeleted=0 where ratings_id = '$ratings_id'";
        $result = db_query($con, $query);
        if ($result) {
            echo "<script>alert('ratig deleted succesfully');</script>";
            echo "<script language='javascript'>window.location.href='rate.php';</script>";
        }
    }
}
?>

<?php
include("footer.php");


?>	 
					 
					 
					 
					 
					 
					 
					 
				 