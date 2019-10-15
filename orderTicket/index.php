<?php
include 'functions.php';
?>
<!doctype html>
<html>
<head>
    <?php
    headinc();
    ?>
    <title>OrderTickets</title>
</head>
<body>
<div class="container">
    <?php
    navBar();
    ?>

    <main role="main">

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <h1 class="display-3">訂票系統</h1>
                <p>第二的時更新年的手機，場的我到笑死睡覺還是，心裡忘卻有多打的把我。但他真的，簡直文章給我對自⋯間尺發的家的你了到爆，之前心情⋯趙七一起一個而且，找我現在嗚嗚還是只是舞台。再看車上但有們的希望。史上做出。得自一張有點下手不知起來那麼：怎麼好一看他用這⋯忘記原來這個也來到的。</p>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <?php
                $sql = "SELECT * FROM `ticket`";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    echo '<div class="col-md-4">';
                    echo    "<h3>{$row['t_name']}</h3>";
                    echo    '<ul>';
                    echo        $row['t_content'];
                    echo    '</ul>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <hr>
        <!-- /container -->

    </main>
</div>

<footer class="container">
    <p>© Company 2017-2019</p>
</footer>

</body>
</html>
