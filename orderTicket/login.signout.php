<?php
session_start();
session_destroy();
echo '<script>alert("Log out successed.");</script>';
echo '<script>document.location.href="index.php";</script>';