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
            <th>Hotel Name</th>
            <th>Amount</th>
            <th>depart_date</th>
            <th>return_date</th>
            <th>adults</th>
            <th>childs</th>
            <th>no_rooms</th>
            <th>email id</th>
            <th>airport_pickup</th>
            <th>car_parking</th>
            <th>extra_breakfast</th>
            <th>hotelbooking_date</th>

            <th>approved</th>

        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            include("config.php");


            $sql = "select * from tbl_hotelbooking where isapproved='pending'";
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


            <td><?php echo $row['amount']; ?></td>
            <td><?php echo $row['depart_date']; ?></td>
            <td><?php echo $row['return_date']; ?></td>

            <td><?php echo $row['adults']; ?></td>
            <td><?php echo $row['childs']; ?></td>
            <td><?php echo $row['no_rooms']; ?></td>

            <td><?php $id = $row['user_id'];
                $sql1 = "select email_id from tbl_register where user_id = $id and isdeleted = 0";
                $result1 = db_query($con, $sql1);
                while ($row1 = db_fetch_array($result1)) {
                    echo $row1['email_id'];
                } ?></td>


            <td><?php echo $row['airport_pickup']; ?></td>
            <td><?php echo $row['car_parking']; ?></td>

            <td><?php echo $row['extra_breakfast']; ?></td>

            <td><?php echo $row['hotelbooking_date']; ?></td>


            <td><a href="hotelbooking.php?hotelbooking_id=<?php echo $row['hotelbooking_id']; ?>">
                    <img src="../assets/admin/images/tick.png"/></a></td>


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
    if (isset($_GET['hotelbooking_id'])) {
        $hotelbooking_id = $_GET['hotelbooking_id'];
        include 'config.php';
        $query = "update tbl_hotelbooking
 set isapproved = 'approved' where hotelbooking_id	 = '$hotelbooking_id'";
        $result = db_query($con, $query);
        if ($result) {
            echo "<script>alert('Hotel booking approved succesfully');</script>";
            echo "<script language='javascript'>window.location.href='hotelbooking.php';</script>";
        }
    }
}
?>

<?php
include("footer.php");


?>	 
					 
					 
					 
					 
					 
					 
					 
				 