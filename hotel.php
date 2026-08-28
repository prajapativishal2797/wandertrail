<?php
global $pg;
$pg = 5;
?>
<?php
include("header.php");
?>
<section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
    <div class="container">
        <?php
        $sql = "select hotel_name from tbl_hotel where isdeleted = 0 and hotel_id='" . $_REQUEST['hotel_id'] . "' ";
        $result = db_query($con, $sql);
        while ($row = db_fetch_array($result)) {
            ?>
            <div class="text-left breadcrumbs-item"><a href="index.php">home</a><i>/</i><a href="hotels.php">All
                    Hotels</a><i>/</i><a href="" class="last"><span>Hotel</span> <?php echo $row['hotel_name']; ?>
                </a>
                <h2><span>Hotel</span> <?php echo $row['hotel_name']; ?></h2>
            </div>
            <?php
        }
        ?>
    </div>
</section>


<div class="content-body">
    <section class="page-section pt-0 pb-50">
        <div class="container">
            <div class="menu-widget with-switch mt-30 mb-30">
                <ul class="magic-line">
                    <li class="current_item"><a href="#overview" class="scrollto">Overview</a></li>
                    <li><a href="#prices" class="scrollto">Other Hotels</a></li>


                </ul>
            </div>
        </div>
        <form method="post">
            <?php
            include("config.php");
            ?>

            <?php
            $sql = "select pl.place_name,lgn.* from tbl_hotel lgn INNER JOIN tbl_place pl ON pl.place_id=lgn.place_id where lgn.isdeleted = 0 and hotel_id='" . $_REQUEST['hotel_id'] . "' ";
            $result = db_query($con, $sql);
            while ($row = db_fetch_array($result))
            {
            $Path = "admin/hotel/" . $row['hotel_image'];
            ?>
            <div class="container">


                <div class="container mt-30">
                    <center>
                        <h4 class="mb-20">
                            <?php echo $row['hotel_name']; ?>
                            <div class="stars stars-<?php echo $row['hotel_category']; ?>"></div>
                        </h4>
                        <img src="./admin/hotel/<?php echo $row['hotel_image']; ?>"
                             style="height:400px;width:1200px;"></center>
                    <br/>
                    <div class="row">
                        <div class="col-md-8">

                            <h5>Description</h5>
                            <p class="mb-15"><?php echo $row['hotel_des']; ?> </p>
                            <h5>Address</h5>
                            <p class="mb-15">
                                <?php echo $row['hotel_address']; ?> </p>
                            <h5>State</h5>
                            <p class="mb-15">
                                <?php echo $row['place_name']; ?> </p>
                            <h5>Starting price</h5>
                            <p class="mb-15"><span class="font-4">&#8377;<?php echo $row['hotel_price']; ?></span>
                            </p>
                            <center><p class="post-info"><a
                                            href="<?php echo h(auth_cta_url('user/booking.php?type=hotel&id=' . $_REQUEST['hotel_id'])); ?>"
                                            class="cws-button alt gray-dark mb-20">Book Now</a></p></center>

                        </div>
                        <?php
                        }
                        ?>
        </form>
        <div class="col-md-4">
            <div class="bg-gray-3 p-30-40">


                <?php
                $sql = "select * from tbl_hotel where isdeleted = 0 LIMIT 0,4";
                $result = db_query($con, $sql);
                while ($row = db_fetch_array($result))
                {
                ?>
                <form method="post">
                    <ul class="style-1 mb-0">
                        <li>
                            <a href="hotel.php?hotel_id=<?php echo $row['hotel_id']; ?>"><?php echo $row['hotel_name']; ?></a>
                        </li>

                        <?php
                        }
                        ?>

                    </ul>
                    <a href="hotels.php">
                        <ins class="alt-5">More Hotels</ins>
                    </a>
                </form>
            </div>
        </div>
</div>
</div>

<div id="prices" class="container mb-50 mt-40">
    <div class="search-hotels room-search pattern">
        <div class="search-room-title">
            <h5>Choose your Hotel</h5>
        </div>

    </div>
    <div class="room-table">
        <table class="table alt-2">
            <thead>
            <tr>
                <th>Room Image</th>
                <th>Hotel Type</th>
                <th>Options</th>
                <th>Today's price</th>
                <th>Booking</th>
            </tr>
            </thead>
            <?php
            $sql = "select pl.place_name,lgn.* from tbl_hotel lgn INNER JOIN tbl_place pl ON pl.place_id=lgn.place_id where lgn.isdeleted = 0 and hotel_id!='" . $_REQUEST['hotel_id'] . "' LIMIT 0,2";
            $result = db_query($con, $sql);
            while ($row = db_fetch_array($result))
            {
            ?>
            <form method="post">
                <tbody>
                <tr>
                    <td><img src="./admin/hotel/<?php echo $row['hotel_image']; ?>"
                             style="height:130px;width:190px;" alt>
                        <h6><?php echo $row['hotel_name']; ?></h6>

                    </td>
                    <td>
                        <div class="stars stars-<?php echo $row['hotel_category']; ?>"></div>
                        <br/><?php echo $row['hotel_category']; ?>

                    </td>
                    <td>
                        <ul class="style-1">
                            <li><?php echo $row['hotel_address']; ?></li>
                            <li><?php echo $row['place_name']; ?></li>

                        </ul>
                    </td>
                    <td class="room-price">&#8377;<?php echo $row['hotel_price']; ?></td>
                    <td>
                        <a href="<?php echo h(auth_cta_url('user/booking.php?type=hotel&id=' . $row['hotel_id'])); ?>"
                           class="cws-button alt gray">Book Now</a></td>
                </tr>

                </tbody>
                <?php
                }
                ?>
            </form>
        </table>
    </div>
</div>
    
    
    
    
    
    
    
    
