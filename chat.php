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
    <link rel="stylesheet" href="chat.css" />
    <title>Instagram - Чат</title>
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
          <svg aria-label="Главная страница" class="_ab6-" color="#262626" fill="#262626" height="24" role="img" viewBox="0 0 24 24" width="24"><path d="M9.005 16.545a2.997 2.997 0 0 1 2.997-2.997A2.997 2.997 0 0 1 15 16.545V22h7V11.543L12 2 2 11.543V22h7.005Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2"></path></svg>
        </a>
        <a href="chat.php" class="header-nav-link">
          <svg aria-label="Messenger" class="_ab6-" color="#262626" fill="#262626" height="24" role="img" viewBox="0 0 24 24" width="24"><path d="M12.003 1.131a10.487 10.487 0 0 0-10.87 10.57 10.194 10.194 0 0 0 3.412 7.771l.054 1.78a1.67 1.67 0 0 0 2.342 1.476l1.935-.872a11.767 11.767 0 0 0 3.127.416 10.488 10.488 0 0 0 10.87-10.57 10.487 10.487 0 0 0-10.87-10.57Zm5.786 9.001-2.566 3.983a1.577 1.577 0 0 1-2.278.42l-2.452-1.84a.63.63 0 0 0-.759.002l-2.556 2.049a.659.659 0 0 1-.96-.874L8.783 9.89a1.576 1.576 0 0 1 2.277-.42l2.453 1.84a.63.63 0 0 0 .758-.003l2.556-2.05a.659.659 0 0 1 .961.874Z"></path></svg>
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
          <a href="profile.php" class="header-nav-link img">
            <?php
            if (!$current_user_avatar) {
                echo '<img src="images/placeholder.jpg" width="26px" height="26px" />';
            } else {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($current_user_avatar) . '" width="26px"  height="26px"/>';
            }
            ?>
          </a>
        </a>
      </nav>
    </header>
    <main class="main flex row align-center justify-center">
      <section class="chat border flex row">
        <section class="chat-left flex col">
          <div class="chat-header flex row align-center justify-center">
            <div class="chat-header-user flex row align-center justify-center">
              <span><b><?php echo $_SESSION['username'] ?></b></span>
              <svg
                aria-label='Значок "стрелка вниз"'
                class="_ab6-"
                color="#262626"
                fill="#262626"
                height="20"
                role="img"
                viewBox="0 0 24 24"
                width="20"
              >
                <path
                  d="M21 17.502a.997.997 0 0 1-.707-.293L12 8.913l-8.293 8.296a1 1 0 1 1-1.414-1.414l9-9.004a1.03 1.03 0 0 1 1.414 0l9 9.004A1 1 0 0 1 21 17.502Z"
                ></path>
              </svg>
            </div>
            <svg
              aria-label="Новое сообщение"
              class="_ab6-"
              color="#262626"
              fill="#262626"
              height="24"
              role="img"
              viewBox="0 0 24 24"
              width="24"
            >
              <path
                d="M12.202 3.203H5.25a3 3 0 0 0-3 3V18.75a3 3 0 0 0 3 3h12.547a3 3 0 0 0 3-3v-6.952"
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
              ></path>
              <path
                d="M10.002 17.226H6.774v-3.228L18.607 2.165a1.417 1.417 0 0 1 2.004 0l1.224 1.225a1.417 1.417 0 0 1 0 2.004Z"
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
                x1="16.848"
                x2="20.076"
                y1="3.924"
                y2="7.153"
              ></line>
            </svg>
          </div>
          <div class="chat-nav flex align-center justify-center">
            <span><b>ОСНОВНЫЕ</b></span>
          </div>
          <div class="flex col chat-messages">
            <div class="flex row align-center img chat-message">
              <img src="https://source.unsplash.com/random/400x400?sig=1" alt="Logo" />
              <div class="flex col">
                <span>kbtu</span>
                <span class="grey-text">У вас хорошие...</span>
              </div>
            </div>
            <div class="flex row align-center img chat-message">
              <img src="https://source.unsplash.com/random/400x400?sig=2" alt="Logo" />
              <div class="flex col">
                <span>votasbanned</span>
                <span class="grey-text">Салам бро! Как ...</span>
              </div>
            </div>
            <div class="flex row align-center img chat-message">
              <img src="https://source.unsplash.com/random/400x400?sig=3" alt="Logo" />
              <div class="flex col">
                <span>dindindon</span>
                <span class="grey-text">А мне что делать?</span>
              </div>
            </div>
            <div class="flex row align-center img chat-message">
              <img src="https://source.unsplash.com/random/400x400?sig=4" alt="Logo" />
              <div class="flex col">
                <span>steppe</span>
                <span class="grey-text">На этой неделе...</span>
              </div>
            </div>
            <div class="flex row align-center img chat-message">
              <img src="https://source.unsplash.com/random/400x400?sig=5" alt="Logo" />
              <div class="flex col">
                <span>codemodekz</span>
                <span class="grey-text">Супер пупер...</span>
              </div>
            </div>
            <div class="flex row align-center img chat-message">
              <img src="https://source.unsplash.com/random/400x400?sig=6" alt="Logo" />
              <div class="flex col">
                <span>1fit</span>
                <span class="grey-text">Стань альфой и все...</span>
              </div>
            </div>
            <div class="flex row align-center img chat-message">
              <img src="https://source.unsplash.com/random/400x400?sig=7" alt="Logo" />
              <div class="flex col">
                <span>Chaplin ADK</span>
                <span class="grey-text">А у вас есть 21?...</span>
              </div>
            </div>
            <div class="flex row align-center img chat-message">
              <img src="https://source.unsplash.com/random/400x400?sig=8" alt="Logo" />
              <div class="flex col">
                <span>Kinopark</span>
                <span class="grey-text">Приятного просмотра!...</span>
              </div>
            </div>
          </div>
        </section>
        <section class="chat-right flex col align-center justify-center">
          <svg aria-label="Direct" class="_ab6-" color="#262626" fill="#262626" height="96" role="img" viewBox="0 0 96 96" width="96"><circle cx="48" cy="48" fill="none" r="47" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></circle><line fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2" x1="69.286" x2="41.447" y1="33.21" y2="48.804"></line><polygon fill="none" points="47.254 73.123 71.376 31.998 24.546 32.002 41.448 48.805 47.254 73.123" stroke="currentColor" stroke-linejoin="round" stroke-width="2"></polygon></svg>
          <span style="font-size: 22px; margin-bottom: 4px; color: rgb(38, 38, 38)">Ваши сообщения</span>
          <span style="margin-bottom: 20px; color: rgb(142, 142, 142);">Отправляйте личные фото и сообщения другу или группе.</span>
          <button class="btn-blue">Отправить сообщение</button>
        </section>
      </section>
    </main>
  </body>
</html>
