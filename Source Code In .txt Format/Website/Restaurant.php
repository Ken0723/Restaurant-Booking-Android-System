<?php
    require_once './checkLogin.php';
    
    require_once('./conn.php');

    $sql = "SELECT * FROM restaurant WHERE ID = '$_GET[restaurantID]'";
    $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $rc = mysqli_fetch_assoc($rs);
    $Name = $rc['Name'];
    $District = $rc['District'];
    $Address = $rc['Address'];
    $Phone = $rc['Phone'];
    $Latitude = $rc['Latitude'];
    $Longitude = $rc['Longitude'];
    
?>

<!DOCTYPE html>

<html>

<head>

    <title><?=$Name?></title>

    <meta http-equiv="Content-Type" content="text/html; charset=uit-8">

    <link rel="stylesheet" href="./css/myStyle.css" />
    <link rel="stylesheet" href="./css/layout.css" />
    <link rel="stylesheet" href="./css/viewRestaurant.css" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment.js'></script>


    <script>
            var name = "";
    var comment = "";

    function addComment() {
        var name = document.getElementById("name").value;
        var comment = document.getElementById("comment").value;

        var name2 = document.getElementById("name");

        if (name == "" || comment == "") {
            if (name == "") {
                document.getElementById("name").value = "Please enter your name";
                document.getElementById("name").style.color = "red";
            }
            if (comment == "") {
                document.getElementById("comment").value = "Please enter your comment";
                document.getElementById("comment").style.color = "red";
            }
        } else if (
            name == "Please enter your name" ||
            comment == "Please enter your comment"
        ) {
            name2.style.color = "black";
        } else {
            var d = new Date($.now());
            var now = moment().format("d/M/Y h:mm:ss A");
            name.bold();
            var radioValue = $("input[name='rate']:checked").val();

            $.ajax({
                async: false,
                type: "POST", //傳送方式
                url: "./updateComment.php", //傳送目的地
                dataType: "html", //資料格式
                data: { //傳送資料
                    RestaurantID: '<?=$_GET["restaurantID"]?>', 
                    UserID: '<?=$_SESSION["user_id"]?>',
                    Name: name,
                    Comment: comment,
                    DateTime: now,
                    Rating: radioValue
                },
                success: function(response) {
                    location.reload();
                },
                error: function(jqXHR) {
                    alert('Ajax request Error' + jqXHR);
                }
            });
            

        }

        // $("#commentTable").append("<tr><td class='dateTable'>"+d.toDateString()+"</td><td class='comName'>"+name+"</td></tr><tr><td class='comCom'>"+comment+"</td></tr>");

        // $("#commentArea").append("<div class='panel-heading'>"+name+"</div>");

        // var txt2 = $("<div class='panel-heading'></div>").text(name);
        //$("#resultsPanel").append("<tr><td>"+name+"</td><td style='text-align:'right''>"+comment+"</td></tr>");
        //var txt3 = $("<div class='panel-body'></div>").text(comment);
        //var txt4 = $("<div class='panel-footer'>Panel Footer</div>").text(d.toDateString())
        //$("#results").append(txt2, txt3, txt4);
    }
    </script>
    <script src="./Favorite.js"></script>
    <script src="./Font-Size-Setting.js"></script>

    <!--Map Script!-->
    <link href='https://fonts.googleapis.com/css?family=Love+Ya+Like+A+Sister' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./Map/leaflet.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="./Map/leaflet.js"></script>
    <script>
        $(document).ready(function() {
            var map;

            map = new L.Map("map", {
                zoomControl: true
            });

            L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: ' <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
                maxZoom: 19,
                minZoom: 12
            }).addTo(map);
            map.attributionControl.setPrefix(""); // Don't show the 'Powered by Leaflet' text.

            var loc_center = new L.LatLng('<?=$Latitude?>', '<?=$Longitude?>');
            map.setView(loc_center, 19);

            var marker = L.marker(['<?=$Latitude?>', '<?=$Longitude?>']).addTo(map);
            marker.bindPopup("<b><?=$Name?></b><br> <?=$Address?> <br>").openPopup();

            var popup = L.popup();

            function onMapClick(e) {
                popup
                    .setLatLng(e.latlng)
                    .setContent("You clicked the map at <br />" + e.latlng.toString())
                    .openOn(map);
            }

            map.on("click", onMapClick);
        });
    </script>
    <!--Map Script!-->

    <script>
        jQuery.expr[':'].icontains = function(a, i, m) {
            return jQuery(a).text().toUpperCase()
                .indexOf(m[3].toUpperCase()) >= 0;
        };
    </script>




    <script>
        var tag = '';
        var packageFilter = '';
        var locationFilter = '';
        var cuisineFilter = '';
        var dishFilter = '';

        $(document).ready(function() {

            $(".search-criteria .tag").click(function() {
                $(this).css("background-color", '#ff0000').siblings('span').css("background-color", '#3e3e48');
            });

            $('.search').on('click', '.reset-tag', function() {

                var value = $('#filter').val().toLowerCase();
                $(".menu-container-cell .menu-container").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
                locationFilter = '';
                cuisineFilter = '';
                dishFilter = '';
                packageFilter = '';
                $('.search').find('.tag').css("background-color", '#3e3e48');
            });

            $('.search-criteria').on('click', '.tag', function() {
                locationFilter = ($(this).data('location') !== undefined) ? $(this).data('location') : locationFilter;
                cuisineFilter = ($(this).data('cuisine') !== undefined) ? $(this).data('cuisine') : cuisineFilter;
                dishFilter = ($(this).data('dish') !== undefined) ? $(this).data('dish') : dishFilter;
                packageFilter = ($(this).data('package') !== undefined) ? $(this).data('package') : packageFilter;

                $('.menu-container-cell .menu-container').hide().filter(':icontains(' + $('#filter').val() + ')').filter(':contains(' + packageFilter + ')').show();

            });


            $("#filter").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".menu-container-cell").filter(function() {
                    $(this).toggle($(this).find(".menu-container").text().toLowerCase().indexOf(value) > -1);
                });
            });


            $("#btnSearch").click(function() {

                $('.content-cell-wrapper').hide().filter(':icontains(' + $('#filter').val() + ')').filter(':contains(' + locationFilter + ')').filter(':contains(' + cuisineFilter + ')').filter(':contains(' + dishFilter + ')').show();
                //alert($('.content-cell-wrapper').filter(':icontains(S)').filter(':contains(�y)').filter(':contains(��)').filter(':contains(�s)').html());
            });

            $('tr:odd').addClass('striped');

            $('tr').mouseover(function() {
                $(this).addClass('over');
            }).mouseout(function() {
                $(this).removeClass('over');
            });

            $('input:text').keyup(function() {
                $('tr:gt(0)').hide().filter(':contains(' + $('#filter').val() + ')').show();
            });
        });
    </script>

    <style type="text/css">
        #map {
            height: 20%;
            width: 100%;
        }

        #favorite-container {
            margin: 20px 0;
            width: 100%;
            position: relative;

            background: #333;
            border: 1px inset;
            box-shadow: 5px 5px 5px #888888;
        }

        #header2 {
            background: #ccc;
            padding: 20px;
        }

        #content {
            padding: 5px 20px 10px 20px;
        }

        #a {
            display: block;
            width: 150px;
            height: 77px;
            background: #efffde;
        }

        #a:link {
            width: 150px;
            height: 77px;
        }

        #a:hover {
            height: 77px;
            background: #eff1de;
        }

        h2 {
            padding: 0;
            margin: 0;
            font-weight: 100;
            color: #333;
        }

        ul {
            padding: 0;
            margin: 0px;
            background-color: #ffffff;
        }


        .add-favorite-btn {
            border: none;
            background: none;
            color: #999;
            float: right;
            font-size: 150%;
        }

        .add-favorite-btn:hover {
            opacity: 0.7;
            color: #ff0000;
        }

        .remove-favorite-btn {
            border: none;
            background: none;
            color: #ff0000;
            float: right;
            font-size: 150%;
        }

        .remove-favorite-btn:hover {
            opacity: 0.7;
            color: #999;
        }

        .removebtn {
            border: none;
            background: none;
            color: #ff0000;
            float: right;
        }

        .removebtn:hover {
            opacity: 0.7;
        }

        ul li {
            list-style: none;
        }

        #favorite-links li {
            padding: 10px;
            border-bottom: 1px solid #ccc;

        }

        #favorite-links li:last-child {
            border: none;
        }

        #favorite-links a {
            color: #333;
            text-decoration: none;
        }

        #favorite-links li:hover {
            background: #ccc;
        }

        #add-link-form {
            display: none;
            background: #444;
            padding: 20px;
            color: #ccc;
        }

        #add-link-form input {
            margin: 5px 0;
            width: 250px;
            color: #333;
            padding: 5px;
            outline: none;
            border: none;
        }


        #new-link-button button,
        #add-link-form button {
            margin: 10px 0;
            background: #e74c3c;
            border: none;
            color: #fff;
            padding: 5px 15px;
            width: 100%;
            height: 35px;
        }

        /* ^Favorite */
        .reset-tag {
            background: #FF0000;
            padding: 10px;
            color: #FFF;
            cursor: pointer;
            border-radius: 10px;
            margin: .5em;
            float: left;
            display: inline-block;
        }

        .tag:hover,
        .reset-tag:hover {
            opacity: 0.5;
        }

        .app-container {
            position: relative;
            width: 100%;
            height: auto;
            margin: 0 auto;
            padding: 0px;
        }

        .app-container .tag {
            padding: 10px;
            background-color: #fff;
            cursor: pointer;
            border-radius: 10px;
            margin: .5em;
            float: left;
            display: inline-block;
        }

        .app-container .search {
            position: relative;
            top: 0px;
            border: 1px solid #fff;
            width: 100%;
            hegith: 4em;
            background-color: #fff;
        }

        .app-container .search .tag:hover span {
            display: none;
        }

        .app-container .search .tag {
            background-color: #3e3e48;
            color: #fff;
        }

        .app-container .search .search-criteria {
            position: relative;
            /*float: left;*/
            display: inline-block;
            width: 100%;
            background-color: #eaeaff;
            margin-bottom: 20px;
        }

        .app-container .search .search-bar {
            display: inline-block;
            position: relative;
            width: 100%;
            height: 4em;
            float: left;

            background-color: #fff;
            padding-left: 2.5em;
        }

        .btn {
            width: 100%;
        }

        .navdown {
            background-color: #ff0000;
            border: 1px solid #F00;
        }

        table {
            background-color: black;
            border: 1px black solid;
            border-collapse: collapse;
        }

        th {
            border: 1px outset silver;
            background-color: #DAA520;
            color: white;
        }

        tr {
            background-color: #FFFFCE;
            margin: 1px;
        }

        tr.striped {
            background-color: #FFFF66;
        }

        tr.over {
            background-color: gold;
        }

        td {
            padding: 1px 8px;
        }

        .jumbotron {

            text-align: center;
        }

        td {
            padding: .4em;
        }

        .comName {
            width: 70%;
            text-align: 'left';
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        .dateTable {
            width: 30%;
        }

        .nameTag {
            font-weight: "bold";
        }

        .checked {
            color: orange;
        }

        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            display: none;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }

        .btn {
            width: 175px;
            height: 35px;
        }

        #map {
            height: 600px;
        }
    </style>


