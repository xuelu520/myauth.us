<?php

/* 检测数据中是否包含某KEY的值，是则返回TRUE，否则返回FALSE ,mode为post或get */

function check_data($key, $requestmode = "post") {
    if ($requestmode == "get") {
        if (isset($_GET[$key]) && $_GET[$key] != "") {
            return true;
        } else {
            return false;
        }
    } else {
        if (isset($_POST[$key]) && $_POST[$key] != "") {
            return true;
        } else {
            return false;
        }
    }
}

function betweenstring($str, $startstr, $endstr) {
    $strpos = mb_strpos($str, $startstr);
    if ($strpos < 0) {
        $strpos = 0;
    }
    $str = mb_substr($str, $strpos + mb_strlen($startstr));
    $endpos = mb_strpos($str, $endstr);
    if (empty($endpos)) {
        $endpos = mb_strlen($str);
    }
    return mb_substr($str, 0, $endpos);
}

//验证邮箱格式
function valid_email($email) {
    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
        return false;
    }
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if (!preg_match("/^(([A-Za-z0-9!#$%&#038;'*+\\/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+\\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
            return false;
        }
    }
    if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) {
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
            return false;
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                return false;
            }
        }
    }
    return true;
}

function db_iconv($key, $requestmode = "post", $trim = true, $modehtml = false) {
    global $dbconnect;
    if ($requestmode == "get") {
        if ($trim) {
            $data = trim($_GET[$key]);
        } else {
            $data = $_GET[$key];
        }
    } else {
        if ($trim) {
            $data = trim($_POST[$key]);
        } else {
            $data = $_POST[$key];
        }
    }

    if ($modehtml) {
        return mysqli_real_escape_string($dbconnect, htmlspecialchars($data, ENT_QUOTES));
    } else {
        return mysqli_real_escape_string($dbconnect, $data);
    }
}

//用户名合法性
function checkzhongwenzimushuzixiahuaxian($arrtxtabc) {
    if (!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u", $arrtxtabc)) { //utf-8汉字字母数字下划线正则表达式
        return false;
    } else {
        return true;
    }
}

function updatesynctime($region, $unixtime) {
    $time = date('Y-m-d H:i:s');
    $sql = "UPDATE `synctime` SET `sync`='$unixtime',`last_sync`='$time' WHERE `region`='$region'";
    update($sql);
}

function queryValue($sql) {
    global $dbconnect;
    $result = @mysqli_query($dbconnect, $sql);
    $row = mysqli_fetch_array($result);
    return $row[0];
}

function queryNum_rows($sql) {
    global $dbconnect;
    $result = @mysqli_query($dbconnect, $sql);
    if ($result == false) {
        return 0;
    }
    $num = mysqli_num_rows($result);
    return $num;
}

function queryRow($sql) {
    global $dbconnect;
    $result = @mysqli_query($dbconnect, $sql);
    if (!$result) {
        return false;
    }
    if (mysqli_num_rows($result) == 0) {
        return false;
    } else {
        $rowtemp = mysqli_fetch_array($result, MYSQL_ASSOC);
        return $rowtemp;
    }
}

function queryArray($sql) {
    global $dbconnect;
    $res = @mysqli_query($dbconnect, $sql);
    for ($i = 0, $row = mysqli_fetch_array($res, MYSQL_ASSOC); $row != false; $i++, $row = mysqli_fetch_array($res, MYSQL_ASSOC)) {
        $t[$i] = $row;
    }
    if (count($t) < 1) {
        return false;
    }
    return $t;
}

function insert($sql) {
    global $dbconnect;
    $res = @mysqli_query($dbconnect, $sql);
}

function update($sql) {
    global $dbconnect;
    $res = @mysqli_query($dbconnect, $sql);
}

function delete($sql) {
    global $dbconnect;
    $res = @mysqli_query($dbconnect, $sql);
}

//随机邮件验证码
function randstr($len = 40) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
// characters to build the password from
    mt_srand((double) microtime() * 1000000 * getmypid());
// seed the random number generater (must be done)
    $password = '';
    while (strlen($password) < $len)
        $password.=substr($chars, (mt_rand() % strlen($chars)), 1);
    return sha1(md5($password));
}

function send_mail($mailsubject, $mailtxt, $to, $successreturn, $failedreturn) {
    try {
        $mail = new PHPMailer(true);
        $body = $mailtxt;
        $body = preg_replace('/\\\\/', '', $body);
        $mail->IsSMTP(); // 使用SMTP
        $mail->SMTPAuth = true; // 启用SMTP验证
        $mail->Port = SMTP_PORT; // 设置SMTP端口
        $mail->Host = SMTP_HOST; // SMTP服务器
        $mail->Username = SMTP_USERNAME; // SMTP用户名
        $mail->Password = SMTP_PASSWD; // SMTP 密码
        $mail->SMTPSecure = "ssl";
        //$mail->IsSendmail(); // 如果报错请取消注释
        $mail->From = SMTP_USERNAME;
        $mail->FromName = "=?utf-8?B?" . base64_encode(SMTP_FROMNAME) . "?=";
        $mail->AddAddress($to);
        $mail->Subject = "=?utf-8?B?" . base64_encode($mailsubject) . "?=";
        $mail->AltBody = "若要查看本邮件，请使用支持HTML显示的邮箱客户端";
        $mail->WordWrap = 80;
        $mail->Charset = 'UTF-8';
        $mail->MsgHTML($body);
        $mail->IsHTML(true);
        $mail->Send();
        return $successreturn;
    } catch (Exception $e) {
        return $failedreturn;
    }
}

