<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<head>
    <title>Register</title>
    <link rel="stylesheet" href="./css/style2.css" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        input[type=submit] {
            background-color: #6B8E23;
        }

        body {
            background-image: url("./images/PPMnOZM.jpg");
            background-repeat: no-repeat;
            font-family: Arial;
            font-size: 17px;
            padding: 8px;
        }
    </style>
    <script>
        function checkForm() {
            if (document.getElementById("regEmail").value == "") {
                alert("Enter Dealer ID, please!");
                return false;
            } else if (document.getElementById("regLastname").value == "") {
                alert("Enter Lastname, please!");
                return false;
            } else if (document.getElementById("regFirstname").value == "") {
                alert("Enter Firstname, please!");
                return false;
            } else if (document.getElementById("regPhone").value == "") {
                alert("Enter Phone Number, please!");
                return false;
            } else if (document.getElementById("regAddress").value == "") {
                alert("Enter Address, please!");
                return false;
            } else if (document.getElementById("regPassword").value == "") {
                alert("Enter Password, please!");
                return false;
            }
            return true;

        }
    </script>
</head>

<body>
    <center>
        <h1> PPM </h1>
        <b>User Register Page</b></h2>
        <div class="login-page">
            <div class="form">
                <form class="register-form" method="post" onsubmit="return checkForm();" action="./SubmitRegister_User.php">
                    <input type="email" name="regEmail" id="regEmail" placeholder="Email" required="required" />
                    <input type="text" name="regLastname" id="regLastname" placeholder="Lastname" required="required" />
                    <input type="text" name="regFirstname" id="regFirstname" placeholder="Firstname" required="required" />
                    <input type="password" name="regPassword" id="regPassword" placeholder="Password" required="required" />
                    <input type="tel" name="regPhone" id="regPhone" placeholder="Phone Number" pattern="[0-9]{8}" required="required" />
                    <small>Phone Number Format must be: 12345678</small><br><br>
                    <input type="text" name="regAddress" id="regAddress" placeholder="Address" required="required" />

                    <input type="submit" class="btn" value="Create" />
                    <p class="message">Already registered? <a href="./login.html">Sign In</a></p>
                </form>

            </div>
        </div>

</body>

</html>