$(function () {
    nav();
});


function nav() {
    let userBar = ``;
    if (localStorage.getItem("u_name") === null) {
        userBar += `<li class="nav-item  active"><a class="nav-link" href="login.signin.html">會員登入</a></li>`;
    } else {
        userBar += `<li class="nav-item dropdown">`;
        userBar += `<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">` + localStorage.getItem("u_name") + `</a>`;
        userBar += `<div class="dropdown-menu" aria-labelledby="dropdown01">`;
        userBar += `<a class="dropdown-item" href="#">會員資料</a>`;
        userBar += `<a class="dropdown-item" href="order.List.html">訂票內容</a>`;
        userBar += `<a class="dropdown-item" href="#" onclick="checkVali();">實名認證</a>`;
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
                    <a class="nav-link" href="index.html">首頁 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="orderTicket.List.html">我要訂票</a>
                </li>
            </ul>
            <ul class="navbar-nav">` + userBar + `</ul>
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

function signupSubmit() {
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
                if (result === "success") {
                    alert("恭喜你，註冊成功!");
                    location.href = "login.signin.html";
                } else {
                    alert("抱歉，該帳號已經被註冊過了喔");
                    location.href = "login.signup.html";
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
    $.ajax({
        async: false,
        url: "php/API.php",
        data: {
            "func": "signout"
        },
        error: function (e) {
            $.each(e, function (key, value) {
                console.log(key + ": " + value);
            });
        }
    });
    location.href = "index.html";
}

function checkVali() {
    if (localStorage.getItem("u_id") === null) {
        alert("請先登入");
        location.href = "index.html";
    } else {
        $.ajax({
            type: "POST",
            async: false,
            url: "php/checkVali.php",
            data: {
                "u_id": localStorage.getItem("u_id")
            },
            dataType: "text",
            success: function (result) {
                if (result === "false") {
                    alert("認證失敗");
                    location.href = "index.html";
                } else {
                    alert("認證成功");
                    location.href = "index.html";
                }
            },
            error: function (e) {
                $.each(e, function (key, value) {
                    console.log(key + ": " + value);
                });
            }
        });
    }
}

/* orderTicket */

function checkLogin() {
    if (localStorage.getItem("u_id") === null) {
        alert("要先登入才能搶票喔!");
        document.location.href = "index.html";
    }
}

function showTicket() {
    let sql = "SELECT * FROM `ticket`";
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
                let tickets = ``;
                $.each(result, function (key, value) {
                    tickets += `<div class="card mb-4 shadow-sm">`;
                    tickets += `<div class="card-header">`;
                    tickets += `<h4 class="my-0 font-weight-normal">` + value['t_name'] + `</h4>`;
                    tickets += `</div>`;
                    tickets += `<div class="card-body">`;
                    tickets += `<h1 class="card-title pricing-card-title">$` + value['t_price'] + ` <small class="text-muted">/NTD</small></h1>`;
                    tickets += `<ul class="list-unstyled mt-3 mb-4">`;
                    tickets += value['t_content'];
                    tickets += `</ul>`;
                    tickets += `<a href="#" onclick="order(` + key + `);" class="btn btn-lg btn-block btn-outline-primary">我要訂票</a>`;
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
    } catch (e) {
        console.log("An error catch on $.ajax(): " + e.message);
    }
}

function order(tid) {
    let u_id = localStorage.getItem("u_id");
    let u_acc = localStorage.getItem("u_acc");
    let u_name = localStorage.getItem("u_name");
    try {
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
                let returnText = "";
                switch (result) {
                    case "success":
                        returnText = "新增成功";
                        break;
                    case "noPOST":
                        returnText = "error";
                        break;
                    case "noTicket":
                        returnText = "已經被搶完了！";
                        break;
                }
                alert(returnText);
                location.href = "orderTicket.list.html"
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
}

/* orderList */
function orderList() {
    let sql = "SELECT `u`.`u_name` as `name`,`o`.`o_no` as `no`,`o`.`o_time` as `time`,`t`.`t_name` as `ticketName`,`o`.`o_tpics` as `pics` FROM `order` as `o` INNER JOIN `u_account` as `u` ON `o`.`o_uid` = `u`.`u_id` INNER JOIN `ticket` as `t` ON `o`.`o_tid` = `t`.`t_id` WHERE `o`.`o_uid` = '" + localStorage.getItem("u_id") + "' ORDER BY `time` DESC";
    console.log(sql);
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
                let content = ``;
                $.each(result, function (key, value) {
                    content += `<tr>`;
                    content += `<td>` + value['name'] + `</td>`;
                    content += `<td>` + value['no'].substr(0, 8) + `</td>`;
                    content += `<td>` + dateFormat(value['time']) + `</td>`;
                    content += `<td>` + value['ticketName'] + `</td>`;
                    content += `<td>` + value['pics'] + `</td>`;
                    content += `</tr>`;
                });
                $("#dt_content").html(content);
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
}

//時間格式化 Y-M-D H-i-s
function dateFormat(time) {
    var date = new Date(time * 1000);
    var Y = date.getFullYear();
    var M = (date.getMonth() + 1 < 10) ? ("0" + date.getMonth() + 1) : (date.getMonth() + 1);
    var D = (date.getDate() < 10) ? ("0" + date.getDate()) : (date.getDate());
    var H = (date.getHours() < 10) ? ("0" + date.getHours()) : (date.getHours());
    var i = (date.getMinutes() < 10) ? ("0" + date.getMinutes()) : (date.getMinutes());
    var s = (date.getSeconds() < 10) ? ("0" + date.getSeconds()) : (date.getSeconds());
    return Y + `-` + M + `-` + D + ` ` + H + `:` + i + `:` + s;
}