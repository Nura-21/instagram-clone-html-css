<?php
require_once "config.php";
require "functions/functions.php";


session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$id = $_SESSION['id'];

$current_user = getUserData($link, $id);
$current_user_description = $current_user['description'];
$current_user_avatar = $current_user['avatar'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="./images/favicon.png" type="image/png"/>
    <link rel="stylesheet" href="common.css"/>
    <link rel="stylesheet" href="post.css"/>
    <link rel="stylesheet" href="search_results.css"/>
    <title>Instagram - Результаты поиска</title>
</head>
<?php
    if(isset($_SESSION['searchErr'])) {
        $error = $_SESSION['searchErr'];
        unset($_SESSION['searchErr']);
    }

    $search_results = $_SESSION['search_details'];
?>
<body>
<header class="header">
    <a href="index.php" class="header-logo"
    ><img src="images/logo.png" alt="Logo"
        /></a>

    <div class="header-search">
        <form action="search.php" method="post">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Поиск" name="search" />
            <input type="submit" name="search_submit">
        </form>
    </div>
    <nav class="header-nav">
        <a href="index.php" class="header-nav-link">
            <svg
                    aria-label="Главная страница"
                    class="_ab6-"
                    color="#262626"
                    fill="#262626"
                    height="24"
                    role="img"
                    viewBox="0 0 24 24"
                    width="24"
            >
                <path
                        d="M9.005 16.545a2.997 2.997 0 0 1 2.997-2.997A2.997 2.997 0 0 1 15 16.545V22h7V11.543L12 2 2 11.543V22h7.005Z"
                        fill="none"
                        stroke="currentColor"
                        stroke-linejoin="round"
                        stroke-width="2"
                ></path>
            </svg>
        </a>
        <a href="chat.php" class="header-nav-link">
            <svg
                    aria-label="Messenger"
                    class="_ab6-"
                    color="#262626"
                    fill="#262626"
                    height="24"
                    role="img"
                    viewBox="0 0 24 24"
                    width="24"
            >
                <path
                        d="M12.003 2.001a9.705 9.705 0 1 1 0 19.4 10.876 10.876 0 0 1-2.895-.384.798.798 0 0 0-.533.04l-1.984.876a.801.801 0 0 1-1.123-.708l-.054-1.78a.806.806 0 0 0-.27-.569 9.49 9.49 0 0 1-3.14-7.175 9.65 9.65 0 0 1 10-9.7Z"
                        fill="none"
                        stroke="currentColor"
                        stroke-miterlimit="10"
                        stroke-width="1.739"
                ></path>
                <path
                        d="M17.79 10.132a.659.659 0 0 0-.962-.873l-2.556 2.05a.63.63 0 0 1-.758.002L11.06 9.47a1.576 1.576 0 0 0-2.277.42l-2.567 3.98a.659.659 0 0 0 .961.875l2.556-2.049a.63.63 0 0 1 .759-.002l2.452 1.84a1.576 1.576 0 0 0 2.278-.42Z"
                        fill-rule="evenodd"
                ></path>
            </svg>
        </a>
        <a href="post.php" class="header-nav-link">
            <svg
                    aria-label="Новая публикация"
                    class="_ab6-"
                    color="#262626"
                    fill="#262626"
                    height="24"
                    role="img"
                    viewBox="0 0 24 24"
                    width="24"
            >
                <path
                        d="m12.003 5.545-.117.006-.112.02a1 1 0 0 0-.764.857l-.007.117V11H6.544l-.116.007a1 1 0 0 0-.877.876L5.545 12l.007.117a1 1 0 0 0 .877.876l.116.007h4.457l.001 4.454.007.116a1 1 0 0 0 .876.877l.117.007.117-.007a1 1 0 0 0 .876-.877l.007-.116V13h4.452l.116-.007a1 1 0 0 0 .877-.876l.007-.117-.007-.117a1 1 0 0 0-.877-.876L17.455 11h-4.453l.001-4.455-.007-.117a1 1 0 0 0-.876-.877ZM8.552.999h6.896c2.754 0 4.285.579 5.664 1.912 1.255 1.297 1.838 2.758 1.885 5.302L23 8.55v6.898c0 2.755-.578 4.286-1.912 5.664-1.298 1.255-2.759 1.838-5.302 1.885l-.338.003H8.552c-2.754 0-4.285-.579-5.664-1.912-1.255-1.297-1.839-2.758-1.885-5.302L1 15.45V8.551c0-2.754.579-4.286 1.912-5.664C4.21 1.633 5.67 1.05 8.214 1.002L8.552 1Z"
                ></path>
            </svg>
        </a>
        <a href="explore.php" class="header-nav-link">
            <svg
                    aria-label="Найти людей"
                    class="_ab6-"
                    color="#262626"
                    fill="#262626"
                    height="24"
                    role="img"
                    viewBox="0 0 24 24"
                    width="24"
            >
                <polygon
                        fill="none"
                        points="13.941 13.953 7.581 16.424 10.06 10.056 16.42 7.585 13.941 13.953"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                ></polygon>
                <polygon
                        fill-rule="evenodd"
                        points="10.06 10.056 13.949 13.945 7.581 16.424 10.06 10.056"
                ></polygon>
                <circle
                        cx="12.001"
                        cy="12.005"
                        fill="none"
                        r="10.5"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                ></circle>
            </svg>
        </a>
        <a href="likes.php" class="header-nav-link">
            <svg
                    aria-label="Что нового"
                    class="_ab6-"
                    color="#262626"
                    fill="#262626"
                    height="24"
                    role="img"
                    viewBox="0 0 24 24"
                    width="24"
            >
                <path
                        d="M16.792 3.904A4.989 4.989 0 0 1 21.5 9.122c0 3.072-2.652 4.959-5.197 7.222-2.512 2.243-3.865 3.469-4.303 3.752-.477-.309-2.143-1.823-4.303-3.752C5.141 14.072 2.5 12.167 2.5 9.122a4.989 4.989 0 0 1 4.708-5.218 4.21 4.21 0 0 1 3.675 1.941c.84 1.175.98 1.763 1.12 1.763s.278-.588 1.11-1.766a4.17 4.17 0 0 1 3.679-1.938m0-2a6.04 6.04 0 0 0-4.797 2.127 6.052 6.052 0 0 0-4.787-2.127A6.985 6.985 0 0 0 .5 9.122c0 3.61 2.55 5.827 5.015 7.97.283.246.569.494.853.747l1.027.918a44.998 44.998 0 0 0 3.518 3.018 2 2 0 0 0 2.174 0 45.263 45.263 0 0 0 3.626-3.115l.922-.824c.293-.26.59-.519.885-.774 2.334-2.025 4.98-4.32 4.98-7.94a6.985 6.985 0 0 0-6.708-7.218Z"
                ></path>
            </svg>
        </a>
        <a href="profile.php" class="header-nav-link img">
            <?php
            if (!$current_user_avatar) {
                echo '<img src="images/placeholder.jpg" width="26px" height="26px" />';
            } else {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($current_user_avatar) . '" width="26px"  height="26px"/>';
            }
            ?>
        </a>
    </nav>
</header>
<main class="main flex align-center justify-center">
    <section class="post border" style="width: 25vw">
        <div class="post-header flex align-center justify-center"><span><b>Результаты поиска</b></span></div>
        <div class="post-content flex col align-center" style="padding: 20px">
            <?php if(isset($error)) {
                echo $error;
            } else {
                if(!$search_results) {
                    echo 'Совпадений не найдено';
                    return;
                }
                foreach($search_results as $search_result) { ?>
                    <div class="flex row align-center justify-between likes-users search-result">
                        <div class="flex row align-center img likes-user">
                        <?php echo '<img draggable="false" src="data:image/jpeg;base64,' . base64_encode($search_result['avatar']) . '" />'; ?>
                        <span><b><?php echo $search_result['user_name']; ?></b></span>
                        </div>

                        <span><?php echo $search_result['description']; ?></span>
                    </div>
                <?php }
            } ?>
        </div>
    </section>
</main>
</body>
</html>