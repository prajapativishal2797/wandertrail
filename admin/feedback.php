<?php
include("sidebar.php");
include("header.php");

?>


<br/><br/><br/>


<div class="bs-example widget-shadow" data-example-id="bordered-table" style="overflow:scroll;margin-left:17%;">
    <h4>Manage Feedback:</h4>
    <table class="table table-bordered">
        <thead>

        <tr>
            <th>email Id</th>
            <th>date</th>
            <th>Message</th>


            <th>Delete
            <th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            include("config.php");


            $sql = "select pl.email_id,lgn.* from tbl_feedback lgn INNER JOIN tbl_register pl ON pl.user_id=lgn.user_id where lgn.isdeleted=0";
            $result = db_query($con, $sql);
            while ($row = db_fetch_array($result))
            {
            ?>
        <tbody>
        <tr>
            <td><?php echo $row['email_id']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['feedback_msg']; ?></td>


            <td><a href="feedback.php?feedback_id=<?php echo $row['feedback_id']; ?>">
                    <img src="../assets/admin/images/delete.png"/></a></td>
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
    if (isset($_GET['feedback_id'])) {
        $feedback_id = $_GET['feedback_id'];
        include 'config.php';
        $query = "update tbl_feedback
 set isdeleted = 1 where feedback_id = '$feedback_id'";
        $result = db_query($con, $query);
        if ($result) {
            echo "<script>alert('package deleted succesfully');</script>";
            echo "<script language='javascript'>window.location.href='feedback.php';</script>";
        }
    }
}
?>













<?php
include("footer.php");


?>	 
					 
					 
					 
					 
					 
					 
					 
				 