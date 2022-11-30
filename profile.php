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

$posts = getUserPosts($link, $id);


$grid_classes = array("first", "second", "third", "fourth", "fifth", "sixth", "seventh", "eighth", "ninth");


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="./images/favicon.png" type="image/png"/>
    <link rel="stylesheet" href="common.css"/>
    <link rel="stylesheet" href="profile.css"/>
    <title>Instagram - <?php echo $_SESSION['username'] ?></title>
</head>
<body>
<header class="header">
    <a href="index.php" class="header-logo"
    ><img src="images/logo.png" alt="Logo"
        /></a>

    <div class="header-search">
        <form action="search.php" method="post">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Поиск" name="search"/>
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
                        d="M2 12v3.45c0 2.849.698 4.005 1.606 4.944.94.909 2.098 1.608 4.946 1.608h6.896c2.848 0 4.006-.7 4.946-1.608C21.302 19.455 22 18.3 22 15.45V8.552c0-2.849-.698-4.006-1.606-4.945C19.454 2.7 18.296 2 15.448 2H8.552c-2.848 0-4.006.699-4.946 1.607C2.698 4.547 2 5.703 2 8.552Z"
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                ></path>
                <line
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        x1="6.545"
                        x2="17.455"
                        y1="12.001"
                        y2="12.001"
                ></line>
                <line
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        x1="12.003"
                        x2="12.003"
                        y1="6.545"
                        y2="17.455"
                ></line>
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
<main class="main flex justify-center">
    <section class="profile flex col">
        <div class="profile-header flex row align-center">
            <div class="profile-logo flex justify-center img">
                <?php
                if (!$current_user_avatar) {
                    echo '<img src="images/placeholder.jpg" width="150px" height="150px" />';
                } else {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($current_user_avatar) . '" width="150px"  height="150px"/>';
                }
                ?>
            </div>
            <div class="profile-info flex col justify-between">
                <div class="profile-login flex row align-center">
                    <span><?php echo $_SESSION['username'] ?></span>
                    <button class="btn-grey">Редактировать профиль</button>
                    <svg
                            aria-label="Параметры"
                            class="_ab6-"
                            color="#262626"
                            fill="#262626"
                            height="24"
                            role="img"
                            viewBox="0 0 24 24"
                            width="24"
                    >
                        <circle
                                cx="12"
                                cy="12"
                                fill="none"
                                r="8.635"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                        ></circle>
                        <path
                                d="M14.232 3.656a1.269 1.269 0 0 1-.796-.66L12.93 2h-1.86l-.505.996a1.269 1.269 0 0 1-.796.66m-.001 16.688a1.269 1.269 0 0 1 .796.66l.505.996h1.862l.505-.996a1.269 1.269 0 0 1 .796-.66M3.656 9.768a1.269 1.269 0 0 1-.66.796L2 11.07v1.862l.996.505a1.269 1.269 0 0 1 .66.796m16.688-.001a1.269 1.269 0 0 1 .66-.796L22 12.93v-1.86l-.996-.505a1.269 1.269 0 0 1-.66-.796M7.678 4.522a1.269 1.269 0 0 1-1.03.096l-1.06-.348L4.27 5.587l.348 1.062a1.269 1.269 0 0 1-.096 1.03m11.8 11.799a1.269 1.269 0 0 1 1.03-.096l1.06.348 1.318-1.317-.348-1.062a1.269 1.269 0 0 1 .096-1.03m-14.956.001a1.269 1.269 0 0 1 .096 1.03l-.348 1.06 1.317 1.318 1.062-.348a1.269 1.269 0 0 1 1.03.096m11.799-11.8a1.269 1.269 0 0 1-.096-1.03l.348-1.06-1.317-1.318-1.062.348a1.269 1.269 0 0 1-1.03-.096"
                                fill="none"
                                stroke="currentColor"
                                stroke-linejoin="round"
                                stroke-width="2"
                        ></path>
                    </svg>
                    <a href="logout.php" style="color: inherit"
                    ><i class="fas fa-sign-out-alt"></i
                        ></a>
                </div>
                <div class="profile-stats flex row">
                    <span><b>9</b> публикаций</span>
                    <span><b>300</b> подписчиков</span>
                    <span><b>200</b> подписок</span>
                </div>
                <div class="profile-desc flex col">
                    <span><?php echo $current_user_description ?></span>
                </div>
            </div>
        </div>
        <div class="profile-nav flex align-center justify-center mb24">
            <a href="profile.php"
            ><span class="active"
                ><svg
                            aria-label=""
                            class="_ab6-"
                            color="#262626"
                            fill="#262626"
                            height="12"
                            role="img"
                            viewBox="0 0 24 24"
                            width="12"
                    >
                <rect
                        fill="none"
                        height="18"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        width="18"
                        x="3"
                        y="3"
                ></rect>
                <line
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        x1="9.015"
                        x2="9.015"
                        y1="3"
                        y2="21"
                ></line>
                <line
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        x1="14.985"
                        x2="14.985"
                        y1="3"
                        y2="21"
                ></line>
                <line
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        x1="21"
                        x2="3"
                        y1="9.015"
                        y2="9.015"
                ></line>
                <line
                        fill="none"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        x1="21"
                        x2="3"
                        y1="14.985"
                        y2="14.985"
                ></line></svg
                    >ПУБЛИКАЦИИ</span
                ></a
            >
            <a href="profile-saved.php"
            ><span>
              <svg
                      aria-label=""
                      class="_ab6-"
                      color="#8e8e8e"
                      fill="#8e8e8e"
                      height="12"
                      role="img"
                      viewBox="0 0 24 24"
                      width="12"
              >
                <polygon
                        fill="none"
                        points="20 21 12 13.44 4 21 4 3 20 3 20 21"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                ></polygon>
              </svg>
              СОХРАНЕННОЕ</span
                ></a
            >
        </div>
        <div class="grid mb24">
            <?php
            for ($i = 0; $i < count($posts); $i++) {
                $photo = $posts[$i]['photo'];
                echo '<img src="data:image/jpeg;base64,' . base64_encode($photo) . '" class="' . $grid_classes[$i] . '" />';
            }
            ?>
        </div>
    </section>
</main>
</body>
</html>
