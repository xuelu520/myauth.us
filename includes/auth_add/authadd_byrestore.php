<?php

//fix
defined("ZHANGXUAN") or die("no hacker.");
$authaddbyrestoreerrorid = -1; //1内容不完整，2内容不合法，3未登入，4验证码错误,-1未知错误，5生成失败
$strregion[21] = "CN";
$strregion[22] = "US";
$strregion[23] = "EU";
$auth_moren = 0;
if ($logincheck == 0) {
    $authaddbyrestoreerrorid = 3;
} else {
    if (check_data("letters_code")) {
        $postcode = db_iconv("letters_code");
        if (md5(strtolower($postcode)) == $_SESSION['letters_code']) {
            if (check_data('authname') && check_data('region') && check_data('authcodeA3') && check_data('authcodeB3') && check_data('authcodeC3') && check_data('authrestore') && check_data('selectpic')) {
                $region = db_iconv('region', "post", TRUE, true);
                $athcode1 = db_iconv('authcodeA3', "post", TRUE, true);
                $athcode2 = db_iconv('authcodeB3', "post", TRUE, true);
                $athcode3 = db_iconv('authcodeC3', "post", TRUE, true);
                $authname = db_iconv('authname', "post", TRUE, true);
                $selectpic = db_iconv('selectpic', "post", TRUE, true);
                $authrestorecode = db_iconv('authrestore', "post", TRUE, true);
                if (checkauthname($authname) && checkauthregion($region) && checkauthselectpic($selectpic) && checkauthselectcode($athcode1) && checkauthselectcode($athcode2) && checkauthselectcode($athcode3) && checkauthselectrestorecode($authrestorecode)) {
                    try {
                        $region = $strregion[$region];
                        $authserial = "$region-$athcode1-$athcode2-$athcode3";
                        $auth = @Authenticator::restore($authserial, $authrestorecode);
                        $authserect = $auth->secret();
                        //$authsynctime = $auth->getsync();
                        if (checkauthname('morenauthset')) {
                            $morenauthset = db_iconv('morenauthset', "post", TRUE, true);
                            if ($morenauthset == "on") {
                                update("UPDATE `authdata` SET `auth_moren`=0 WHERE `user_id`='$user_id' AND `auth_moren`=1");
                                $auth_moren = 1;
                            }
                        }
                        if (queryValue("SELECT COUNT(*) FROM `authdata` WHERE `user_id`='$user_id' AND `auth_moren`=1") == 0) {
                            $auth_moren = 1;
                        }
                        if (is_null($authserial)) {
                            $authaddbyrestoreerrorid = 5;
                        } else {
                            insert("INSERT INTO `authdata`(`user_id`, `auth_moren`, `auth_name`, `serial`, `region`, `secret`,`restore_code`, `auth_img`) VALUES ('$user_id','$auth_moren','$authname','$authserial','$region','$authserect','$authrestorecode','$selectpic')");
                            $sql = "SELECT `auth_id` FROM `authdata` WHERE `serial`='$authserial' AND `user_id`='$user_id' AND `auth_name`='$authname'";
                            $rowtemp = queryRow($sql);
                            echo$auth_id = $rowtemp['auth_id'];
                            if ($auth_id > 0) {
                                $authaddbyrestoreerrorid = 0;
                            } else {
                                $authaddbyrestoreerrorid = 5;
                            }
                        }
                    } catch (phpmailerException $e) {
                        $authaddbyrestoreerrorid = 5;
                    }
                } else {
                    $authaddbyrestoreerrorid = 2;
                }
            } else {
                $authaddbyrestoreerrorid = 1;
            }
        } else {
            $authaddbyrestoreerrorid = 4;
        }
    } else {
        $authaddbyrestoreerrorid = 1;
    }
    $_SESSION['letters_code'] = md5(rand());
}
?>
