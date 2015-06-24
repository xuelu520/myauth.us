<?php
//fix
defined("ZHANGXUAN") or die("no hacker.");
session_start();
$findpsdbymailerrorid = -1; //1密钥过期，2密钥错误，3信息不完整
if (check_data('userid','get') && check_data('pwdcheckid','get')) {
    if (ctype_digit($_GET["userid"]) && checkcode($_GET["pwdcheckid"])) {
        $userid = db_iconv('userid', 'get', true, true);
        $checkcode = db_iconv("pwdcheckid", 'get', true, true);
        $sql = "SELECT * FROM `users` WHERE `user_id`='$userid'";
        $rowmailpsd = queryRow($sql);
        if ($rowmailpsd['user_email_find_mode'] == 1) {
            if ($rowmailpsd['user_email_find_code'] == $checkcode) {
                $newtoken = randstr();
                $newtokenA = randstr();
                $sql = "UPDATE `users` SET `user_psd_reset_token`='$newtoken',`user_email_find_code`='$newtokenA',`user_email_find_mode`=0,`user_psd_reset_token_used`= '0' WHERE `user_id`='$userid'";
                update($sql);
                $findpsdbymailerrorid = 0;
            } else {
                $findpsdbymailerrorid = 2;
            }
        } else {
            $findpsdbymailerrorid = 1;
        }
    }
} else {
    $findpsdbymailerrorid = 3;
}
?>
