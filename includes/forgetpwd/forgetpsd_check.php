<?php

//fix
defined("ZHANGXUAN") or die("no hacker.");
@session_start();
$pwdfinderrorid = -1; //1验证码错误,2用户不存在4输入错误,3信息与数据库中的不一样,5用户名存在非法字符，用户名仅允许使用中文、数字、字母、下划线，6发送邮件失败
if (check_data('letters_code') && md5(strtolower($_POST["letters_code"])) == $_SESSION['letters_code']) {   //验证码正确才能继续搞啊
    if (check_data('firstName')&& check_data('email')&& check_data('question1')&& check_data('answer1')) {                  //要有数据啊
        if (checkzhongwenzimushuzixiahuaxian($_POST["firstName"]) && checkquestionvalue($_POST['question1']) && valid_email($_POST["email"])) {
            $user = db_iconv("firstName", 'post', true, true);
            $emailadd = db_iconv("email");
            $question1 = db_iconv("question1");
            $answer1 = db_iconv("answer1");
            $emailfind = randstr();
            $sql = "SELECT * FROM `users` WHERE `user_name`='$user'";
            $rowuserdata = queryRow($sql);
            if ($rowuserdata) {
                if ($rowuserdata['user_email'] == $emailadd && $rowuserdata['user_question'] == $question1 && $rowuserdata['user_answer'] == $answer1) {
                    $userid = $rowuserdata['user_id'];
                    $sql = "UPDATE `users` SET `user_email_find_code`='$emailfind',`user_email_find_mode`='1' WHERE `user_id`='$userid'";
                    update($sql);
                    $findurl = SITEHOST . "findpwdmail.php?userid=$userid&pwdcheckid=$emailfind";
                    $mailtxt = "本邮件为系统自动发送，您正在申请重置您账号的密码<br><br>" .
                            "您的用户名为：$user<br><br>" .
                            "您的用户ID为：$userid<br><br>" .
                            "您的邮箱地址为：$emailadd<br><br>" .
                            "您还需要最后一步，点击以下链接，前往密码重置页面重置您的密码。<br><br>" .
                            "<a href='$findurl' target='_blank'>$findurl</a><br><br>" .
                            "如果这不是您操作的，请忽略本邮件，绝对不要点击以上链接。<br><br>" .
                            "本邮件为自动发送，请不要回复，因为没人会看的。<br><br>" .
                            "竹井詩織里<br><br>" .
                            date('Y-m-d');

                    $pwdfinderrorid = send_mail('战网安全令在线版重置密码链接邮件', $mailtxt, $emailadd, 0, 6);
                } else {
                    $pwdfinderrorid = 3;
                }
            } else {
                $pwdfinderrorid = 2;
            }
        } else {
            if (checkzhongwenzimushuzixiahuaxian($_POST["firstName"]) == false)
                $pwdfinderrorid = 5;
            else
                $pwdfinderrorid = 4;
        }
    } else {
        $pwdfinderrorid = 4; //POST数据不足
    }
    $_SESSION['letters_code'] = md5(rand());
} else {
    if (check_data('letters_code') && md5(strtolower($_POST["letters_code"])) != $_SESSION['letters_code']) {
        $pwdfinderrorid = 1;
    }
}
?>