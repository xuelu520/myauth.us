<?php
//fix
@session_start();
include('../config.php');
include('../../classes/Authenticator.php');
if (isset($_SESSION['loginuser']) && !empty($_SESSION['loginuser'])) {
    $user = mysqli_real_escape_string($dbconnect, htmlspecialchars($_SESSION['loginuser']));
    $logincheck = 1;
    $sql = "SELECT * FROM `users` WHERE `user_name`='$user'";
    $rowtemp = queryRow($sql);
    $user_right = $rowtemp['user_right'];
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
                    $userip = $_SERVER["REMOTE_ADDR"];
                    $sql = "UPDATE `cookiedata` SET `user_login_ip`='$userip' WHERE `user_name`='$user' AND `user_cookie` ='$cookievalue'";
                    update($sql);
                }
            } else {
                $_SESSION['loginuser'] = $user;
                $logincheck = 1;
                $userip = $_SERVER["REMOTE_ADDR"];
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
header('Content-type: text/json');

if ($logincheck == 1 && $user_right != 1) {
    if ($row) {
        $sendbackauthid = $row['auth_id'];
        if ($row['auth_moren'] == 1) {
            $sql = "DELETE FROM `authdata` WHERE `user_id`=$user_id AND `auth_id`=$authid";
            delete($sql);
            $sql = "SELECT * FROM `authdata` WHERE `user_id`='$user_id' AND `auth_moren`=0";
            $rowa = queryRow($sql);
            if ($rowa) {
                $newauthmorenid = $rowa['auth_id'];
                $sql = "UPDATE `authdata` SET `auth_moren`= 1 WHERE `user_id`='$user_id' AND `auth_id` = '$newauthmorenid' AND `auth_moren`=0";
                update($sql);
                $arr = array('oldmorendeleted' => 1, 'newmorenid' => $newauthmorenid, 'deleteauid' => $sendbackauthid, 'result' => 1);
                echo json_encode($arr);
            } else {
                $arr = array('oldmorendeleted' => 1, 'newmorenid' => -1, 'deleteauid' => $sendbackauthid, 'result' => 1);
                echo json_encode($arr);
            }
        } else {
            $sql = "DELETE FROM `authdata` WHERE `user_id`=$user_id AND `auth_id`=$authid";
            delete($sql);
            $arr = array('oldmorendeleted' => 0, 'newmorenid' => -1, 'deleteauid' => $sendbackauthid, 'result' => 1);
            echo json_encode($arr);
        }
    } else {
        $arr = array('oldmorendeleted' => 0, 'newmorenid' => -1, 'deleteauid' => -1, 'result' => 0);
        echo json_encode($arr);
    }
} else {
    $arr = array('oldmorendeleted' => 0, 'newmorenid' => -1, 'deleteauid' => -1, 'result' => 0);
    echo json_encode($arr);
}
?>
