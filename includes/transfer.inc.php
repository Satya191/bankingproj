<?php

session_start();
if(!isset($_POST["submit"])) {
    header("location: ../index.php");
    exit();
}
$depuid = $_POST["uid"];
$amt = (int) $_POST["amt"];

if(empty($amt) || empty($depuid)) {
    header("location: ../transfer.php?error=emptyinput");
        exit();
}
else if($amt <= 0) {
    header("location: ../transfer.php?error=lessthanzero");
        exit();
}

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

$username = $_SESSION["useruid"];

transferMoney($conn, $amt, $username, $depuid);