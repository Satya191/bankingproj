<?php
session_start();
if(!isset($_SESSION["useruid"])) {
    header("location: ../index.php");
    exit();
}
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

$username = $_SESSION["useruid"];

$_SESSION["userBalance"] = getAmtMoney($conn, $username);

