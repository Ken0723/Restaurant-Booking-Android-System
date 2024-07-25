<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<head>
    <title>Create Restaurant</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/FYP/css/myStyle.css" />
    <link rel="stylesheet" href="/FYP/css/layout.css" />

    <style>
        input[type=submit] {

        }

        body {
            background-repeat: no-repeat;
            font-family: Arial;
            font-size: 17px;
            padding: 8px;
        }
    </style>

</head>

<body>
    
        <div id="flex-container">
        <?php
            include_once('./header.php');
        ?>

        <div id="main">
            <div class="container">
            <center>    
            <div class="form">
                <h1>Create Restaurant</h1>
                <form class="register-form" method="post" action="./SubmitRegister_Res.php">
                    <input type="text" name="regResname" id="regResname" placeholder="Company / Restaurant name" required="required" />
                    <input type="email" name="regEmail" id="regEmail" placeholder="Email" required="required" />
                    <input type="text" name="regLastname" id="regLastname" placeholder="Lastname" required="required" />
                    <input type="text" name="regFirstname" id="regFirstname" placeholder="Firstname" required="required" />
                    <input type="submit" class="btn" value="Create" />
                </form>
            </center>
            </div>
            </div>
        </div>

        <?php
            include_once('./footer.php');
        ?>
        </div>

</body>

</html>