<?php
include("sidebar.php");
include("header.php");

?>


<br/><br/><br/>


<div class="bs-example widget-shadow" data-example-id="bordered-table" style="overflow:scroll;margin-left:17%;">
    <h4>Package Booking:</h4>
    <table class="table table-bordered">
        <thead>

        <tr>
            <th>Package Name</th>
            <th>Amount</th>
            <th>start date</th>
            <th>end date</th>
            <th>adults</th>
            <th>childs</th>

            <th>no_rooms</th>
            <th>package_category</th>
            <th>hotel name</th>
            <th>email id</th>
            <th>packagebooking_date</th>
            <th>approved</th>

        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            include("config.php");


            $sql = "select * from tbl_packagebooking where isapproved='pending'";
            $result = db_query($con, $sql);
            while ($row = db_fetch_array($result))
            {
            ?>
        <tbody>
        <tr>

            <td><?php $id = $row['package_id'];
                $sql1 = "select package_name from tbl_package where package_id = $id and isdeleted = 0";
                $result1 = db_query($con, $sql1);
                while ($row1 = db_fetch_array($result1)) {
                    echo $row1['package_name'];
                } ?></td>


            <td><?php echo $row['amount']; ?></td>
            <td><?php echo $row['start_date']; ?></td>
            <td><?php echo $row['end_date']; ?></td>

            <td><?php echo $row['adults']; ?></td>
            <td><?php echo $row['childs']; ?></td>
            <td><?php echo $row['no_rooms']; ?></td>
            <td><?php echo $row['package_category']; ?></td>

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


            <td><?php echo $row['packagebooking_date']; ?></td>


            <td><a href="booking.php?packagebooking_id=<?php echo $row['packagebooking_id']; ?>">
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
    if (isset($_GET['packagebooking_id'])) {
        $packagebooking_id = $_GET['packagebooking_id'];
        include 'config.php';
        $query = "update tbl_packagebooking
 set isapproved = 'approved' where packagebooking_id = '$packagebooking_id'";
        $result = db_query($con, $query);
        if ($result) {
            echo "<script>alert('package booking approved succesfully');</script>";
            echo "<script language='javascript'>window.location.href='booking.php';</script>";
        }
    }
}
?>

<?php
include("footer.php");


?>	 
					 
					 
					 
					 
					 
					 
					 
				 