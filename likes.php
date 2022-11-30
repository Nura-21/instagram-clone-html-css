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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="./images/favicon.png" type="image/png" />
    <link rel="stylesheet" href="common.css" />
    <link rel="stylesheet" href="likes.css" />
    <title>Instagram - Действия</title>
  </head>
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
            viewBox="0 0 48 48"
            width="24"
          >
            <path
              d="M34.6 3.1c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5s1.1-.2 1.6-.5c1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z"
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
      <section class="likes border flex col">
        <div class="likes-header first"><b>На этой неделе</b></div>
        <section class="flex col">
          <div class="flex row align-center justify-between likes-users">
            <div class="flex row align-center img likes-user">
              <img
                src="https://source.unsplash.com/random/400x400?sig=1"
                alt=""
              />
              <span><b>kbtu</b> подписался(-ась) на ваши обновления. </span>
            </div>
            <button class="btn-blue">Подписаться</button>
          </div>
          <div class="flex row align-center justify-between likes-users">
            <div class="flex row align-center img likes-user">
              <img
                src="https://source.unsplash.com/random/400x400?sig=2"
                alt=""
              />
              <span><b>votasbanned</b> подписался(-ась) на ваши обновления. </span>
            </div>
            <button class="btn-blue">Подписаться</button>
          </div>
          <div class="flex row align-center justify-between likes-users">
            <div class="flex row align-center img likes-user">
              <img
                src="https://source.unsplash.com/random/400x400?sig=3"
                alt=""
              />
              <span><b>dindindon</b> подписался(-ась) на ваши обновления. </span>
            </div>
            <button class="btn-blue">Подписаться</button>
          </div>
          <div class="flex row align-center justify-between likes-users">
            <div class="flex row align-center img likes-user">
              <img
                src="https://source.unsplash.com/random/400x400?sig=4"
                alt=""
              />
              <span><b>1fit</b> подписался(-ась) на ваши обновления. </span>
            </div>
            <button class="btn-blue">Подписаться</button>
          </div>
          <div class="flex row align-center justify-between likes-users">
            <div class="flex row align-center img likes-user">
              <img
                src="https://source.unsplash.com/random/400x400?sig=5"
                alt=""
              />
              <span><b>codemodekz</b> подписался(-ась) на ваши обновления. </span>
            </div>
            <button class="btn-blue">Подписаться</button>
          </div>
        </section>
        <div class="likes-header"><b>В этом месяце</b></div>
        <section class="flex col">
          <div class="flex row align-center justify-between likes-users">
            <div class="flex row align-center img likes-user">
              <img
                src="https://source.unsplash.com/random/400x400?sig=6"
                alt=""
              />
              <span><b>arbuz.kz</b> подписался(-ась) на ваши обновления. </span>
            </div>
            <button class="btn-blue">Подписаться</button>
          </div>
          <div class="flex row align-center justify-between likes-users">
            <div class="flex row align-center img likes-user">
              <img
                src="https://source.unsplash.com/random/400x400?sig=7"
                alt=""
              />
              <span><b>halykbank</b> подписался(-ась) на ваши обновления. </span>
            </div>
            <button class="btn-blue">Подписаться</button>
          </div>
          <div class="flex row align-center justify-between likes-users">
            <div class="flex row align-center img likes-user">
              <img
                src="https://source.unsplash.com/random/400x400?sig=8"
                alt=""
              />
              <span><b>kinopark</b> подписался(-ась) на ваши обновления. </span>
            </div>
            <button class="btn-blue">Подписаться</button>
          </div>
          <div class="flex row align-center justify-between likes-users">
            <div class="flex row align-center img likes-user">
              <img
                src="https://source.unsplash.com/random/400x400?sig=9"
                alt=""
              />
              <span><b>steppe</b> подписался(-ась) на ваши обновления. </span>
            </div>
            <button class="btn-blue">Подписаться</button>
          </div>
          <div class="flex row align-center justify-between likes-users">
            <div class="flex row align-center img likes-user">
              <img
                src="https://source.unsplash.com/random/400x400?sig=10"
                alt=""
              />
              <span><b>ztb</b> подписался(-ась) на ваши обновления. </span>
            </div>
            <button class="btn-blue">Подписаться</button>
          </div>
        </section>
      </section>
    </main>
  </body>
</html>
