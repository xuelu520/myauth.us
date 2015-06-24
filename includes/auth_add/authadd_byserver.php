<?php
//fix
defined("ZHANGXUAN") or die("no hacker.");
$authaddbyservererrorid = -1; //1内容不完整，2内容不合法，3未登入，4验证码错误,-1未知错误，5生成失败
$strregion[21] = "CN";
$strregion[22] = "US";
$strregion[23] = "EU";
$auth_moren = 0;
if ($logincheck == 0) {
    $authaddbyservererrorid = 3;
} else {
    if (check_data("letters_code")) {
        $postcode = db_iconv("letters_code");
        if (md5(strtolower($postcode)) == $_SESSION['letters_code']) {
            if (check_data('authname') && check_data('region') && check_data('selectpic')) {
                $region = db_iconv('region', "post", TRUE, true);
                $authname = db_iconv('authname', "post", TRUE, true);
                $selectpic = db_iconv('selectpic', "post", TRUE, true);
                if (checkauthname($authname) && checkauthregion($region) && checkauthselectpic($selectpic)) {
                    $region = $strregion[$region];
                    try {
                        $auth = @Authenticator::generate($region);
                        $authserial = $auth->serial();
                        $authserect = $auth->secret();
                        $authrestorecode = $auth->restore_code();
                        if (isset($_POST['morenauthset'])) {
                            if ($_POST['morenauthset'] == "on") {
                                $sql = "UPDATE `authdata` SET `auth_moren`=0 WHERE `user_id`='$user_id' AND `auth_moren`=1";
                                update($sql);
                                $auth_moren = 1;
                            }
                        }
                        if (queryValue("SELECT COUNT(*) FROM `authdata` WHERE `user_id`='$user_id' AND `auth_moren`=1") == 0) {
                            $auth_moren = 1;
                        }
                        if (is_null($authserial))
                            $authaddbyservererrorid = 5;
                        else {
                            insert("INSERT INTO `authdata`(`user_id`, `auth_moren`, `auth_name`, `serial`, `region`, `secret`,`restore_code`, `auth_img`) VALUES ('$user_id','$auth_moren','$authname','$authserial','$region','$authserect','$authrestorecode','$selectpic')");
                            $authaddbyservererrorid = 0;
                            $sql = "SELECT `auth_id` FROM `authdata` WHERE `serial`='$authserial' AND `user_id`='$user_id' AND `auth_name`='$authname'";
                            $rowtemp = queryRow($sql);
                            $auth_id = $rowtemp['auth_id'];
                            if ($auth_id > 0) {
                                $authaddbyservererrorid = 0;
                            } else {
                                $authaddbyservererrorid = 5;
                            }
                        }
                    } catch (phpmailerException $e) {
                        $authaddbyservererrorid = 5;
                    }
                } else {
                    $authaddbyservererrorid = 2;
                }
            } else {
                $authaddbyservererrorid = 1;
            }
        } else {
            $authaddbyservererrorid = 4;
        }
    } else {
        $authaddbyservererrorid = 1;
    }
    $_SESSION['letters_code'] = md5(rand());
}
?>
