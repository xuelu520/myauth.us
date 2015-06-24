<?php
//fix
session_start();
include('../config.php');
include('../../classes/Authenticator.php');
if (isset($_SESSION['loginuser']) && !empty($_SESSION['loginuser'])) {
    $user = mysqli_real_escape_string($dbconnect, htmlspecialchars($_SESSION['loginuser']));
    $logincheck = 1;
} else if (isset($_COOKIE['loginname']) && isset($_COOKIE['loginid']) && $_COOKIE['loginname'] != "" && $_COOKIE['loginid'] != "") {
    $usertmp = mysqli_real_escape_string($dbconnect, htmlspecialchars($_COOKIE['loginname']));
    $cookievalue = mysqli_real_escape_string($dbconnect, htmlspecialchars($_COOKIE['loginid'], ENT_QUOTES));
    $sql = "SELECT * FROM `cookiedata` WHERE `user_name`='$usertmp' AND `user_cookie` ='$cookievalue'";
    $result = queryRow($sql);
    if ($result) {
        $rowtemp = $result;
        $timedifference = time() - strtotime($rowtemp['login_time']);
        if ($timedifference <= 30 * 24 * 60 * 60) {
            $user = $usertmp;
            $sql = "SELECT * FROM `users` WHERE `user_name`='$user'";
            $rowtemp = queryRow($sql);
            $user_thistimelogin_ip = $rowtemp['user_thistimelogin_ip'];
            $user_thislogin_time = $rowtemp['user_thislogin_time'];
            $user_right = $rowtemp['user_right'];
            if ($user_right == 1) {
                if ($timedifference > 1800) {
                    $sql = "DELETE FROM `cookiedata` WHERE `user_name`='$user' AND `user_cookie` ='$cookievalue'";
                    delete($sql);
                    setcookie("loginname", "", time() - 3600, "/");
                    setcookie("loginid", "", time() - 3600, "/");
                    $logincheck = 0;
                } else {
                    $logincheck = 1;
                    $userip = getIP();
                    $sql = "UPDATE `cookiedata` SET `user_login_ip`='$userip' WHERE `user_name`='$user' AND `user_cookie` ='$cookievalue'";
                    update($sql);
                }
            } else {
                $_SESSION['loginuser'] = $user;
                $logincheck = 1;
                $userip = getIP();
                $date = date('Y-m-d H:i:s');
                $sql = "UPDATE `cookiedata` SET `user_login_ip`='$userip' WHERE `user_name`='$user' AND `user_cookie` ='$cookievalue'";
                update($sql);
                $sql = "UPDATE `users` SET `user_lastlogin_ip`='$user_thistimelogin_ip',`user_thistimelogin_ip`='$userip',`user_lastlogin_time`='$user_thislogin_time', `user_thislogin_time`='$date' WHERE `user_name`='$user'";
                update($sql);
            }
        } else {
            $sql = "DELETE FROM `cookiedata` WHERE `user_name`='$usertmp' AND `user_cookie` ='$cookievalue'";
            delete($sql);
            setcookie("loginname", "", time() - 3600, "/");
            setcookie("loginid", "", time() - 3600, "/");
            $logincheck = 0;
        }
    }
} else {
    die("");
}
if (!is_null($user)) {
    $sql = "SELECT `user_id` FROM `users` WHERE `user_name`='$user'";
    $user_id = queryValue($sql);
}
if (check_data('authid','get') && ctype_digit($_GET['authid'])) {
    $authid = $_GET['authid'];
}
if (!is_null($user_id) && !is_null($authid)) {
    $sql = "SELECT * FROM `authdata` WHERE `user_id`='$user_id' AND `auth_id`='$authid'";
    $row = queryRow($sql);
}
if ($row) {
    $time = date('Y-m-d H:i:s');
    $region = $row['region'];
    if ($region != "CN" && $region != "EU") {
        $region = "US";
    }
    $sql = "SELECT * FROM `synctime` WHERE `region`='$region'";
    $rowSYNC = queryRow($sql);

    if (strtotime($time) - strtotime($rowSYNC['last_sync']) > 86400) {
        $auth = Authenticator::factory($row['serial'], $row['secret']);
        $sql = "UPDATE `synctime` SET `sync`=\"" . $auth->getsync() . "\" ,`last_sync`=\"$time\" WHERE `region`='$region'";
        update($sql);
    } else {
        $auth = Authenticator::factory($row['serial'], $row['secret'], $rowSYNC['sync']);
    }
//显示数据
    header('Content-type: text/json');
    $wait = $auth->sleeptime() / 1000;
    $arr = array('code' => $auth->code(), 'time' => $wait);
    echo json_encode($arr);
} else {
    header('Content-type: text/json');
    $wait = 0;
    $arr = array('code' => "@@@@@@", 'time' => $wait);
    echo json_encode($arr);
}
?>
