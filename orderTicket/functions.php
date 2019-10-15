<?php
include __DIR__ . '/orderTicket.php';

session_start();
/*
 * 實名認證過濾
 */
function ck_Vali()
{
    $flag = true;

    if (!$flag) {
        echo '<script>alert("You are not Verified! Please Verified first.");</script>';
        echo '<script>document.location.href="http://orderticket.test/index.php";</script>';
        exit;
    }
}

/*
 * SQL injection過濾
 */
function sqlInject($input)
{
    $key = array(
        "=",
        "`",
        "·",
        "~",
        "!",
        "！",
        "^",
        "*",
        "(",
        ")",
        "\/",
        ".",
        "<",
        ">",
        "\\",
        ":",
        "；",
        ";",
        "-",
        "_",
        "—",
        " "
    );
    $output = str_replace($key, "", $input);
    return $output;
}

/*
 * 判斷有沒有登入
 */
function isLogin()
{
    $flag = true;
    $flag = ($flag && isset($_SESSION['u_id'])) ? (true) : (false);
    $flag = ($flag && isset($_SESSION['u_acc'])) ? (true) : (false);
    $flag = ($flag && isset($_SESSION['u_name'])) ? (true) : (false);

    return $flag;
}

function headinc()
{
    ?>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, Maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="Shortcut Icon" type="image/x-icon" href="img/favicon.ico">

    <!-- Bootstrap include -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>

    <!-- GLOBAL CSS -->
    <link rel="stylesheet" href="css/global.css">
    <?php
}

function navBar()
{
    ?>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="#">搶票囉</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarsExampleDefault" style="">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">首頁 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">演唱會資訊</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orderTicket.list.php">我要訂票</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php
                if (isLogin()) {
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $_SESSION['u_name'] . '</a>';
                    echo '<div class="dropdown-menu" aria-labelledby="dropdown01">';
                    echo '<a class="dropdown-item" href="#">會員資料</a>';
                    echo '<a class="dropdown-item" href="orderContent.php">訂票內容</a>';
                    echo '<a class="dropdown-item" href="#">實名認證</a>';
                    echo '<div class="dropdown-divider"></div>';
                    echo '<a class="dropdown-item" href="login.signout.php">登出</a>';
                    echo '</div>';
                    echo '</li>';

                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="login.signin.php">會員登入</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
    <?php
}

?>