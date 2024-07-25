<?php
require_once '../../checkLogin.php';
?>
<html>

<head>
    <link rel="stylesheet" href="../../css/myStyle.css" />
    <link rel="stylesheet" href="../../css/layout.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
  <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js"></script>
<script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet/0.0.1-beta.5/esri-leaflet.js"></script>
<script src="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.css">
<link rel="stylesheet" href="../../map/map.css">

    <title>update restaurant information</title>
    <?php
    
    if ($_SESSION["role"] != "resadmin") {
        echo "<script type='text/javascript'>alert('you are not Operator already!');window.location.href='$_SESSION[role]Index.html';</script>";
    } else {
    }
    ?>


    <style type="text/css">
        input[type=button] {
            color: white;
            padding: 12px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 17px;
        }

        input[type=button]:hover {
            opacity: 0.5;
        }

        input[type=submit] {
            width: 100px;
        }

        #resetButton {
            background-color: #999;
            width: 100px;
            margin: 50px 150px;
        }

        #deleteButton {
            background-color: #ff0000;
            width: 200px;
            margin: 0 150px 50px auto;
        }

        #map {
            height: 600px;
            width: 100%;
        }
    </style>

    <!--Map Script!-->
    <link href='https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../Map/leaflet.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            var map;

            map = new L.Map("map", {
                zoom: 19,
                zoomControl: true
            });

            L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: ' <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
                maxZoom: 19,
                minZoom: 12
            }).addTo(map);
            map.attributionControl.setPrefix(""); // Don't show the 'Powered by Leaflet' text.
            
            
            L.control.scale().addTo(map);

  var searchControl = new L.esri.Controls.Geosearch().addTo(map);

  var results = new L.LayerGroup().addTo(map);

  searchControl.on('results', function(data){
    results.clearLayers();
    for (var i = data.results.length - 1; i >= 0; i--) {
      results.addLayer(L.marker(data.results[i].latlng));
    }
  });

setTimeout(function(){$('.pointer').fadeOut('slow');},3400);
            
            var loc_center = new L.LatLng($("#tfLatitude").val(), $("#tfLongitude").val());
            map.setView(loc_center, 19);

            var marker = L.marker([$("#tfLatitude").val(), $("#tfLongitude").val()]).addTo(map);
            marker.bindPopup("<b>" + $("#tfRestaurantName").val() + "</b><br> " + $("#tfRestaurantAddress").val() + "").openPopup();

            function onMapClick(e) {
                marker
                    .setLatLng(e.latlng)
                    .bindPopup("You clicked the map at <br />" + e.latlng.toString()).openPopup();
                $("#tfLatitude").val(e.latlng.lat.toString());
                $("#tfLongitude").val(e.latlng.lng.toString());
            }

            map.on("click", onMapClick);
        });
    </script>
    <!--Map Script!-->
</head>

<body>
    <?php
            include_once('./header.php');
        ?>
        <br />
        <br />
        <div id="main">
            <center>
                <h1> Update Restaurant Information </h1>
            </center>
            <form method="POST" action="saveRestaurantInformation.php" enctype="multipart/form-data">
                <?php
                require_once('../../conn.php');
                $userEmail = $_SESSION['login_user'];
                $sql = "SELECT * FROM user where Email = '$userEmail'";
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $rc = mysqli_fetch_assoc($result);
                $UserID = $rc['ID'];
                $Email = $rc['Email'];
                $Phone = $rc['Phone'];
                $Address = $rc['Address'];
                $GroupID = $rc['GroupID'];

                $sql = "SELECT * FROM employee where UserID = '$UserID'";
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $rc = mysqli_fetch_assoc($result);
                $EmployeeID = $rc['ID'];
                $RestaurantID = $rc['RestaurantID'];
                $UserID = $rc['UserID'];
                $LastName = $rc['LastName'];
                $FirstName = $rc['FirstName'];
                $JobTitle = $rc['JobTitle'];

                $sql = "SELECT * FROM restaurant where ID = '$RestaurantID'";
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $rc = mysqli_fetch_assoc($result);
                $RestaurantID = $rc['ID'];
                $RestaurantName = $rc['Name'];
                $RestaurantDistrict = $rc['District'];
                $RestaurantAddress = $rc['Address'];
                $RestaurantLatitude = $rc['Latitude'];
                $RestaurantLongitude = $rc['Longitude'];
                $RestaurantPhone = $rc['Phone'];
                $RestaurantEnable = $rc['Enable'];
                if ($RestaurantEnable == 0) {
                    $enchecked = "";
                    $dischecked = "checked=\"checked\"";
                } else {
                    $enchecked = "checked=\"checked\"";
                    $dischecked = "";
                }
                if (file_exists("../../upload/restaurant-photo/restaurant-photo-ID-$RestaurantID")){
                    $exist = '';
                }else{
                    $exist = 'required="required"';
                }


                $form = <<<EOD
