<?php
    session_start();
?>

<!DOCTYPE html>
<html>
 <head>
        <meta charset="utf-8">
        <title>Satya's Bank</title>
        <link rel="stylesheet" href="css/style.css">
 </head>
 <body>
    <nav>

        <div id="topbanner"></div>

        <div id="web_name">
            <h1>Satya's Bank</h1>
        </div>
        
        <div id="wrapper">
            <ul id="ul_layer" style="position: fixed; top:3%; left:40%;">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <?php
                    if(isset($_SESSION["useruid"])) {
                        echo "<li><a href='transfer.php'>Transfer Page</a></li>";
                        echo "<li><a href='profile.php'>Profile Page</a></li>";
                        echo "<li><a href='includes/logout.inc.php'>Log Out</a></li>";
                    }
                    else {
                        echo "<li><a href='signup.php'>Sign Up</a></li>";
                        echo "<li><a href='login.php'>Log In</a></li>";
                    }
                ?>
                
                
            </ul>
        </div>
    </nav>