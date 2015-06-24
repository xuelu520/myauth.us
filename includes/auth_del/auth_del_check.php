<?php

//fix
defined("ZHANGXUAN") or die("no hacker.");
$authdelerrorid = -1;
if ($logincheck == 0) {
    $authdelerrorid = 3; //未登入
} else {
    $sql = "SELECT * FROM `users` WHERE `user_id`='$user_id'";
    $rowtemp = queryRow($sql);
    $user_right = $rowtemp['user_right'];
    if ($user_right == 1) {
        $authdelerrorid=5;//没权删除
    }
    if ($autherrid == 2) {
        $authdelerrorid = 2; //GET错误
    } else if ($autherrid == 3) {
        $authdelerrorid = 3; //没登入
    } else if ($autherrid == 1) {
        $authdelerrorid = 1; //1不是你所有的安全令
    } else if ($autherrid == 0) {
        $sql = "SELECT * FROM `authdata` WHERE `user_id`='$user_id' AND `auth_id`='$auth_id'";
        $row = queryRow($sql);
        if ($row) {
            if ($row['auth_moren'] == 1) {
                $sql = "DELETE FROM `authdata` WHERE `user_id`=$user_id AND `auth_id`=$auth_id";
                delete($sql);
                $sql = "SELECT * FROM `authdata` WHERE `user_id`='$user_id' AND `auth_moren`=0";
                $rowa = queryRow($sql);
                if ($rowa) {
                    $newauthmorenid = $rowa['auth_id'];
                    $sql = "UPDATE `authdata` SET `auth_moren`= 1 WHERE `user_id`='$user_id' AND `auth_id` = '$newauthmorenid' AND `auth_moren`=0";
                    update($sql);
                }
            } else {
                $sql = "DELETE FROM `authdata` WHERE `user_id`=$user_id AND `auth_id`=$auth_id";
                delete($sql);
            }$authdelerrorid = 0;
        } else {
            $authdelerrorid = 4; //删除失败
        }
    }
}
?>
