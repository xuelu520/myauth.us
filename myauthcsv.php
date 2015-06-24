<?php

session_start();
include('includes/config.php');
if (isset($_SESSION['loginuser']) && !empty($_SESSION['loginuser'])) {
    $logincheck = 1;
}
if ($logincheck == 1) {
    $user = mysqli_real_escape_string($dbconnect, htmlspecialchars($_SESSION['loginuser']));
    $sql = "SELECT * FROM `users` WHERE `user_name`='$user'";
    $rowtemp = queryRow($sql);
    $user_id = $rowtemp['user_id'];
    $user_right = $rowtemp['user_right'];
    if ($user_right == 0) {
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="myauth.csv"');
        $output = fopen('php://output', 'w') or die(locationtogo());
        $sql = "SELECT * FROM `authdata` WHERE `user_id`='$user_id'";
        $result = queryArray($sql);
        $list = array();
        $list = "安全令名称,安全令序列号,安全令密钥,安全令还原码\r\n";
        foreach ($result as $rowauth) {
            $list .= $rowauth['auth_name'] . "," . $rowauth['serial'] . "," . $rowauth['secret'] . "," . $rowauth['restore_code'] . "\r\n";
        }
        $list = "\xEF\xBB\xBF" . $list;
        fwrite($output, $list);
        fclose($output) or die(locationtogo());
    } else {
        locationtogo();
    }
} else {
    
}

function locationtogo() {
    Header("Location: " . SITEHOST);
}

?>
