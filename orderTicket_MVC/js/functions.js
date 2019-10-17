$(function () {
    nav();
});


function nav() {
    let userBar = ``;
    if(localStorage.getItem("u_name") === null){
        userBar += `<li class="nav-item"><a class="nav-link" href="login.signin.html">會員登入</a></li>`;
    }else{
        userBar += `<li class="nav-item dropdown">`;
        userBar += `<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">`+localStorage.getItem("u_name")+`</a>`;
        userBar += `<div class="dropdown-menu" aria-labelledby="dropdown01">`;
        userBar += `<a class="dropdown-item" href="#">會員資料</a>`;
        userBar += `<a class="dropdown-item" href="#">訂票內容</a>`;
        userBar += `<a class="dropdown-item" href="#">實名認證</a>`;
        userBar += `<div class="dropdown-divider"></div>`;
        userBar += `<a class="dropdown-item" href="#" onclick="signout();">登出</a>`;
        userBar += `</div>`;
        userBar += `</li>`;
    }
    let navItem = `
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
                    <a class="nav-link" href="orderTicket.List.html">我要訂票</a>
                </li>
            </ul>
            <ul class="navbar-nav">`+userBar+`</ul>
        </div>
    </nav>
    `;
    $("#TopNav").html(navItem);
}

function signinSubmit() {
    let Acc = $("#inputAcc").val();
    let pswd = $("#inputpswd").val();
    let sql = "SELECT * FROM `u_account` WHERE `u_acc` ='" + Acc + "'";
    try {
        $.ajax({
            type: 'POST',
            url: "php/API.php",
            async: false,
            data: {
                "func": "select",
                "sql": sql
            },
            dataType: "json",
            success: function (result) {
                if (result.length === 0) {
                    alert("查無帳號喔!");
                    document.location.href = "login.signin.html";
                } else {
                    try {
                        $.each(result, function (key, value) {
                            if (value['u_pswd'] !== sha512(pswd)) {
                                alert("密碼輸入錯誤喔!");
                                document.location.href = "login.signin.html";
                            } else {
                                alert("登入成功喔!");
                                localStorage.setItem("u_id", value['u_id']);
                                localStorage.setItem("u_acc", value['u_acc']);
                                localStorage.setItem("u_name", value['u_name']);
                                document.location.href = "index.html";
                            }
                        });
                    } catch (e) {
                        console.log("An error catch on $.each(): " + e.message);
                    }
                }
            },
            error: function (e) {
                $.each(e, function (key, value) {
                    console.log(key + ": " + value);
                });
            }
        });
    } catch (e) {
        console.log("An error catch on $.ajax(): " + e.message);
    }
    return false;
}

function signupSubmit(){
    let name = $("#inputName").val();
    let acc = $("#inputAcc").val();
    let pswd = $("#inputPswd").val();
    try {
        $.ajax({
            type: 'POST',
            url: "php/API.php",
            async: false,
            data: {
                "func": "signup",
                "u_name": name,
                "u_acc": acc,
                "u_pswd": pswd
            },
            dataType: "text",
            success: function (result) {
                if(result === "success"){
                    alert("恭喜你，註冊成功!");
                    window.location.href = "login.signin.html";
                }else{
                    alert("抱歉，該帳號已經被註冊過了喔");
                    window.location.href = "login.signup.html";
                }
            },
            error: function (e) {
                $.each(e, function (key, value) {
                    console.log(key + ": " + value);
                });
            }
        });
    } catch (e) {
        console.log("An error catch on $.ajax(): " + e.message);
    }
    return false;
}

function signout() {
    localStorage.clear();
    alert("登出!");
    location.reload();
}

/* orderTicket */

function checkLogin() {
    if(localStorage.getItem("u_id") === null){
        alert("要先登入才能搶票喔!");
        document.location.href="index.html";
    }
}

function showTicket() {
    let sql = "SELECT * FROM `ticket`";
    try{
        $.ajax({
            type: 'POST',
            url: "php/API.php",
            async: false,
            data: {
                "func": "select",
                "sql": sql
            },
            dataType: "json",
            success: function (result) {
                let tickets = ``;
                $.each(result, function(key, value){
                    tickets += `<div class="card mb-4 shadow-sm">`;
                    tickets += `<div class="card-header">`;
                    tickets += `<h4 class="my-0 font-weight-normal">`+value['t_name']+`</h4>`;
                    tickets += `</div>`;
                    tickets += `<div class="card-body">`;
                    tickets += `<h1 class="card-title pricing-card-title">$`+value['t_price']+` <small class="text-muted">/NTD</small></h1>`;
                    tickets += `<ul class="list-unstyled mt-3 mb-4">`;
                    tickets += value['t_content'];
                    tickets += `</ul>`;
                    tickets += `<a href="#" onclick="order(`+key+`);" class="btn btn-lg btn-block btn-outline-primary">我要訂票</a>`;
                    tickets += `</div>`;
                    tickets += `</div>`;
                });
                $("#ticketContent").html(tickets);
            },
            error: function (e) {
                $.each(e, function (key, value) {
                    console.log(key + ": " + value);
                });
            }
        });
    }catch (e) {
        console.log("An error catch on $.ajax(): " + e.message);
    }
}

function order(tid) {
    let u_id = localStorage.getItem("u_id");
    let u_acc = localStorage.getItem("u_acc");
    let u_name = localStorage.getItem("u_name");
    try{
        $.ajax({
            type: 'POST',
            url: "php/orderTicket.buy.php",
            async: false,
            data: {
                "u_id": u_id,
                "u_acc": u_acc,
                "u_name": u_name,
                "t_id": tid
            },
            dataType: "text",
            success: function (result) {
                if(result === "noTicket"){
                    alert("沒票囉sorry...");
                    window.location.href = "orderTicket.List.html";
                }else if(result === "noPOST"){
                    window.location.href = "orderTicket.List.html";
                }else{
                    window.location.href = "php/orderTicket.queue.php?t_id="+result;
                }
            },
            error: function (e) {
                $.each(e, function (key, value) {
                    console.log(key + ": " + value);
                });
            }
        });
    }catch (e) {
        console.log("An error catch on $.ajax(): " + e.message);
    }
}