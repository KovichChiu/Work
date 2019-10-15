<?php
include 'functions.php';

//判斷有沒有填寫
$flag = true;
$flag = ($flag && isset($_POST['Acc'])) ? (true) : (false);
$flag = ($flag && isset($_POST['Pswd'])) ? (true) : (false);

if ($flag) {
    //過濾非法字元
    $acc = sqlInject($_POST['Acc']);
    $pswd = hash("sha512", sqlInject($_POST['Pswd']));

    //比對資料
    $sql = "SELECT * FROM `u_account` WHERE `u_acc` = '" . $acc . "'AND `u_pswd` = '" . $pswd . "'";
    $result = mysqli_query($conn, $sql);
    if ($row = @mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo '<script>alert("Login successed!");</script>';
        $_SESSION['u_id'] = $row['u_id'];
        $_SESSION['u_acc'] = $row['u_acc'];
        $_SESSION['u_name'] = $row['u_name'];
        echo '<script>document.location.href="index.php";</script>';
        exit;
    } else {
        echo '<script>alert("Login Error! Please retry. Thanks.");</script>';
        echo '<script>document.location.href="login.signin.php";</script>';
        exit;
    }

}
?>
<!doctype html>
<html>
<head>
    <?php
    headinc();
    ?>
    <title>OT LOGIN</title>

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            Max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>
<body class="text-center">
<form class="form-signin" method="post">
    <img class="mb-4" src="img/favicon.ico" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputAcc" class="sr-only">Account</label>
    <input type="text" id="inputAcc" class="form-control" placeholder="Account" name="Acc" autocomplete="off" required
           autofocus>
    <label for="inputpswd" class="sr-only">Password</label>
    <input type="password" id="inputpswd" class="form-control" placeholder="Password" name="Pswd" autocomplete="off"
           required>
    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-primary" type="submit">Sign in</button>
    <a href="login.signup.php" class="btn btn-lg btn-danger">Sign up</a>
    <p class="mt-5 mb-3 text-muted">&copy; 2019-</p>
</form>

</body>
</html>