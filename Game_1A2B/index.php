<?php
include 'GameCore.php';
session_start();
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- JQuery 3.3.1 -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <!-- Bootstrap include -->
    <link rel="stylesheet" href="Bootstrap/bootstrap.css">
    <script src="Bootstrap/bootstrap.js"></script>
    <script src="Bootstrap/bootstrap.bundle.js"></script>

    <title>Game_1A2B</title>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
        <a class="navbar-brand" href="#">Game_1A2B</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample09"
                aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarsExample09" style="">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="http://127.0.0.1/">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <main role="main">
        <div class="jumbotron">
            <div>
                <h1>Game_1A2B</h1>
                <hr>
                <li>這是一個單人的數學益智遊戲</li>
                <ol>
                    <li>進入頁面後輸入4位「不重複」的數字，並按下Enter鍵送出答案。</li>
                    <li>輸入數值若符合規則便會回饋給玩家X個正確位置的正確數字與Y個不正確位置的正確數字。例如1234 →
                        0A3B，可得知「1234」這一組不重複的4位數字中，有三個數字為正確數字但卻不在正確位置。
                    </li>
                    <li>遊戲的最後將會統計玩家從開始至答對使用的次數。</li>
                    <li>完成答案後直接輸入便可以重新開始。</li>
                </ol>
                <p></p>

                <!-- 主要遊戲段落 -->
                <form action="" method="POST">
                    <input type="text" name="ansplayer"
                           style="font-size:100px; height: 100px;width: 400px; text-align: right; margin:0px; display:inline;"
                           maxlength="4" autofocus autocomplete="off">
                    <b id="response" style="font-size: 20px;color: red;"></b>
                    <button type="submit" class="btn btn-outline-primary" style="display:none;"></button>
                </form>
                <p></p>
                <div>
                    <textarea id="outPut_note" style="font-size: 26px; text-align: right;width: 400px; height: 400px"
                              readonly></textarea>
                </div>

            </div>
        </div>
    </main>
</div>
</body>
</html>

<?php
if (isset($_POST['ansplayer'])) {
    if (isset($_SESSION['game'])) {
        $game = $_SESSION['game'];
    } else {
        $game = new GameCore();
        $game->newGame();
    }
    $_SESSION['game'] = $game;
    $game->setAnswerPLAYER($_POST['ansplayer']);
    if (!empty($_POST['ansplayer']) and strlen($_POST['ansplayer']) == 4 and !$game->checkRepeat()) {

        $game->checkAnswer();
        $countA = $game->getCounterA();
        $countB = $game->getCounterB();

        if ($countA == 4) {
            echo "<script>$('#response').html('答對了！使用了 " . $game->getTimes() . " 次，直接輸入以重新開始遊戲。');</script>";
            session_destroy();
            session_start();
        }
        if (isset($_SESSION['game'])) {
            $_SESSION['game'] = $game;
        }

    } elseif (strlen($_POST['ansplayer']) != 4 || $game->checkRepeat()) {
        echo "<script>$('#response').html('輸入值請遵守4位數、不重複、不超過的方式喔！');</script>";
    }
    echo "<script>$('#outPut_note').val('" . $game->getHistory() . "')</script>";
}
?>

