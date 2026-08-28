<?php
include("sidebar.php");
include("header.php");

?>


<br/><br/><br/>


<div class="bs-example widget-shadow" data-example-id="bordered-table" style="overflow:scroll;margin-left:17%;">
    <h4>Search Subplace:</h4>
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

        </tr>
        </thead>
        <tbody>
        <tr>
            <?php

            include("config.php");
            if (isset($_GET['submit']))
            {
            $search_query = $_GET['user_query'];

            $sql = "select pl.place_name,lgn.* from tbl_subplace lgn INNER JOIN tbl_place
 pl ON pl.place_id=lgn.place_id where lgn.isdeleted=0 and lgn.subplace_name like '%$search_query%'";


            $result = db_query($con, $sql);

            while ($rows = db_fetch_array($result))
            {
            ?>

        <tr>
            <td><?php echo $rows['place_name']; ?></td>
            <td><?php echo $rows['subplace_name']; ?></td>
            <td><?php echo $rows['city']; ?></td>

            <td><img style="height:40px;width:40px;" src="subplace/<?php echo $rows['upload_pic1']; ?>"></td>
            <td><img style="height:40px;width:40px;" src="subplace/<?php echo $rows['upload_pic2']; ?>"></td>
            <td><img style="height:40px;width:40px;" src="subplace/<?php echo $rows['upload_pic3']; ?>"></td>
            <td><?php echo $rows['tag_line']; ?></td>
            <td><?php echo $rows['subplace_des']; ?></td>
            <td><?php echo $rows['modes_transport']; ?></td>
            <td><?php echo $rows['besttime_visit']; ?></td>
            <td><?php echo $rows['whats_great']; ?></td>
            <td><?php echo $rows['local_food']; ?></td>


        </tr>
        </tr>
        <?php
        }
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
					 
					 
					 
					 
					 
					 
					 
				 