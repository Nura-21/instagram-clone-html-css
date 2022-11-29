<?php
require_once "config.php";

session_start();

// check if user is logged in or not

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// image data

$caption = trim($_POST['caption']);
$created_at = date('Y-m-d H:i:s');
$user_id = $_SESSION['id'];

if (isset($_POST["submit"])) {
    if (!empty($_FILES["image"]["name"])) {
        $file_name = basename($_FILES["image"]["name"]);
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($file_type, $allowTypes)) {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

            // insert image data into database
            $sql = "INSERT INTO `post` (`caption`, `photo`, `created_at`, `user_id`) VALUES ('" .
                $caption . "', '" .
                $imgContent . "', '" .
                $created_at . "', '" .
                $user_id . "')";


            mysqli_query($link, $sql);
            header("location: profile.php");

        }


    }
}


?>