<?php

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: profile.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validation
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    // validation
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT user_id, user_name, password FROM user WHERE user_name = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["time"] = time();

                            header("location: profile.php");
                        } else {
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="login.css"/>
    <title>Document</title>
</head>
<body>
<div class="main">
    <div class="phone">
        <div class="inside-img">
            <img src="./images/inside.jpg" alt="image"/>
        </div>
    </div>

    <div class="right">
        <div class="login-block">
            <img src="./images/logo.png" alt="logo"/>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <input
                            type="text"
                            name="username"
                            placeholder="Телефон, имя пользователя или эл.адрес"
                            value="<?php echo $username; ?>"
                    />
                    <span><?php echo $username_err; ?></span>
                </div>
                <div>
                    <input type="password" placeholder="Пароль" name="password"/>
                    <span><?php echo $password_err; ?></span>
                </div>
                <input type="submit" id="log" value="Login"></input>
            </form>

            <div class="or">
                <div></div>
                <div>или</div>
                <div></div>
            </div>

            <div class="fb">
                <a href="https://www.facebook.com/login.php?skip_api_login=1&api_key=124024574287414&kid_directed_site=0&app_id=124024574287414&signed_next=1&next=https%3A%2F%2Fwww.facebook.com%2Fdialog%2Foauth%3Fclient_id%3D124024574287414%26redirect_uri%3Dhttps%253A%252F%252Fwww.instagram.com%252Faccounts%252Fsignup%252F%26state%3D%257B%2522fbLoginKey%2522%253A%25221golre3zdahc7epf9dl1ra9g7c14t5q9ynso4ry1im8q3z35dyq4%2522%252C%2522fbLoginReturnURL%2522%253A%2522%252Ffxcal%252Fdisclosure%252F%253Fnext%253D%25252F%2522%257D%26scope%3Demail%26response_type%3Dcode%252Cgranted_scopes%26locale%3Dru_RU%26ret%3Dlogin%26fbapp_pres%3D0%26logger_id%3Da08a5a51-7fff-4ca3-99f3-a4981cd6ce64%26tp%3Dunspecified&cancel_url=https%3A%2F%2Fwww.instagram.com%2Faccounts%2Fsignup%2F%3Ferror%3Daccess_denied%26error_code%3D200%26error_description%3DPermissions%2Berror%26error_reason%3Duser_denied%26state%3D%257B%2522fbLoginKey%2522%253A%25221golre3zdahc7epf9dl1ra9g7c14t5q9ynso4ry1im8q3z35dyq4%2522%252C%2522fbLoginReturnURL%2522%253A%2522%252Ffxcal%252Fdisclosure%252F%253Fnext%253D%25252F%2522%257D%23_%3D_&display=page&locale=ru_RU&pl_dbl=0"
                        id="fb-link">
                    <img src="./images/facebook-icon.png" alt=""/><span
                    >Войти через Facebook</span
                    >
                </a>
            </div>

            <a
                    href="https://www.instagram.com/accounts/password/reset/"
                    id="reset"
            >Забыли пароль?</a
            >
        </div>

        <div class="reg-block">
          <span>У вас еще нет аккаунта?
            <a href="register.php">Зарегистрироваться</a
            ></span>
        </div>

        <p id="install">Установите приложение.</p>
        <div class="stores">
            <a href="https://apps.apple.com/app/instagram/id389801252?vt=lo"
            ><img src="./images/app-store.png" alt="app store"
                /></a>
            <a
                    href="https://play.google.com/store/apps/details?id=com.instagram.android&referrer=utm_source%3Dinstagramweb&utm_campaign=loginPage&ig_mid=9D655E19-3809-4673-89A7-495A366809FC&utm_content=lo&utm_medium=badge"
            >
                <img src="./images/gg-play.png" alt="google play"
                /></a>
        </div>
    </div>
</div>

<footer>
    <div class="footer-contents">
        <ol>
            <li><a href="https://about.facebook.com/meta">Meta</a></li>
            <li><a href="https://about.instagram.com/">Информация</a></li>
            <li><a href="https://about.instagram.com/blog/">Блог</a></li>
            <li><a href="https://www.instagram.com/about/jobs/">Вакансии</a></li>
            <li><a href="https://help.instagram.com/">Помощь</a></li>
            <li>
                <a href="https://developers.facebook.com/docs/instagram">API</a>
            </li>
            <li>
                <a href="https://www.instagram.com/legal/privacy/"
                >Конфиденциальность</a
                >
            </li>
            <li><a href="https://www.instagram.com/legal/terms/">Условия</a></li>
            <li>
                <a href="https://www.instagram.com/directory/profiles/"
                >Популярные аккаунты</a
                >
            </li>
            <li>
                <a href="https://www.instagram.com/directory/hashtags/">Хэштеги</a>
            </li>
            <li>
                <a href="https://www.instagram.com/explore/locations/">Места</a>
            </li>
            <li>
                <a href="https://www.instagram.com/web/lite/">Instagram Lite</a>
            </li>
            <li>
                <a href="https://www.instagram.com/topics/beauty/">Красота</a>
            </li>
            <li>
                <a href="https://www.instagram.com/topics/dance-and-performance/"
                >Танцы</a
                >
            </li>
            <li>
                <a href="https://www.instagram.com/topics/fitness/">Фитнес</a>
            </li>
            <li>
                <a href="https://www.instagram.com/topics/food-and-drink/"
                >Еда и напитки</a
                >
            </li>
            <li>
                <a href="https://www.instagram.com/topics/home-and-garden/"
                >Дом и сад</a
                >
            </li>
            <li><a href="https://www.instagram.com/topics/music/">Музыка</a></li>
            <li>
                <a href="https://www.instagram.com/topics/visual-arts/ol"
                >Изобразительное искусство</a
                >
            </li>
        </ol>
    </div>
    <div class="copyright">
        <select name="language" id="lang">
            <option value="ru">Русский</option>
            <option value="kz">Қазақша</option>
            <option value="en">English</option>
            <option value="uk">English (UK)</option>
            <option value="po">Polski</option>
        </select>
        <p>© 2022 Instagram from Meta</p>
    </div>
</footer>
</body>
</html>
