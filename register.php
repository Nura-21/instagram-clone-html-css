<?php
require_once "config.php";

session_start();

$_SESSION = array();

session_destroy();

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        $sql = "SELECT user_id FROM user WHERE user_name = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        $sql = "INSERT INTO user (user_name, password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index.css" />
    <link rel="shortcut icon" href="./images/favicon.png" type="image/png">
    <link rel="stylesheet" href="login.css"/>
    <title>Instagram - Регистрация</title>
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
                <input type="text" placeholder="Имя пользователя" name="username" <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $username; ?>">
                <span><?php echo $username_err; ?></span>
                <input type="password" name="password" placeholder="Пароль"
                <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $password; ?>">
                <span><?php echo $password_err; ?></span>
                <input type="password" name="confirm_password" placeholder="Подтверждение пароля"
                <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $confirm_password; ?>">
                <span><?php echo $confirm_password_err; ?></span>
                <input type="submit" id="log" value="Создать">
                <input type="reset" value="Очистить данные">
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
          <span>У вас уже есть аккаунт?
            <a href="login.php">Войти</a
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