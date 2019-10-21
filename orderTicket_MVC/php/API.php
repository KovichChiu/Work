<?php
include '../config/config.php';

$func = (isset($_POST['func'])) ? (sqlInject($_POST['func'])) : ("");
$sql = (isset($_POST['sql'])) ? ($_POST['sql']) : ("");
$u_name = (isset($_POST['u_name'])) ? (sqlInject($_POST['u_name'])) : ("");
$u_acc = (isset($_POST['u_acc'])) ? (sqlInject($_POST['u_acc'])) : ("");
$u_pswd = (isset($_POST['u_pswd'])) ? (sqlInject($_POST['u_pswd'])) : ("");

switch ($func) {
    case "select":
        selectDB();
        break;
    case "signup":
        signupDB();
        break;
    case "insert":
        insertDB();
        break;
    case "signout":
        signout();
        break;
    default:
        break;
}

function selectDB()
{
    global $conn, $sql;
    $result = mysqli_query($conn, $sql);
    $jsonData = array();

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $jsonData[] = $row;
    }
    echo json_encode($jsonData);
}

function signupDB()
{
    global $conn, $u_acc, $u_name, $u_pswd;
    $u_id = sha1($u_name . $u_acc . $u_pswd . time());
    $u_pswd = hash("sha512", sqlInject($u_pswd));
    $sql = "INSERT INTO `u_account` (`u_id`, `u_name`, `u_acc`, `u_pswd`) VALUES ('" . $u_id . "', '" . $u_name . "', '" . $u_acc . "', '" . $u_pswd . "')";
    $result = mysqli_query($conn, $sql);
    $flag = "success";
    if (!@$result) {
        $flag = "error";
    }
    echo $flag;
}

function insertDB()
{
    global $conn, $sql;
    $result = mysqli_query($conn, $sql);
    $flag = "success";
    if (!$result) {
        $flag = "error";
    }
    echo $flag;
}

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

function signout()
{
    session_start();
    session_destroy();
    echo 'success';
}
