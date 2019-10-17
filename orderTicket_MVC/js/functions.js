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
                    <a class="nav-link" href="#">我要訂票</a>
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
            url: "config/API.php",
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
            url: "config/API.php",
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