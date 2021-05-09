<?php

session_start();
if(!isset($_POST["submit"])) {
    header("location: ../index.php");
    exit();
}

$amt = (int) $_POST["amt"];

if(empty($amt)) {
    header("location: ../profile.php?error=emptyinput");
        exit();
}
else if($amt <= 0) {
    header("location: ../profile.php?error=lessthanzero");
        exit();
}

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

$username = $_SESSION["useruid"];

addMoney($conn, $amt, $username);