<label for="tfRestaurantID"><i class="fa fa-user"></i> Restaurant ID </label>
<input type="text" id="tfRestaurantID" name="tfRestaurantID" value="%s" readonly="readonly" />

<label for="tfRestaurantName"><i class="fa fa-user-o"></i> Restaurant Name </label>
<input type="text" id="tfRestaurantName" name="tfRestaurantName" value="%s" required="required" />

<label for="tfRestaurantDistrict"><i class="fa fa-address-card"></i> Restaurant District </label>

<select id="tfRestaurantDistrict" name="tfRestaurantDistrict" size="1" style="width:204px;">
    <option value="">Please Select</option>
    <option value="Central and Western">Central and Western</option>
    <option value="Eastern">Eastern</option>
    <option value="Islands">Islands</option>	
    <option value="Kowloon City">Kowloon City</option>	
    <option value="Kwai Tsing">Kwai Tsing</option>	
    <option value="Kwun Tong">Kwun Tong</option>	
    <option value="North">North</option>		
    <option value="Sai Kung">Sai Kung</option>	
    <option value="Sha Tin">Sha Tin</option>	
    <option value="Sham Shui Po">Sham Shui Po</option>	
    <option value="Southern">Southern</option>	
    <option value="Tai Po">Tai Po</option>	
    <option value="Tsuen Wan">Tsuen Wan</option>	
    <option value="Tuen Mun">Tuen Mun</option>	
    <option value="Wan Chai">Wan Chai</option>	
    <option value="Wong Tai Sin">Wong Tai Sin</option>	
    <option value="Yau Tsim Mong">Yau Tsim Mong</option>	
    <option value="Yuen Long">Yuen Long</option>
</select>


<label for="tfRestaurantAddress"><i class="fa fa-address-card-o"></i> Restaurant Address </label>
<input type="text" id="tfRestaurantAddress" name="tfRestaurantAddress" value="%s" required="required" style="width:550px;" />

<label for="tfRestaurantPhoneNumber"><i class="fa fa-phone"></i> Restaurant Phone Number </label>
<input type="text" id="tfRestaurantPhoneNumber" name="tfRestaurantPhoneNumber" value="%s"  required="required" />

<label for="file"><i class="fa fa-phone"></i> Image </label>
<input id="file" name="file" type="file" accept="image/*" value="../../upload/restaurant-photo/restaurant-photo-ID-%s" %s /><br />
<img src="../../upload/restaurant-photo/restaurant-photo-ID-%s" height="150" width="150" /><br /><br /><br />

<div id="map"></div>
<div class='pointer'><< Click search button</div>
<label for="tfLatitude"><i class="fa fa-address-book"></i> LatLng </label>
Latitude: <input type="text" id="tfLatitude" name="tfLatitude" pattern="\d+(\.\d+)?" value="%s" required="required" /> <br />
Longitude: <input type="text" id="tfLongitude" name="tfLongitude" pattern="\d+(\.\d+)?" value="%s" required="required" />   <br />     

<label>Restaurant status: </label>
<input type="radio" id="Enable" name="activate" value="1" required="required" %s /> Enable

<input type="radio" id="Disable" name="activate" value="0" required="required" %s /> Disable
                               

EOD;


                printf($form, $RestaurantID, $RestaurantName, $RestaurantAddress, $RestaurantPhone, $RestaurantID, $exist, $RestaurantID, $RestaurantLatitude, $RestaurantLongitude, $enchecked, $dischecked);

                mysqli_free_result($result);
                ?>
                <center>
                    <input type="submit" class="btn" value="Submit">
                </center>

            </form>


        </div>

        <?php
            include_once('./footer.php');
        ?>
        
        <script type="text/javascript">
            $("#tfRestaurantDistrict").children().each(function(){
    if ($(this).text()=="<?=$RestaurantDistrict?>"){
        //jQuery給法
        $(this).attr("selected", "true"); //或是給"selected"也可

        //javascript給法
        this.selected = true; 
    }
});
        </script>
</body>

</html>