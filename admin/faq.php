<?php
include("sidebar.php");
include("header.php");

?>


<br/><br/><br/>


<div class="bs-example widget-shadow" data-example-id="bordered-table" style="overflow:scroll;margin-left:17%;">
    <h4>Manage FAQ:</h4>
    <table class="table table-bordered">
        <thead>

        <tr>
            <th>Question</th>
            <th>Answer</th>
            <th>View count</th>
            <th>Date</th>

            <th>Delete
            <th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            include("config.php");


            $sql = "select * from tbl_faq where isdeleted = 0";
            $result = db_query($con, $sql);
            while ($row = db_fetch_array($result))
            {
            ?>
        <tbody>
        <tr>
            <td><?php echo $row['faq_que']; ?></td>
            <td><?php echo $row['faq_ans']; ?></td>
            <td><?php echo $row['viewcount']; ?></td>
            <td><?php echo $row['create_date']; ?></td>


            <td><a href="faq.php?faq_id=<?php echo $row['faq_id']; ?>">
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
    if (isset($_GET['faq_id'])) {
        $faq_id = $_GET['faq_id'];
        include 'config.php';
        $query = "update tbl_faq
 set isdeleted = 1 where faq_id = '$faq_id'";
        $result = db_query($con, $query);
        if ($result) {
            echo "<script>alert('package deleted succesfully');</script>";
            echo "<script language='javascript'>window.location.href='faq.php';</script>";
        }
    }
}
?>













<?php
include("footer.php");


?>	 
					 
					 
					 
					 
					 
					 
					 
				 