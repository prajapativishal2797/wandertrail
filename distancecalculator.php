<?php
global $pg;
$pg = 1;
?>
<?php
include("header.php");
?>

<section style="background-image:url('assets/site/pic/breadcrumbs/bg-1.jpg');" class="breadcrumbs">
    <div class="container">
        <div class="text-left breadcrumbs-item"><a href="index.php">home</a><i>/</i><a href="" class="last"><span>Distance</span>
                Calculator</a>
            <h2><span>Distance</span> Calculator</h2>
        </div>
    </div>
</section>


<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


    <script src="//maps.googleapis.com/maps/api/js?
   key=&sensor=false&libraries=places" type="text/javascript"></script>


</head>
<body>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4 class="trans-uppercase mb-10">Distance Calculator</h4>
            <div class="cws_divider mb-30"></div>
        </div>
    </div>
    <div class="review-content pattern relative">
        <div class="row">
            <h5 class="trans-uppercase mb-10" style="color:#444444;text-align:center;margin-bottom:30px;">welcome to
                <span style="color:#ffc107;text-transform:none;">Distance Calculator</span></h5>
        </div>

        <form class="form clearfix" method="post" style="color:#444444;">
            <div class="row">
                <div class="col-md-4">
                    <label for="email">Source:</label>
                    <input type="text" size="40" aria-required="true" class="form-row form-row-first" id="source"
                           required/>
                </div>
                <div class="col-md-4">
                    <label for="pwd">Destination:</label>
                    <input type="text" size="40" aria-required="true" class="form-row form-row-first" id="destination"
                           required/>
                </div>

                <div class="col-md-4">
                    <label for="pwd">Distance in km :</label>
                    <input type="text" class="form-control distance" readonly
                           style="background:#FFF; min-height:52px; max-height:52px;">
                </div>
                <div class="col-md-12" style="margin-top:-25px;">
                    <br/>
                    <button type="button" value="Get Route" onClick="get_rout()" class="cws-button alt float-right">Get
                        Rout & Distance
                    </button>

                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <br/><br/>
        <div class='col-md-8' id='maplocation' style="height: 500px;"></div>
        <div class='col-md-4' id='panallocation' style=" height: auto;"></div>
    </div>
</div>


<script type="text/javascript">
    var source, destination;
    var darection = new google.maps.DirectionsRenderer;
    var directionsService = new google.maps.DirectionsService;
    google.maps.event.addDomListener(window, 'load', function () {
        new google.maps.places.SearchBox(document.getElementById('source'));
        new google.maps.places.SearchBox(document.getElementById('destination'));

    });

    function get_rout() {


        var mapOptions = {
            mapTypeControl: false,
            //center: {lat: -33.8688, lng: 151.2195},
            center: {lat: 23.09008, lng: 78.55765},
            zoom: 4.2
        };

        map = new google.maps.Map(document.getElementById('maplocation'), mapOptions);
        darection.setMap(map);
        darection.setPanel(document.getElementById('panallocation'));


        source = document.getElementById("source").value;
        destination = document.getElementById("destination").value;

        var request = {
            origin: source,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                darection.setDirections(response);
            }
        });


        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix({
            origins: [source],
            destinations: [destination],
            travelMode: google.maps.TravelMode.DRIVING,
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false
        }, function (response, status) {
            if (status == google.maps.DistanceMatrixStatus.OK && response.rows[0].elements[0].status != "ZERO_RESULTS") {
                var distance = response.rows[0].elements[0].distance.text;
                var duration = response.rows[0].elements[0].duration.text;

                distancefinel = distance.split(" ");
                $('.distance').val(distancefinel[0]);


            } else {
                alert("Unable to find the distance via road.");
            }
        });
    }


</script>

<br><br>

</body>
</html>
<?php
include("footer.php");
?>



