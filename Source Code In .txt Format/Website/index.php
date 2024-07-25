<?php
    header("Content-Type:text/html; charset=utf-8");
    session_start();
?>
<!DOCTYPE html>

<html>

<head>
    <title>Index</title>
    <meta charset="UTF-8" />
    
    <link rel="stylesheet" href="./css/myStyle.css" />
    <link rel="stylesheet" href="./css/layout.css" />
    <link rel="stylesheet" href="./css/viewRestaurant.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        jQuery.expr[':'].icontains = function(a, i, m) {
            return jQuery(a).text().toUpperCase()
                .indexOf(m[3].toUpperCase()) >= 0;
        };
    </script>

    <script src="./Favorite.js"></script>

    <script>
        var tag = '';
        var locationFilter = '';
        var cuisineFilter = '';
        var dishFilter = '';

        $(document).ready(function() {

            $(".search-criteria .tag").click(function() {
                $(this).css("background-color", '#ff0000').siblings('span').css("background-color", '#3e3e48');
            });

            $('.search').on('click', '.reset-tag', function() {
                var value = $('#filter').val().toLowerCase();
                $(".content-cell-wrapper").filter(function() {
                    $(this).toggle($(this).find(".title-name a").text().toLowerCase().indexOf(value) > -1);
                });
                locationFilter = '';
                cuisineFilter = '';
                dishFilter = '';
                $('.search').find('.tag').css("background-color", '#3e3e48');
            });

            $('.search-criteria').on('click', '.tag', function() {
                locationFilter = ($(this).data('location') !== undefined) ? $(this).data('location') : locationFilter;
                cuisineFilter = ($(this).data('cuisine') !== undefined) ? $(this).data('cuisine') : cuisineFilter;
                dishFilter = ($(this).data('dish') !== undefined) ? $(this).data('dish') : dishFilter;

                $('.content-cell-wrapper').hide().filter(':icontains(' + $('#filter').val() + ')').filter(':contains(' + locationFilter + ')').filter(':contains(' + cuisineFilter + ')').filter(':contains(' + dishFilter + ')').show();
            });


            $("#filter").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                locationFilter = ($(this).data('location') !== undefined) ? $(this).data('location') : locationFilter;
                cuisineFilter = ($(this).data('cuisine') !== undefined) ? $(this).data('cuisine') : cuisineFilter;
                dishFilter = ($(this).data('dish') !== undefined) ? $(this).data('dish') : dishFilter;
                $(".content-cell-wrapper").filter(function() {
                    $(this).toggle($(this).filter(':contains(' + locationFilter + ')').filter(':contains(' + cuisineFilter + ')').filter(':contains(' + dishFilter + ')').find(".title-name a").text().toLowerCase().indexOf(value) > -1);
                });
            });

            /*$("#filter").keyup(function () {
             
             $('.content-cell-wrapper').hide().filter(':icontains(' + $('#filter').val() + ')').filter(':contains(' + locationFilter + ')').filter(':contains(' + cuisineFilter + ')').filter(':contains(' + dishFilter + ')').show();
             //alert($('.content-cell-wrapper').filter(':icontains(S)').filter(':contains(�y)').filter(':contains(��)').filter(':contains(�s)').html());
             });*/

            $("#btnSearch").click(function() {

                $('.content-cell-wrapper').hide().filter(':icontains(' + $('#filter').val() + ')').filter(':contains(' + locationFilter + ')').filter(':contains(' + cuisineFilter + ')').filter(':contains(' + dishFilter + ')').show();
                //alert($('.content-cell-wrapper').filter(':icontains(S)').filter(':contains(�y)').filter(':contains(��)').filter(':contains(�s)').html());
            });

            $("#small-font").click(function() {
                $('body').find("*").not(".font-setting").not("input").css("font-size", '17px');
                $('body').find("#main a").css("font-size", '30px');
            });

            $("#medium-font").click(function() {
                $('body').find("*").not(".font-setting").not("input").css("font-size", '22.5px');
                $('body').find("#main a").css("font-size", '30px');
            });

            $("#large-font").click(function() {
                $('body').find("*").not(".font-setting").not("input").css("font-size", '26px');
                $('body').find("#main a").css("font-size", '30px');
            });

        });
    </script>
    <style type="text/css">
        #map {
            height: 20%;
            width: 20%;
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
            font-size: 110%;
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
            font-size: 110%;
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

        .displaynone {
            display: none;
        }

        .font-setting:hover {
            opacity: 0.5;
        }

        .font-setting {
            padding: 5px;
            background-color: #fff;
            cursor: pointer;
            border-radius: 7px;
            margin: 0 0 0 .5em;
            float: left;
            display: inline-block;
            height: auto;
        }

        .font-setting {
            background-color: #3e3e48;
            color: #fff;
        }

        #main {
            width: 100%;
        }

        .btn {
            width: 175px;
            height: 35px;
        }
    </style>
</head>

