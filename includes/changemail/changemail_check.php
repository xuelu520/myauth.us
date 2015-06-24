<?php

//fix
defined("ZHANGXUAN") or die("no hacker.");
@session_start();
$changemailadderrorid = -1; //1验证码错误,2提交数据有错，3没登入玩个P，4验证信息错了,5不是邮箱格式,6，两次邮箱地址一样，7邮件发送失败
if (check_data('letters_code') && md5(strtolower($_POST["letters_code"])) == $_SESSION['letters_code']) {   //验证码正确才能继续搞啊
    if (check_data('email') && check_data('question1') && check_data('answer1')) {                  //要有数据啊
        if ($logincheck == 1) {
            $sql = "SELECT * FROM `users` WHERE `user_name`='$user'";
            $rowtemp = queryRow($sql);
            $user_id = $rowtemp['user_id'];
            $useremailadd = db_iconv('email');
            $userquestion = db_iconv('question1');
            $useranswer = db_iconv('answer1');
            $mailaddused = $rowtemp['user_email'];
            if ($rowtemp['user_question'] == $userquestion && $rowtemp['user_answer'] == $useranswer) {
                if (valid_email($useremailadd)) {
                    if ($useremailadd != $rowtemp['user_email']) {
                        $newcheckid = randstr();
                        $mailtxtcheckurl = SITEHOST . "mailcheck.php?userid=$user_id&checkcode=$newcheckid";

                        $mailtxt = "本邮件为系统自动发送，您正在申请更改注册邮箱为当前邮箱<br><br>" .
                                "您的用户名为：$user<br><br>" .
                                "您的用户ID为：$user_id<br><br>" .
                                "您此前的邮箱地址为：$mailaddused<br><br>" .
                                "您现在的邮箱地址为：$useremailadd<br><br>" .
                                "您的邮箱已经成功修改，为了今后能顺利管理账号，请点击以下链接确认您的邮箱地址<br><br>" .
                                "<a href='$mailtxtcheckurl' target='_blank'>$mailtxtcheckurl</a><br><br>" .
                                "如果这不是您操作的，请不要点击以上链接，并进入我的账号页面更改邮箱地址。<br><br>" .
                                "本邮件为自动发送，请不要回复，因为没人会看的。<br><br>" .
                                "竹井詩織里<br><br>" .
                                date('Y-m-d');
                        $changemailadderrorid = send_mail('战网安全令在线版更改邮箱验证邮件', $mailtxt, $useremailadd, 0, 7);
                        $sql = "UPDATE `users` SET `user_email`='$useremailadd',`user_email_checked`='0',`user_email_checkid`='$newcheckid' WHERE `user_name`='$user'";
                        update($sql);
                    } else {
                        $changemailadderrorid = 6;
                    }
                } else {
                    $changemailadderrorid = 5;
                }
            } else {
                $changemailadderrorid = 4;
            }
        } else {
            $changemailadderrorid = 3;
        }
    } else {
        $changemailadderrorid = 2;
    }
    $_SESSION['letters_code'] = md5(rand());
} else {
    if (isset($_POST["letters_code"]) && !empty($_POST["letters_code"]) && md5(strtolower($_POST["letters_code"])) != $_SESSION['letters_code']) {
        $changemailadderrorid = 1;
    }
}
?>