<?php
require_once "config.php";
require "functions/functions.php";

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$id = $_SESSION['id'];

$recommended_user_id = intval($_GET['recommended']);
if(isset($_POST['subscribe'])){
    subscribe($link, $id, $recommended_user_id);
    header("Location: index.php");
}


?>