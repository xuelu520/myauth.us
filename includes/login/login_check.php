<?php

//fdix
defined("ZHANGXUAN") or die("no hacker.");
session_start();
$logincheck = 0;
$loginerrorid = -1;
if (!check_data('letters_code') || md5(strtolower($_POST['letters_code'])) != $_SESSION['letters_code']) {
    $loginerrorid = 2;
} else if (check_data("username") && check_data("password")) {
    $user = db_iconv('username', 'post', true, true);
    $password = db_iconv('password');
    $result = check_post_password($password, $user);
    if (!$result) {
        $logincheck = 0;
        $loginerrorid = 1;
    } else {
        $sql = "SELECT * FROM `users` WHERE `user_name`='$user'";
        $rowtemp = queryRow($sql);
        $user_id = $rowtemp['user_id'];
        $user_right = $rowtemp['user_right'];
        $user_thistimelogin_ip = $rowtemp['user_thistimelogin_ip'];
        $user_thislogin_time = $rowtemp['user_thislogin_time'];
        if ($user_right == 1) {
            if (time() - strtotime($user_thislogin_time) < 1800) {
                $logincheck = 2;
            } else {
                $sql = "DELETE FROM `cookiedata` WHERE `user_name`='$user'";
                delete($sql);
                $logincheck = 1;
                $cookievalue = randstr();
                $login_time = date('Y-m-d H:i:s');
                $userip = getIP();
                $sql = "INSERT INTO `cookiedata`(`user_id`, `user_name`, `user_cookie`, `login_time`,`user_login_ip`) VALUES ('$user_id','$user','$cookievalue','$login_time','$userip')";
                insert($sql);
                $sql = "UPDATE `users` SET `user_lastlogin_ip`='$user_thistimelogin_ip',`user_thistimelogin_ip`='$userip',`user_lastlogin_time`='$user_thislogin_time', `user_thislogin_time`='$login_time' WHERE `user_id`='$user_id'";
                update($sql);
                setcookie("loginname", $user, time() + 30 * 60, "/");
                setcookie("loginid", $cookievalue, time() + 30 * 60, "/");
            }
        } else {
            $logincheck = 1;
            $_SESSION['loginuser'] = $user;
            if ($_POST['persistLogin'] === "on") {
                $cookievalue = randstr();
                $login_time = date('Y-m-d H:i:s');
                $userip = getIP();
                $sql = "INSERT INTO `cookiedata`(`user_id`, `user_name`, `user_cookie`, `login_time`,`user_login_ip`) VALUES ('$user_id','$user','$cookievalue','$login_time','$userip')";
                insert($sql);
                $sql = "UPDATE `users` SET `user_lastlogin_ip`='$user_thistimelogin_ip',`user_thistimelogin_ip`='$userip',`user_lastlogin_time`='$user_thislogin_time', `user_thislogin_time`='$login_time' WHERE `user_id`='$user_id'";
                update($sql);
                setcookie("loginname", $user, time() + 30 * 24 * 60 * 60, "/");
                setcookie("loginid", $cookievalue, time() + 30 * 24 * 60 * 60, "/");
            }
        }
    }
    $_SESSION['letters_code'] = rand();
} else if (isset($_SESSION['loginuser']) && !empty($_SESSION['loginuser'])) {
    $logincheck = 1;
} elseif (isset($_COOKIE['loginname']) && isset($_COOKIE['loginid']) && $_COOKIE['loginname'] != "" && $_COOKIE['loginid'] != "") {
    $user = mysqli_real_escape_string($dbconnect, htmlspecialchars($_COOKIE['loginname']));
    $cookievalue = mysqli_real_escape_string($dbconnect, htmlspecialchars($_COOKIE['loginid'], ENT_QUOTES));
    $sql = "SELECT * FROM `cookiedata` WHERE `user_name`='$user' AND `user_cookie` ='$cookievalue'";
    $result = queryRow($sql);
    if ($result) {
        $rowtemp = $result;
        $timedifference = time() - strtotime($rowtemp['login_time']);
        if ($timedifference <= 30 * 24 * 60 * 60) {
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
            $sql = "DELETE FROM `cookiedata` WHERE `user_name`='$user' AND `user_cookie` ='$cookievalue'";
            delete($sql);
            setcookie("loginname", "", time() - 3600, "/");
            setcookie("loginid", "", time() - 3600, "/");
            $logincheck = 0;
        }
    } else {
        setcookie("loginname", "", time() - 3600, "/");
        setcookie("loginid", "", time() - 3600, "/");
        $logincheck = 0;
    }
}
?>
