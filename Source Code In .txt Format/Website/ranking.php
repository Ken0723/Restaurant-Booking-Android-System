<?php
header("Content-Type:text/html; charset=uit-8");
    require_once 'checkLogin.php';
    ?>
<!DOCTYPE html>

<html>

<head>
    <title>Ranking</title>
    
    <meta http-equiv="Content-Type" content="text/html; charset=big5">

    <link rel="stylesheet" href="./css/myStyle.css" />
    <link rel="stylesheet" href="./css/layout.css" />
    <link rel="stylesheet" href="./css/viewRestaurant.css" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment.js'></script>

    <script>
        $(document).ready(function() {
            $('tr:odd').addClass('striped');
            $('tr').mouseover(function() {
                $(this).addClass('over');
            }).mouseout(function() {
                $(this).removeClass('over');
            });
        });
    </script>
    <style type="text/css">
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
            content: '�� ';
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
    </style>



</head>

<body>
    <?php
            include_once('./template/header.php');
        ?>

        <div id="main">
            <table>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                </tr>
                <?php
                $json = file_get_contents("ranking.json");
                $obj = json_decode($json, true);
                arsort($obj);
                $i = 1;
                foreach ($obj as $key => $value) {
                    print("<tr><td>" . $i . "</td><td>");
                    print("<a href='" . $key . ".php'>" . $key . "</a>");
                    print("</td></tr>");
                    $i++;
                }
                ?>
            </table>
        </div>

        <?php
            include_once('./template/footer.php');
        ?>

    </div>
</body>

</html>