<?php

defined("ZHANGXUAN") or die("no hacker.");
$mailcheckerrorid = -1; //已经确认了1,错误2
if (check_data("userid",'get') && check_data("checkcode",'get')) {
    if (ctype_digit($_GET["userid"]) && checkcode($_GET["checkcode"])) {
        $userid = $_GET['userid'];
        $checkcode = db_iconv("checkcode", 'get');
        $sql = "SELECT * FROM `users` WHERE `user_id`='$userid'";
        $row = queryRow($sql);
        if ($row) {
            if ($row['user_email_checked'] == 0) {
                if ($checkcode == $row['user_email_checkid']) {
                    $sql = "UPDATE `users` SET `user_email_checked`=1 WHERE `user_id`='$userid'";
                    update($sql);
                    $mailcheckerrorid = 0;
                } else {
                    $mailcheckerrorid = 2;
                }
            } else {
                $mailcheckerrorid = 1; //已经确认了
            }
        } else {
            $mailcheckerrorid = 2; //没这个人
        }
    } else {
        $mailcheckerrorid = 2; //没这个人
    }
} else {
    $mailcheckerrorid = 2;
}//没这个人

?>
