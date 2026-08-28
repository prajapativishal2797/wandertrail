<?php
include("sidebar.php");
include("header.php");

?>


<br/><br/><br/>


<div class="bs-example widget-shadow" data-example-id="bordered-table" style="overflow:scroll;margin-left:17%;">
    <h4>Package Payment:</h4>
    <table class="table table-bordered">
        <thead>

        <tr>
            <th>Booking Id</th>
            <th>Amount</th>
            <th>cardtype</th>
            <th>nameoncard</th>
            <th>card no</th>


        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            include("config.php");


            $sql = "select * from tbl_packagepayment";
            $result = db_query($con, $sql);
            while ($row = db_fetch_array($result))
            {
            ?>
        <tbody>
        <tr>
            <td><?php echo $row['packagebooking_id']; ?></td>
            <td><?php echo $row['amount']; ?></td>

            <td><?php echo $row['card_type']; ?></td>

            <td><?php echo $row['nameon_card']; ?></td>

            <td><?php echo $row['card_no']; ?></td>


        </tr>
        </tbody>
        <?php
        }
        ?>
    </table>
</div>
</form>


<?php
include("footer.php");


?>	 
					 
					 
					 
					 
					 
					 
					 
				 