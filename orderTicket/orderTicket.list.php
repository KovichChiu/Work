<?php
include 'functions.php';

//登入否
if(!isset($_SESSION['u_id'])){
    echo '<script>alert("You are not Login! Please Login first.");</script>';
    echo '<script>document.location.href="index.php";</script>';
    exit;
}

//判斷實名認證
ck_Vali();


?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, Maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OrderTickets</title>
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
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">訂票中心</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="#">我的訂票</a>
    </nav>
    <?php echo '<a class="nav-link" href="#">' . $_SESSION['u_name'] . '</a>'; ?>
</div>

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">門票一覽</h1>
    <p class="lead">一時搶票一時爽，一直搶票一直爽。</p>
</div>

<div class="container">
    <div class="card-deck mb-3 text-center">
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Do As Infinity 大無限樂團</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$1920 <small class="text-muted">/NTD</small></h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>全區站席</li>
                    <li>看台：約50CM高。</li>
                    <li>限購400張</li>
                    <li>10月27日(日)在ATT SHOW BOX大直</li>
                </ul>
                <a href="orderTicket.buy.php?t_id=1" class="btn btn-lg btn-block btn-outline-primary">我要訂票</a>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">超時空之鑰 次元之旅</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$1490 <small class="text-muted">/NTD</small></h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>2019年11月30日（六）</li>
                    <li>入場18:00 / 開演19:00（暫訂）</li>
                    <li>限定300張</li>
                    <li>ATT SHOW BOX 大直</li>
                </ul>
                <a href="orderTicket.buy.php?t_id=2" class="btn btn-lg btn-block btn-outline-primary">我要訂票</a>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">MUMFORD＆SONS</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">$2380 <small class="text-muted">/NTD</small></h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>2019/11/17 (日) 7PM</li>
                    <li>2019/8/18 (日) 11AM 公開發售</li>
                    <li>限購500張</li>
                    <li>永豐Legacy Taipei 音樂展演空間</li>
                </ul>
                <a href="orderTicket.buy.php?t_id=3" class="btn btn-lg btn-block btn-outline-primary">我要訂票</a>
            </div>
        </div>
    </div>
</div>


</body>
</html>
