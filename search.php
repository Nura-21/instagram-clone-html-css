<?php

require_once "config.php";

session_start();

$searchErr = '';
$search_details='';

if(isset($_POST['search_submit']))
{
    if(!empty($_POST['search']))
    {
        $search = $_POST['search'];

        $sql = "SELECT user_name, avatar, description FROM user WHERE user_name LIKE '%$search%'";
        $result = mysqli_query($link, $sql);
        $search_details = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $_SESSION['search_details'] = $search_details;

        header("location: search_results.php");

    }
    else
    {
        $searchErr = "Совпадений не найдено";
        $_SESSION['searchErr'] = $searchErr;
        header("location: search_results.php");

    }

}


?>