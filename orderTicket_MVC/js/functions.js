$(function () {
    nav();
});


function nav() {
    var navitem = `
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">testtest</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#">會員資料</a>
                        <a class="dropdown-item" href="orderContent.php">訂票內容</a>
                        <a class="dropdown-item" href="#">實名認證</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.signout.php">登出</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    `;
    $("#TopNav").html(navitem);
}