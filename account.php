<?php

ob_start();
include('includes/config.php');
$topnavvalue = "账号管理";
include('includes/html_toubu/html_toubu.php');
include('includes/page_inc/header_normal.php');
if ($logincheck == 0) {
    ob_end_clean();
    header("Location: login.php");
    exit;
} else {
    $navurladd = SITEHOST . "account.php";
    $query = "SELECT * FROM `users` WHERE `user_name`='$user'";
    $rowtemp = queryRow($query);
    $user_id = $rowtemp['user_id'];
    $user_right = $rowtemp['user_right'];
    $query = "SELECT * FROM `authdata` WHERE `user_id`='$user_id'";
    $auth_total_all = queryNum_rows($query);
    include('includes/page_inc/account_inc.php');
}
include('includes/page_inc/footer.php');
ob_flush();
?>