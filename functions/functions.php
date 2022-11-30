<?php
require_once "config.php";

function getCurrentUserData($link, $user_id) {
    $data = mysqli_query($link, "SELECT description, avatar FROM user WHERE user_id='$user_id LIMIT 1'");
    return mysqli_fetch_array($data);
}


function getFollowingsIds($link, $user_id)
{


    $ids_array = array();
    $result = mysqli_query($link, "SELECT following_id FROM follow where follower_id='$user_id'");
    while ($row = mysqli_fetch_array($result)) {
        $ids_array[] = $row['following_id'];
    }

    return array_map('intval', $ids_array);
}

function getFollowingsPosts($link, $user_ids)
{
    $ids = implode(',', $user_ids);
    $posts = mysqli_query($link, "SELECT p.photo, p.caption, u.user_name, u.avatar FROM post p JOIN user u ON p.user_id = u.user_id WHERE p.user_id IN ($ids)");
    return mysqli_fetch_all($posts, MYSQLI_ASSOC);
}


