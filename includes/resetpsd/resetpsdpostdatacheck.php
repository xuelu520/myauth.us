<?php

defined("ZHANGXUAN") or die("no hacker.");
$resetpsdpostdataerror = -1; //1:隐藏数据用户ID和令牌错误,2邮箱错误,3两个密码不同,4用户不存在,5令牌失效
if ($resetmod == 2) {
    if (ctype_digit($_POST["user_id"]) && checkcode($_POST['user_token'])) {
        $emailadd = db_iconv('oldPassword');
        if (valid_email($emailadd)) {
            $userid = $_POST["user_id"];
            $usertoken = $_POST['user_token'];
            $passwordA = db_iconv('newPassword');
            $passwordB = db_iconv('newPasswordVerify');
            if ($passwordA == $passwordB) {
                $unmd5newpassword = getunencryptpass($passwordA);
                $newpassword = md5($unmd5newpassword);
                $sql = "SELECT * FROM `users` WHERE `user_id`='$userid'";
                $row = queryRow($sql);
                if ($row) {
                    $username = $row['user_name'];
                    if ($usertoken == $row['user_psd_reset_token'] && $row['user_psd_reset_token_used'] == 0) {
                        $newtoken = randstr();
                        $sql = "UPDATE `users` SET `user_pass`='$newpassword',`user_psd_reset_token`='$newtoken',`user_psd_reset_token_used`=1 WHERE `user_id`='$userid'";
                        update($sql);
                        if (isset($_COOKIE['loginname']) && isset($_COOKIE['loginid']) && $_COOKIE['loginname'] != "" && $_COOKIE['loginid'] != "") {
                            $usertmp = mysqli_real_escape_string($dbconnect, htmlspecialchars($_COOKIE['loginname']));
                            $cookievalue = mysqli_real_escape_string($dbconnect, htmlspecialchars($_COOKIE['loginid'], ENT_QUOTES));
                            $sql = "DELETE FROM `cookiedata` WHERE `user_name`='$usertmp' AND `user_cookie` ='$cookievalue'";
                            delete($sql);
                        }if (isset($_SESSION['loginuser']) && $_SESSION['loginuser'] != "") {
                            unset($_SESSION['loginuser']);
                        }
                        $resetpsdpostdataerror = 0;
                        $user = $row['user_name'];
                        $mailtxt = "本邮件为系统自动发送，您已经成功地重置了您的密码。<br><br>" .
                                "您的用户名为：$user<br><br>" .
                                "您的用户ID为：$userid<br><br>" .
                                "如果这不是您操作的，请<a href='" . SITEHOST . "' target='_blank'>前往网站</a>重置您的密码。<br><br>" .
                                "本邮件为自动发送，请不要回复，因为没人会看的。<br><br>" .
                                "竹井詩織里<br><br>" .
                                date('Y-m-d');
                        send_mail('战网安全令在线版密码重置提示邮件', $mailtxt, $emailadd, 0, 0);
                    } else {
                        $resetpsdpostdataerror = 5; //回去重试
                    }
                } else {
                    $resetpsdpostdataerror = 4; //不返回首页
                }
            } else {
                $resetpsdpostdataerror = 3;
            }
        } else {
            $resetpsdpostdataerror = 2; //不返回旧页面
        }
    } else {
        $resetpsdpostdataerror = 1; //不返回旧页面
    }
}
?>
