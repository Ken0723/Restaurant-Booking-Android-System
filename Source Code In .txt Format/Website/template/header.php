<div id="flex-container">
        <div>
            <span id="small-font" class="font-setting" style="font-size: 17px;"> A </span> <span id="medium-font" class="font-setting" style="font-size: 26px;"> A </span><span id="large-font" class="font-setting" style="font-size: 32px;"> A </span>
        </div>
        <div id="header" align="center">
            <div class="menu">
                <ul>

                    <li><a href="./index.php">Home</a></li>
                    
					<li><a href="./downloadapp.php">Download Mobile APP</a></li>
                    <?php
                    if (!isset($_SESSION["login_user"])) {
                        echo '<li style="float:right"><a href="./login.html">Login</a></li>';
                        print('<li style="float:right"><a href="./join_us.php">Join Us</a></li>');
                    } else {

                        echo '<li style="float:right"><a href="./logout.php">Logout</a></li>';
                        if ($_SESSION["role"] != "admin") {
                            echo '<li style="float:right"><a href="./viewUserProfile.php">User Profile</a></li>';
                        }
                        
                        if ($_SESSION["role"] == "resadmin") {
                            print('<li style="float:right"><a href="./restaurant/admin/index.php">Restaurant administrator Menu</a></li>');
                        } else if ($_SESSION["role"] == "res") {
                            print('<li style="float:right"><a href="./restaurant/index.html">Operator Menu</a></li>');
                        } else if ($_SESSION["role"] == "user") {
							print('<li style="float:right"><a href="./user/index.html">User Menu</a></li>');
						} else if ($_SESSION["role"] == "admin") {
							print('<li style="float:right"><a href="./admin/index.php">Administrator Menu</a></li>');
						}
                    }
                    ?>

                </ul>

            </div>
        </div>