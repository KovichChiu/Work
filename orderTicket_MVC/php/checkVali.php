<?php
include __DIR__ . '/../config/config.php';

$u_id = $_POST['u_id'];

$vali = true;

//maincode

if (!false) {
    $sql = "Update `u_account` SET `u_vali` = '1' WHERE `u_id` = '{$u_id}'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $vali = false;
    }
} else {
    $vali = false;
}
echo ($vali) ? ("true") : ("false");