<script>
        window.onload = function() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd
            }
            if (mm < 10) {
                mm = '0' + mm
            }
            today = yyyy + '-' + mm + '-' + dd;
            var startDate = document.getElementById("startDate");
            var endDate = document.getElementById("endDate");
            startDate.min = today;
            endDate.min = today;
        }
    </script>
</head>

<body>
    <?php
            include_once('./template/header.php');
        ?>


        <div id="nav">

            <h3> Search </h3>

            <div class="app-container">
                <div class="search">
                    <input type="text" id="filter" class="search-bar" placeholder="Search menu keywords..." />

                    <br />
                    <label>Tag: </label>
                    <br />
                    <hr />
                    <span class="reset-tag">Reset Tag</span>
                    <br /><br /><br />
                    <hr /><br />

                    <div class="search-tag">
                        Meal: <br />
                        <div class="search-criteria">
                            <div class="packageFilter">

                                <span class="tag" data-package="Breakfast">Breakfast</span>
                                <span class="tag" data-package="Lunch">Lunch</span>
                                <span class="tag" data-package="Tea buffet">Tea buffet</span>
                                <span class="tag" data-package="Dinner">Dinner</span>
                                <span class="tag" data-package="Drink">Drink</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div id="main">
            <div>
                <h1><b><?=$Name?></b></h1>
                
                <hr />

            <center>
                <h1>Book Table</h1>
            </center>
            <form method="POST" action="bookedcheck.php">
                <label for="TableNumber"><i class="fa fa-user-o"></i> Number of people </label>
                <select id='tablenum' name='tablenum'>
                    <?php
                    $sql = "SELECT TableNum FROM restauranttable WHERE RestaurantID=$_GET[restaurantID] and status = 'available' Order By TableNum ASC";
                    $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    if (mysqli_num_rows($rs) > 0) {
                        while ($rc = mysqli_fetch_assoc($rs)) {
                            printf('<option>%s</option>', $rc['TableNum']);
                        }
                    } 
                    else {
                        printf('<option>%s</option>', 'Currently no empty seats');
                    }
                    ?>
                </select><br /> <br />
                <label for="TableNumber"><i class="fa fa-calendar"></i> ReservationDate </label>
                <input type="date" name="sDate" id="startDate" oninvalid="this.setCustomValidity('Please set the start date!')" oninput="this.setCustomValidity('')" required="required">
                <br /> <br />
                <label for="TableNumber"><i class="fa fa-clock-o"></i> ReservationTime </label>
                <select id='sTime' name='sTime'>
                    <option>13:00:00</option>
                    <option>15:00:00</option>
                    <option>17:00:00</option>
                    <option>19:00:00</option>
                    <option>21:00:00</option>
                </select><br /> <br />
                <label for="TableNumber"><i class="fa fa-credit-card"></i> Payment Method </label>
                <input type='radio' name='paymenttype' value='Paypal'> <i class="fa fa-credit-card-alt"></i> Credit Card &nbsp;&nbsp; <input type='radio' name='paymenttype' value='Cash'> <i class="fa fa-money"></i> Cash
                <br /><br />
                <font color='red'>**You should choose one method to pay after you finished your service</font>
                <br /> <br />
                <input type="hidden" id="RestaurantID" name="RestaurantID" value="<?=$_GET['restaurantID']?>" />
                <center>
                    <input type="submit" class="btn" value="Book Table">
                </center>
            </form>
                <hr />

                <h2><b> Telephone </b></h2>
                <?=$Phone?>

                <hr />

                <h2><b> Opening Hours </b></h2>
                Today <div class="right">06:30 - 00:30</div><br /><br /><br />
                Mon - Sun <div class="right">06:30 - 00:30</div>
                <hr />
                <h2> <b>Address</b> </h2>
                <?=$Address?> <br />
                <hr />
            </div>
            <h2>Address with map: </h2>
            <div id="map"></div>
            </hr>
            <h2><b>Menu:</b></h2>
            <div class="menu-container-cell">
                <div class="menu-container">
                    <h3 id="ct1" class="title-name"><a href="#ct1">Breakfast</a> <button class="add-favorite-btn">&#x2661;</button></h3>
                    <table>
                        <tr>
                            <th>Code</th>
                            <th>Food</th>
                            <th>Price</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM fooditem WHERE RestaurantID='$_GET[restaurantID]' and FoodCategory='Breakfast' Order By Code ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                        
                        while ($rc = mysqli_fetch_assoc($rs)) {


                            printf('<tr>
                                    <td> %1$s </td>
                                    <td> %2$s </td>
                                    <td> $ %3$s </td>
                            </tr>', $rc['Code'], $rc['Name'], $rc['PriceEach']);
                        }
                        ?>
                    </table>
                </div>

                <hr />




                <div class="menu-container">
                    <h3 id="ct3" class="title-name"><a href="#ct3">Lunch</a> <button class="add-favorite-btn">&#x2661;</button></h3>
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Food</th>
                            <th>Price</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM fooditem WHERE RestaurantID='$_GET[restaurantID]' and FoodCategory='Lunch' Order By Code ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                        
                        while ($rc = mysqli_fetch_assoc($rs)) {


                            printf('<tr>
                                    <td> %1$s </td>
                                    <td> %2$s </td>
                                    <td> $ %3$s </td>
                            </tr>', $rc['Code'], $rc['Name'], $rc['PriceEach']);
                        }
                        ?>

                    </table>
                </div>

                <hr />

                <div class="menu-container">
                    <h3 id="ct4" class="title-name"><a href="#ct4">Tea buffet</a> <button class="add-favorite-btn">&#x2661;</button></h3>
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Food</th>
                            <th>Price</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM fooditem WHERE RestaurantID='$_GET[restaurantID]' and FoodCategory='Tea buffet' Order By Code ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                        
                        while ($rc = mysqli_fetch_assoc($rs)) {


                            printf('<tr>
                                    <td> %1$s </td>
                                    <td> %2$s </td>
                                    <td> $ %3$s </td>
                            </tr>', $rc['Code'], $rc['Name'], $rc['PriceEach']);
                        }
                        ?>
                    </table>
                </div>

                <hr />

                <div class="menu-container">
                    <h3 id="ct5" class="title-name"><a href="#ct5">Dinner</a> <button class="add-favorite-btn">&#x2661;</button></h3>
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Food</th>
                            <th>Price</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM fooditem WHERE RestaurantID='$_GET[restaurantID]' and FoodCategory='Dinner' Order By Code ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                        
                        while ($rc = mysqli_fetch_assoc($rs)) {


                            printf('<tr>
                                    <td> %1$s </td>
                                    <td> %2$s </td>
                                    <td> $ %3$s </td>
                            </tr>', $rc['Code'], $rc['Name'], $rc['PriceEach']);
                        }
                        ?>
                    </table>
                </div>
                
                <div class="menu-container">
                    <h3 id="ct5" class="title-name"><a href="#ct5">Drink</a> <button class="add-favorite-btn">&#x2661;</button></h3>
                    <table>
                        <tr>
                            <th>No.</th>
                            <th>Drink</th>
                            <th>Price</th>
                        </tr>
                        <?php
                        $sql = "SELECT * FROM fooditem WHERE RestaurantID='$_GET[restaurantID]' and FoodCategory='Drink' Order By Code ASC";
            $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                        
                        while ($rc = mysqli_fetch_assoc($rs)) {


                            printf('<tr>
                                    <td> %1$s </td>
                                    <td> %2$s </td>
                                    <td> $ %3$s </td>
                            </tr>', $rc['Code'], $rc['Name'], $rc['PriceEach']);
                        }
                        ?>
                    </table>
                </div>

            </div>



<?php
if ($_SESSION["role"] == 'user') {
    
?>
            <form class="form">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $_SESSION['login_user'] ?>" disabled="disabled" /><br />
                    <label for="comment">Comment:</label>
                    <textarea class="form-control" rows="5" id="comment" style="width: 100%;" required="required"></textarea>
                    <br />
                    <label class="left">Rating:</label>
                    <div class="rate">
                        <input type="radio" id="star5" name="rate" value="5" />
                        <label for="star5" title="5">5 stars</label>
                        <input type="radio" id="star4" name="rate" value="4" />
                        <label for="star4" title="4">4 stars</label>
                        <input type="radio" id="star3" name="rate" value="3" />
                        <label for="star3" title="3">3 stars</label>
                        <input type="radio" id="star2" name="rate" value="2" />
                        <label for="star2" title="2">2 stars</label>
                        <input type="radio" id="star1" name="rate" value="1" />
                        <label for="star1" title="1">1 star</label>
                    </div><br />
                </div>
            </form>
            <br />
            <center>
                <button onclick='addComment();' id="myBtn" class="btn">Submit</button>
            </center>
            <p id="warning"></p>

<?php
}
?>



            <div class="col-sm-10">
                <table id="resultTable" class="table-striped">
                    <tbody id="resultBody">
                        <?php
                            $sql = "SELECT * FROM comments WHERE RestaurantID='$_GET[restaurantID]'";
        $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        while ($rc = mysqli_fetch_assoc($rs)) {
            $ID = $rc['ID'];
            $RestaurantID = $rc['RestaurantID'];
            $UserID = $rc['UserID'];
            $Name = $rc['Name'];
            $Comment = $rc['Comment'];
            $DateTime = $rc['DateTime'];
            $Rating = $rc['Rating'];
            
            $rating = "";
            $i = 0;
            for ($i = 0; $i < $Rating; $i++) {
                $rating .= '<span class="fa fa-star checked"></span>';
            }

            for ( $j = 5 - $i; $j > 0; $j--) {
                $rating .= '<span class="fa fa-star"></span>';
            }
    printf(
    '<tr><td class="nameTag" style="font-weight: bold;">
    %s says &nbsp;&nbsp;&nbsp;%s
    </td>
    <td>%s</td>
    </tr>
    <tr><td colspan="2">%s</td></tr>'
    ,$Name,$rating,$DateTime,$Comment
    );
}
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive">
            </div>




        </div>


<!--
        <input type="botton" id="showbox-btn" class="btn fixed" value="Show the box" />
        <div id="aside" class="fixed">

            <div id="favorite-container">
                <input type="botton" id="hidebox-btn" class="btn" value="Hide the box" />
                <div id="header2">
                    <h2>
                        My Favorite Menus
                    </h2>
                    <small>save your best menus</small>
                </div>
                <div id="content">
                    <ul id="favorite-links">

                    </ul>

                </div>

            </div>
        </div>
-->
        <?php
            include_once('./template/footer.php');
        ?>

    </div>
</body>

</html>