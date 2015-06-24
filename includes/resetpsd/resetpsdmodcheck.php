<?php

defined("ZHANGXUAN") or die("no hacker.");
$resetmod = -1; //1开始输入，2确认中
if (check_data('userid', 'get') && check_data('token', 'get')) {
    $resetmod = 1;
} else {
    if (check_data('user_id') && check_data('user_token') && check_data('oldPassword') && check_data('newPassword') && check_data('newPasswordVerify')) {
        $resetmod = 2;
    } else {
        $resetmod = 0;
    }
}
?>