/* 提交添加AUTH数据验证 */

//区域是否正确
function checkauthregion($regions) {
    if ($regions == 21 || $regions == 22 || $regions == 23) {
        return true;
    } else {
        return false;
    }
}

//选择图片是否正确
function checkauthselectpic($selectpic) {
    if (preg_match("/^[1-5]$/", $selectpic)) {
        return true;
    } else {
        return false;
    }
}

//备注是否合法
function checkauthname($name) {
    $len = mb_strlen($name, "UTF-8");
    if ($len > 0 && $len < 13) {
        return true;
    } else {
        return false;
    }
}

//邮件找回密码的KEY是否正确
function checkcode($key) {
    if (preg_match("/^[A-Fa-f0-9]+$/u", $key) && strlen($key) == 40)
        return true;
    else
        return false;
}

function checkauthselectauthkey($key) {
    if (preg_match("/^[A-Fa-f0-9]+$/u", $key) && strlen($key) == 40)
        return true;
    else
        return false;
}

function checkauthselectrestorecode($restore) {
    if (preg_match("/^[A-Za-z0-9]+$/u", $restore) && strlen($restore) == 10)
        return true;
    else
        return false;
}

function checkauthselectcode($code) {
    if (ctype_digit($code) && strlen($code) == 4)
        return true;
    else
        return false;
}

//用户名合法性
function checkquestionvalue($arrtxtabc) {
    if ($arrtxtabc == 81 || $arrtxtabc == 82 || $arrtxtabc == 83 || $arrtxtabc == 84 || $arrtxtabc == 85 || $arrtxtabc == 86 || $arrtxtabc == 87 || $arrtxtabc == 88) {   //utf-8汉字字母数字下划线正则表达式
        return true;
    } else {
        return false;
    }
}

function emailpass($str) {
    $len = strlen($str);
    $strstart = substr($str, 0, 3);
    for ($i = 3; $i < $len; $i++) {
        $strstart = $strstart . "*";
    }
    return $strstart;
}

function checkpostusername($arruname) {
    global $dbconnect;
    $sql = "SELECT * FROM `users` WHERE `user_name`='$arruname'";
    if (queryNum_rows($sql) == 0) {
        return true;
    } else {
        return false;
    }
}

/**
 * 私钥解密 
 * 
 * @param string 密文（二进制格式且base64编码） 
 * @param string 密钥文件（.pem / .key） 
 * @param string 密文是否来源于JS的RSA加密 
 * @return string 明文 
 */
function privatekey_decodeing($crypttext, $fileName, $fromjs = FALSE) {
    $key_content = file_get_contents($fileName);
    $prikeyid = openssl_get_privatekey($key_content);
    $crypttext = base64_decode($crypttext);
    $padding = $fromjs ? OPENSSL_NO_PADDING : OPENSSL_PKCS1_PADDING;
    if (openssl_private_decrypt($crypttext, $sourcestr, $prikeyid, $padding)) {
        return $fromjs ? rtrim(strrev($sourcestr), "/0") : "" . $sourcestr;
    }
    return;
}

function check_vaild_post_unixtime($unixtime, $username) {
    if (!ctype_digit($unixtime)) {
        return false;
    }
    if (abs(time() - $unixtime) > 900) {//与服务器差别均较大的unix值抛弃
        return false;
    }
    $userunixindb = queryValue("select `lastused_session_time` from `users` where `user_name`='$username'");
    if ($userunixindb - $unixtime < 600) {//数据库时间小于当前时间前移5分钟的，认可
        $writedata = ($userunixindb < $unixtime ? $unixtime : $userunixindb);
        update("update `users` set `lastused_session_time`= '$writedata' where `user_name`='$username'");
        return true;
    }
    return false;
}

//非对称加密校验
function check_post_password($encryptpassword, $username) {
    $decodedpassword = getunencryptpass($encryptpassword);
    $unixtime = substr($decodedpassword, strlen($decodedpassword) - 10);
    if (check_vaild_post_unixtime($unixtime, $username) == false) {
        return false;
    }
    $sql = "SELECT * FROM `users` where `user_name`='$username'";
    $row = queryRow($sql);
    $md5password = $row['user_pass'];
    $data1 = $md5password . RSA_SALT . $unixtime;
    $data2 = md5($data1) . $unixtime;
    if ($data2 === $decodedpassword) {
        return true;
    }
    return false;
}

//非对称加密解密
function getunencryptpass($encryptpassword) {
    $encryptpassword = @base64_encode(pack("H*", $encryptpassword));
    $decodedpassword = privatekey_decodeing($encryptpassword, RSA_KEY_ADD, TRUE);
    $decodedpassword = trim($decodedpassword);
    return $decodedpassword;
}

function is_ipv6() {
    $ip = getIP();
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        return true;
    } else {
        return false;
    }
}

function getIP() /* 获取客户端IP */ {
    if (@$_SERVER["HTTP_X_FORWARDED_FOR"])
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    else if (@$_SERVER["HTTP_CLIENT_IP"])
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    else if (@$_SERVER["REMOTE_ADDR"])
        $ip = $_SERVER["REMOTE_ADDR"];
    else if (@getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (@getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (@getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $ip = "0.0.0.0";
    }
    return $ip;
}