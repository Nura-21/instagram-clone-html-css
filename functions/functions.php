<?php
require_once "config.php";

function getUserData($link, $user_id)
{
    $data = mysqli_query($link, "SELECT user_name, description, avatar FROM user WHERE user_id='$user_id LIMIT 1'");
    return mysqli_fetch_array($data);
}

function getUserPosts($link, $user_id)
{
    $posts_result = mysqli_query($link, "SELECT post_id, photo FROM post WHERE user_id='$user_id' ORDER BY created_at DESC");
    return mysqli_fetch_all($posts_result, MYSQLI_ASSOC);
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
    if (empty($user_ids)) {
        return;
    }
    $ids = implode(',', $user_ids);
    $posts = mysqli_query($link, "SELECT p.photo, p.caption, u.user_name, u.avatar FROM post p JOIN user u ON p.user_id = u.user_id WHERE p.user_id IN ($ids)");
    return mysqli_fetch_all($posts, MYSQLI_ASSOC);
}


function getFollowedUsers($link, $user_id)
{
    $users = mysqli_query($link, "SELECT u.user_name, u.avatar FROM user u JOIN follow f ON u.user_id = f.following_id WHERE f.follower_id = '$user_id' LIMIT 5");
    return mysqli_fetch_all($users, MYSQLI_ASSOC);
}

function getRecommendedUsers($link, $user_id)
{
    $followings_ids = getFollowingsIds($link, $user_id);
    $followings_ids[] = $user_id;
    $ids = implode(',', $followings_ids);
    $users = mysqli_query($link, "SELECT user_id, user_name, avatar FROM user WHERE user_id NOT IN ($ids) ORDER BY RAND() LIMIT 5");
    return mysqli_fetch_all($users, MYSQLI_ASSOC);
}

function subscribe($link, $follower_id, $following_id)
{
    $sql = "INSERT INTO follow (follower_id, following_id) VALUES ('$follower_id', '$following_id')";
    mysqli_query($link, $sql);
}

function unsubscribe($link, $follower_id, $following_id)
{
    $sql = "DELETE FROM follow WHERE follower_id='$follower_id' AND following_id='$following_id'";
    mysqli_query($link, $sql);
}

function isSubscribed($link, $follower_id, $following_id)
{
    $sql = "SELECT * FROM follow WHERE follower_id='$follower_id' AND following_id='$following_id'";
    $result = mysqli_query($link, $sql);
    return mysqli_num_rows($result) > 0;
}

function getPostCnt($link, $user_id) {
    $sql = "SELECT COUNT(post_id) AS cnt FROM post WHERE user_id='$user_id'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    return $row['cnt'];
}

function getFollowersCnt($link, $user_id) {
    $sql = "SELECT COUNT(follower_id) AS cnt FROM follow WHERE following_id='$user_id'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    return $row['cnt'];
}

function getFollowingsCnt($link, $user_id) {
    $sql = "SELECT COUNT(following_id) AS cnt FROM follow WHERE follower_id='$user_id'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    return $row['cnt'];
}