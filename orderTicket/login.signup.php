<?php
include 'functions.php';

if (isset($_POST['Name']) || isset($_POST['Acc']) || isset($_POST['Pswd'])) {

    //判斷該寫得有沒有寫
    $flag = true;
    $flag = ($flag && isset($_POST['Name'])) ? (true) : (false);
    $flag = ($flag && isset($_POST['Acc'])) ? (true) : (false);
    $flag = ($flag && isset($_POST['Pswd'])) ? (true) : (false);

    if (!$flag) {
        echo '<script>alert("Please fill in all \'*\' fields");</script>';
        echo '<script>document.location.href="http://orderticket.test/login.signup.php";</script>';
        exit;
    } else {
        $u_name = sqlInject($_POST['Name']);
        $u_acc = sqlInject($_POST['Acc']);
        $u_pswd = hash("sha512", sqlInject($_POST['Pswd']));

        $u_id = sha1($u_name . $u_acc . $u_pswd . time());

        $sql = "INSERT INTO `u_account` (`u_id`, `u_name`, `u_acc`, `u_pswd`) VALUES ('" . $u_id . "', '" . $u_name . "', '" . $u_acc . "', '" . $u_pswd . "')";
        if (@mysqli_query($conn, $sql)) {
            echo '<script>alert("Sign up successed! Jump to sign in. Thanks!");</script>';
            echo '<script>document.location.href="http://orderticket.test/login.signin.php";</script>';
        } else {
            echo '<script>alert("Sign up Error! Please contect us!");</script>';
            echo '<script>document.location.href="http://orderticket.test/login.signup.php";</script>';
        }
    }
}

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, Maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OT LOGIN</title>
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
    <h1 class="h3 mb-3 font-weight-normal">SIGN UP</h1>
    <input type="text" id="inputName" class="form-control" placeholder="Name" name="Name" autocomplete="off"
           required="required" autofocus>
    <br/>
    <input type="text" id="inputAcc" class="form-control" placeholder="Account" name="Acc" autocomplete="off"
           required="required">
    <br/>
    <input type="password" id="inputpswd" class="form-control" placeholder="Password" name="Pswd" autocomplete="off"
           required="required">
    <br/>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
    <p class="mt-5 mb-3 text-muted">&copy;2019-</p>
</form>

</body>
</html>
