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
$ids = getFollowingsIds($link, $id);
$posts = getFollowingsPosts($link, $ids);

$followed_users = getFollowedUsers($link, $id);
$recommended_users = getRecommendedUsers($link, $id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="index.css"/>
    <link rel="stylesheet" href="common.css"/>
    <link rel="shortcut icon" href="./images/favicon.png" type="image/png">
    <title>Instagram</title>
</head>
<body>
<header class="header">
    <a href="index.php" class="header-logo"
    ><img src="images/logo.png" alt="Logo"
        /></a>

    <div class="header-search">
        <form action="search.php" method="post">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Имя пользователя" name="search"/>
            <button type="submit" name="search_submit" style="border: none">Искать</button>
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
                        d="M22 23h-6.001a1 1 0 0 1-1-1v-5.455a2.997 2.997 0 1 0-5.993 0V22a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V11.543a1.002 1.002 0 0 1 .31-.724l10-9.543a1.001 1.001 0 0 1 1.38 0l10 9.543a1.002 1.002 0 0 1 .31.724V22a1 1 0 0 1-1 1Z"
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
<main class="main flex row justify-center">
    <section class="main-left flex col">
        <div class="main-stories flex row align-center border justify-between">
            <?php
            foreach ($followed_users as $followed_user) { ?>
                <div class="main-story flex col align-center">
                    <?php
                    if (!$followed_user['avatar']) {
                        echo '<img src="images/placeholder.jpg" width="36px" />';
                    } else {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($followed_user['avatar']) . '" width="40"  height="55px"/>';
                    }
                    ?>
                    <span><?php echo $followed_user['user_name'] ?> </span>
                </div>
            <?php } ?>
        </div>
        <div class="main-posts flex col">

            <?php
            if (!$posts) {
                echo '<h1>Пока нет постов</h1>';
            } else {

            foreach ($posts as $post) { ?>
                <aside class="main-post border">
                    <div class="post-header flex align-center justify-between">
                        <div class="post-header-left flex row align-center">
                            <a href="#" class="flex row align-center"
                               style="text-decoration: none; color: inherit;">
                                <?php
                                if (!$post['avatar']) {
                                    echo '<img src="images/placeholder.jpg" width="32" height="32" />';
                                } else {
                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($post['avatar']) . '" width="32"  height="32"/>';
                                }
                                ?>
                                <div class="flex col">
                                    <span><b><?php echo $post['user_name'] ?></b></span>
                                    <span>Алматы</span>
                                </div>
                            </a>
                        </div>
                        <svg
                                aria-label="Дополнительно"
                                class="_ab6-"
                                color="#262626"
                                fill="#262626"
                                height="24"
                                role="img"
                                viewBox="0 0 24 24"
                                width="24"
                        >
                            <circle cx="12" cy="12" r="1.5"></circle>
                            <circle cx="6" cy="12" r="1.5"></circle>
                            <circle cx="18" cy="12" r="1.5"></circle>
                        </svg>
                    </div>
                    <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($post['photo']) . '" width="500" height="500"/>'; ?>
                    <div class="post-actions flex row justify-between">
                        <div class="post-actions-left flex row align-center">
                            <svg
                                    aria-label="Нравится"
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
                            <svg
                                    aria-label="Комментировать"
                                    class="_ab6-"
                                    color="#262626"
                                    fill="#262626"
                                    height="24"
                                    role="img"
                                    viewBox="0 0 24 24"
                                    width="24"
                            >
                                <path
                                        d="M20.656 17.008a9.993 9.993 0 1 0-3.59 3.615L22 22Z"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                ></path>
                            </svg>
                            <svg
                                    aria-label="Поделиться публикацией"
                                    class="_ab6-"
                                    color="#262626"
                                    fill="#262626"
                                    height="24"
                                    role="img"
                                    viewBox="0 0 24 24"
                                    width="24"
                            >
                                <line
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        x1="22"
                                        x2="9.218"
                                        y1="3"
                                        y2="10.083"
                                ></line>
                                <polygon
                                        fill="none"
                                        points="11.698 20.334 22 3.001 2 3.001 9.218 10.084 11.698 20.334"
                                        stroke="currentColor"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                ></polygon>
                            </svg>
                        </div>
                        <svg
                                aria-label="Сохранить"
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
                                    points="20 21 12 13.44 4 21 4 3 20 3 20 21"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                            ></polygon>
                        </svg>
                    </div>
                    <div class="post-info flex col">
              <span class="post-info-likes"
              ><b>1,234 отметок "Нравится"</b></span>
                        <span class="post-info-text">
                            <b><?php echo $post['user_name'] ?></b> <?php echo $post['caption'] ?>
                        </span>
                        </span>
                    </div>
                </aside>
            <?php } }?>
        </div>
    </section>
    <section class="main-right flex col">
        <div class="main-my flex row align-center justify-between">
            <div class="main-my-left flex align-center">
                <a href="profile.php" class="flex align-center" style="text-decoration: none; color: inherit;">
                    <?php
                    if (!$current_user_avatar) {
                        echo '<img src="images/placeholder.jpg" width="60" height="60" />';
                    } else {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($current_user_avatar) . '" width="60"  height="60"/>';
                    }
                    ?>
                    <div class="flex col">
                        <span><b><?php echo $_SESSION['username'] ?></b></span>
                        <span><?php echo $current_user_description ?></span>
                    </div>
                </a>
            </div>
            <span class="blue-text">Переключиться</span>
        </div>
        <div class="flex justify-between">
            <span class="grey-text">Рекомендации для вас</span>
            <span class="grey-text">Все</span>
        </div>
        <div class="main-right-recommendations">
            <?php
            foreach ($recommended_users as $recommended_user) { ?>
                <div
                        class="flex row align-center justify-between img"
                        style="margin-top: 10px"
                >
                    <a href="recommendation_profile.php?recommended=<?php echo $recommended_user['user_id'] ?>"
                       style="text-decoration: none; color: inherit;">
                        <div class="flex row align-center">
                            <?php
                            if (!$recommended_user['avatar']) {
                                echo '<img src="images/placeholder.jpg" width="36px" style="margin-right: 10px" />';
                            } else {
                                echo '<img src="data:image/jpeg;base64,' . base64_encode($recommended_user['avatar']) . '" width="36px" . style="margin-right: 10px"/>';
                            }
                            ?>
                            <div class="flex col">
                                <span>
                                    <?php echo $recommended_user['user_name'] ?>
                                </span>
                            </div>
                        </div>
                    </a>
                    <span class="blue-text">
                        <form action="subscribe.php?recommended=<?php echo $recommended_user['user_id']; ?>" method="post">
                            <input type="submit" name="subscribe" value="subscribe">
                        </form>
                    </span>
                </div>
            <?php } ?>
    </section>
</main>
</body>
</html>
