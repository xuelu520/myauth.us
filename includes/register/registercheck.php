<?php

//fix
defined("ZHANGXUAN") or die("no hacker.");
$questionid[81] = "您出生的城市是哪里?";
$questionid[82] = "您手机的型号是什么?";
$questionid[83] = "您就读的第一所小学名称是?";
$questionid[84] = "您的初恋情人叫什么名字?";
$questionid[85] = "您驾照的末四位是什么?";
$questionid[86] = "您母亲的姓名叫什么?";
$questionid[87] = "您母亲的生日是哪一天?";
$questionid[88] = "您父亲的生日是哪一天?";
session_start();
$registercheck = 0;
$registersuccesslogin = 0;
$registererrid = 0; //1注册码错误，2用户名重复，3邮件格式错误，4输入错误,用户名包含非法字符
if (check_data("letters_code") && md5(strtolower($_POST["letters_code"])) == $_SESSION['letters_code']) {   //验证码正确才能继续搞啊
    if (check_data("username") && check_data("password") && check_data("emailAddress") && check_data("question1") && check_data("answer1") && $_POST['rePassword'] === $_POST['password']) {                  //要有数据啊
        if (checkzhongwenzimushuzixiahuaxian($_POST["username"]) && checkquestionvalue($_POST['question1']) && valid_email($_POST["emailAddress"])) {
            $user = db_iconv("username", 'post', true, true);
            $unmd5password = db_iconv("password", 'post', false);
            $unmd5password = getunencryptpass($unmd5password);
            $password = md5($unmd5password);
            $emailadd = db_iconv("emailAddress");
            $question1 = db_iconv("question1");
            $answer1 = db_iconv("answer1");
            $user_email_checkid = randstr();
            $date = date('Y-m-d H:i:s');
            $emailfind = randstr();
            $mailresettoken = randstr();
            $cookievalue = randstr();
            $userip = getIP();
            $lowright = @$_POST['lowright'];
            if (checkpostusername($user)) {                                           //验证用户名不重复
                if (valid_email($emailadd)) {                                         //验证邮箱地址合法
                    if ($lowright == "lowright")
                        $lowrightnum = 1;
                    else
                        $lowrightnum = 0;
                    $sql = "INSERT INTO `users`(`user_name`, `user_pass`,`user_right`,`user_email`, `user_email_checked`, `user_registered`, `user_question`, `user_answer`, `user_email_checkid`,`user_email_find_code`,`user_email_find_mode`,`user_psd_reset_token`,`user_psd_reset_token_used`,`user_lastlogin_ip`,`user_thistimelogin_ip`,`user_lastlogin_time`,`user_thislogin_time`,`lastused_session_time`) VALUES ('$user','$password',$lowrightnum,'$emailadd',0,'$date',$question1,'$answer1','$user_email_checkid','$emailfind',0,'$mailresettoken','1','$userip','$userip','$date','$date',UNIX_TIMESTAMP())";
                    insert($sql);
                    $sql = "SELECT `user_id` FROM `users` WHERE `user_name`='$user'";
                    $rowtemp = queryRow($sql);
                    if ($rowtemp) {
                        if ($lowrightnum == 0)
                            $_SESSION['loginuser'] = $user;
                        setcookie("loginname", $user, time() + 30 * 24 * 60 * 60, "/");
                        setcookie("loginid", $cookievalue, time() + 30 * 24 * 60 * 60, "/");
                        $registersuccesslogin = 1;
                        $registercheck = 1;
                        $user_id = $rowtemp['user_id'];
                        $sql = "INSERT INTO `cookiedata`(`user_id`, `user_name`, `user_cookie`, `login_time`,`user_login_ip`) VALUES ('$user_id','$user','$cookievalue','$date','$userip')";
                        insert($sql);

                        /*                         * *********发送邮件部分*********** *///发送邮件的某个函数自己后面再处理下吧，格式如下，../mailcheck.php?userid=num&checkcode=dsaswewasdwewqs,查库的确认格式即可
                        $mailtxtcheckurl = SITEHOST . "mailcheck.php?userid=$user_id&checkcode=$user_email_checkid";
                        $mailtxt = "本邮件为系统自动发送，您的战网在线安全令账号已经创建<br><br>" .
                                "您的用户名为：$user<br><br>" .
                                "您的用户ID为：$user_id<br><br>" .
                                "您的密码为：" . emailpass($unmd5password) . " (只显示前三位)<br><br>" .
                                "您的安全问题为：" . $questionid[$question1] . "<br><br>" .
                                "您的安全问题答案：(已隐藏)<br><br>" .
                                "您的邮箱地址为：$emailadd<br><br>" .
                                "您的账号已经创建，为了今后能顺利管理账号，请点击以下链接确认您的邮箱地址<br><br>" .
                                "<a href='$mailtxtcheckurl' target='_blank'>$mailtxtcheckurl</a><br><br>" .
                                "如果这不是您操作的，请忽略本邮件，绝对不要点击以上链接。<br><br>" .
                                "本邮件为自动发送，请不要回复，因为没人会看的。<br><br>" .
                                "竹井詩織里<br><br>" .
                                date('Y-m-d');
                        send_mail('战网安全令在线版注册邮箱验证邮件', $mailtxt, $emailadd, 0, 1);
                    }else {
                        $registererrid = 6;
                    }
                } else {
                    $registererrid = 3;
                }
            } else {
                $registererrid = 2;
            }
        } else {
            if (checkzhongwenzimushuzixiahuaxian($_POST["username"]) == false)
                $registererrid = 5;
            else
                $registererrid = 4;
        }
    } else {
        $registererrid = 4;
    }
    $_SESSION['letters_code'] = rand();
} else {
    if (check_data('letters_code') && md5(strtolower($_POST["letters_code"])) != $_SESSION['letters_code'])
        $registererrid = 1;
}
?>