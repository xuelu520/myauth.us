<?php

//check_data("");
//fix
defined("ZHANGXUAN") or die("no hacker.");
$changepsderrorid = -1; //1验证码错误,2提交数据有错，3没登入玩个P，4两次密码不一样还改啥啊,5旧密码错误
if (check_data("letters_code") && md5(strtolower($_POST["letters_code"])) == $_SESSION['letters_code']) {   //验证码正确才能继续搞啊
    if (check_data("oldPassword") && check_data("newPassword") && check_data("newPasswordVerify")) {
        if ($logincheck == 1) {
            $passwordA = db_iconv('newPassword', 'post', false);
            $passwordB = db_iconv('newPasswordVerify', 'post', false);
            $oldPassword = db_iconv('oldPassword', 'post', false);
            if (check_post_password($oldPassword, $user)) {
                if ($passwordA == $passwordB) {
                    $unmd5newpassword = getunencryptpass($passwordA);
                    $newpassword = md5($unmd5newpassword);
                    $sql = "UPDATE `users` SET `user_pass`='$newpassword' WHERE `user_name`='$user'";
                    update($sql);
                    $sql = "SELECT * FROM `users` WHERE `user_name`='$user'";
                    $row = queryRow($sql);
                    $userid = $row['user_id'];
                    $emailadd = $row['user_email'];
                    $mailtxt = "本邮件为系统自动发送，您已经成功地修改了您的密码。<br><br>" .
                            "您的用户名为：$user<br><br>" .
                            "您的用户ID为：$userid<br><br>" .
                            "您的邮箱地址为：$emailadd<br><br>" .
                            "您设置是新密码为：" . emailpass($unmd5newpassword) . " (只显示前三位)<br><br>" .
                            "如果这不是您操作的，请<a href='" . SITEHOST . "' target='_blank'>前往网站</a>重置您的密码。<br><br>" .
                            "本邮件为自动发送，请不要回复，因为没人会看的。<br><br>" .
                            "竹井詩織里<br><br>" .
                            date('Y-m-d');
                    $changepsderrorid = send_mail('战网安全令在线版密码修改通知邮件', $mailtxt, $emailadd, 0, 0);
                } else {
                    $changepsderrorid = 4;
                }
            } else {
                $changepsderrorid = 5;
            }
        } else {
            $changepsderrorid = 3;
        }
    } else {
        $changepsderrorid = 2;
    }
    $_SESSION['letters_code'] = rand();
} else {
    if (check_data('letters_code') && md5(strtolower($_POST["letters_code"])) != $_SESSION['letters_code'])
        $changepsderrorid = 1;
}
?>