<body>

    <?php
            include_once('./template/header.php');
        ?>

        <!--
        <div id="nav">
            
            <h3>Search</h3>

            <div class="app-container">
                <div class="search">
                    <input type="text" id="filter" class="search-bar" placeholder="Search restaurant by name" />
                    <br />
                    Tag: <br />
                    <hr />
                    <span class="reset-tag">Reset Tag</span>
                    <br /><br /><br />
                    <hr /><br />

                    <div class="search-tag">
                        ��m: <br />
                        <div class="search-criteria">
                            <div class="locationFilter">

                                <span class="tag" data-location="�y�F�C">�y�F�C</span>
                                <span class="tag" data-location="���r�W">���r�W</span>
                                <span class="tag" data-location="����">����</span>

                            </div>

                        </div>

                        <hr /><br />

                        �榡: <br />
                        <div class="search-criteria">

                            <div class="cuisineFilter">
                                <span class="tag" data-cuisine="�覡">�覡</span>
                                <span class="tag" data-cuisine="�����">�����</span>
                                <span class="tag" data-cuisine="�����">�����</span>
                            </div>

                        </div>

                        <hr /><br />

                        ���~ / �\�U����: <br />
                        <div class="search-criteria">

                            <div class="dishFilter">
                                <span class="tag" data-dish="�s">�s</span>
                                <span class="tag" data-dish="�~���]">�~���]</span>
                                <span class="tag" data-dish="��������">��������</span>
                            </div>

                        </div>

                    </div>

                </div>

            
        </div>

    </div>!-->
    <div id="main">
        <?php
        if (isset($_SESSION["login_user"])) {
            $displaynone = "";
        } else {
            $displaynone = "displaynone";
        }
        ?>

        <?php
        require_once('./conn.php');

        $sql = "SELECT * FROM restaurant WHERE Enable=1";
        $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        while ($rc = mysqli_fetch_assoc($rs)) {
            $ID = $rc['ID'];
            $Name = $rc['Name'];
            $District = $rc['District'];
            $Address = $rc['Address'];
            $Phone = $rc['Phone'];
        
        ?>
        <div class="content-cell-wrapper">

            <div class="content-wrapper">

                <div class="title-wrapper">
                    <h2 class="title-name">
                        <a href="./Restaurant.php?restaurantID=<?=$ID?>"><?=$Name?></a> <!--<button class="add-favorite-btn <?php echo $displaynone ?>"><i class="material-icons">favorite_border</i></button>-->
                    </h2>
                </div>

                <div class="details-wrapper">
                    <div class="left left-content-container">
                        <a href="./ThePlace.php" class="door-photo-wrapper">
                            <!-- DoorPhoto.Url -->

                            <img class="left-restaurant-photo" src="upload/restaurant-photo/restaurant-photo-ID-<?=$ID?>" alt="restaurant-photo" />

                        </a>
                    </div>

                    <div class="central-content-container">

                        <div class="info-wrapper">

                            <div class="info-address">
                                <i class="material-icons">room</i>

                                <span>
                                    <?=$Address?>
                                    <div id="map"></div>
                                </span>


                            </div>


                            <!--<div class="info-tag">
                                <i class="material-icons">local_offer</i>
                                <span>Western / Hotel Restaurant</span>

                            </div>-->

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <?php
            
            }
        ?>
<!--
        <div class="content-cell-wrapper">

            <div class="content-wrapper">

                <div class="title-wrapper">
                    <h2 class="title-name">
                        <a href="./Burgeroom.php">Burgeroom</a> <button class="add-favorite-btn <?php echo $displaynone ?>"><i class="material-icons">favorite_border</i></button>
                    </h2>
                </div>

                <div class="favorite-wrapper">

                </div>

                <div class="details-wrapper">
                    <div class="left left-content-container">
                        <a href="./Burgeroom.php" class="door-photo-wrapper">


                            <img class="left-restaurant-photo" src="https://static6.orstatic.com/userphoto/photo/H/DGV/02NS2P8722A9BECCBEEA59tx.jpg" alt="restaurant-photo" />

                        </a>
                    </div>

                    <div class="central-content-container">

                        <div class="info-wrapper">

                            <div class="info-address">
                                <i class="material-icons">room</i>

                                <span>
                                    Shop D, G/F, Food Street, 50-56 Paterson Street, Fashion Walk, Causeway Bay
                                </span>

                            </div>


                            <div class="info-tag">
                                <i class="material-icons">local_offer</i>
                                <span>American /
                                    Hamburger /
                                    Fast Food</span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="content-cell-wrapper">

            <div class="content-wrapper">

                <div class="title-wrapper">
                    <h2 class="title-name">
                        <a href="./YadlliePlate.php">Yadllie Plate</a> <button class="add-favorite-btn <?php echo $displaynone ?>"><i class="material-icons">favorite_border</i></button>
                    </h2>
                </div>

                <div class="favorite-wrapper">

                </div>

                <div class="details-wrapper">
                    <div class="left left-content-container">
                        <a href="./Burgeroom.php" class="door-photo-wrapper">

                            <img class="left-restaurant-photo" src="https://static5.orstatic.com/userphoto/photo/L/H4R/03DTYO66BC4451E9BDD098tx.jpg" alt="restaurant-photo" />

                        </a>
                    </div>

                    <div class="central-content-container">

                        <div class="info-wrapper">

                            <div class="info-address">
                                <i class="material-icons">room</i>

                                <span>
                                    11/F, CTMA Centre, 1 Sai Yeung Choi Street, Mong Kok
                                </span>

                            </div>


                            <div class="info-tag">
                                <i class="material-icons">local_offer</i>
                                <span>Korean /
                                    Korean Fried Chicken</span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>-->

    </div>

<?php
                    if (isset($_SESSION["login_user"])) {
                        if ($_SESSION["role"] == '') {
                        ?>
    <input type="bottom" id="showbox-btn" class="btn fixed" value="Show the box" />
    <div id="aside" class="fixed">

        <div id="favorite-container">
            <input type="bottom" id="hidebox-btn" class="btn" value="Hide the box" />
            <div id="header2">
                <h2>
                    My Favorite Restaurants
                </h2>
                <small>save your best restaurants</small>
            </div>
            <div id="content">
                <ul id="favorite-links">

                </ul>

            </div>

        </div>
    </div>
<?php
    }
}
?>
    <?php
            include_once('./template/footer.php');
        ?>

    </div>
</body>

</html>