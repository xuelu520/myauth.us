<?php
defined("ZHANGXUAN") or die("no hacker.");
//fixed mysql func
?>
<div id="layout-top">
    <div id="topwrapper">
        <div id="topnav">
            <ul class="top-nav">
                <li class="top-core top-home">
                    <a href="<?php echo SITEHOST ?>"  title="首页"> </a>
                </li>
                <li class='top-core top-all'>
                    <?php
                    @session_start();
                    $logincheck = 0;
                    if (isset($_SESSION['loginuser']) && !empty($_SESSION['loginuser'])) {//看session是否登入
                        $user = mysqli_real_escape_string($dbconnect, htmlspecialchars($_SESSION['loginuser']));
                        echo "欢迎，" . strtoupper($user) . " | <a  onclick=\"if(confirm('若你的账号在其他电脑登录过本站,亦会一并登出,你确认要登出吗'))return true;else return false;\" href='" . SITEHOST . "logout.php'>登出</a></li><li class='top-core top-data'><a href='" . SITEHOST . "account.php'>账号管理</a></li><li class='top-core top-data'><a href='" . SITEHOST . "myauthall.php'>我的安全令</a></li><li class='top-core top-final'><a href='" . SITEHOST . "donate.php'>捐赠</a>";
                        $logincheck = 1;
                    } else if (isset($_COOKIE['loginname']) && isset($_COOKIE['loginid']) && $_COOKIE['loginname'] != "" && $_COOKIE['loginid'] != "") {//看cookie是否登入
                        $user = mysqli_real_escape_string($dbconnect, htmlspecialchars($_COOKIE['loginname']));
                        $cookievalue = mysqli_real_escape_string($dbconnect, htmlspecialchars($_COOKIE['loginid'], ENT_QUOTES));
                        $sql = "SELECT * FROM `cookiedata` WHERE `user_name`='$user' AND `user_cookie` ='$cookievalue'";
                        $result = queryRow($sql);//有返回第一行，没有返回false
                        if ($result) {
                            $rowtemp = $result;
                            $timedifference = time() - strtotime($rowtemp['login_time']);
                            if ($timedifference <= 30 * 24 * 60 * 60) {//cookie有效
                                $sql = "SELECT * FROM `users` WHERE `user_name`='$user'";
                                $rowtemp = queryRow($sql);
                                $user_thistimelogin_ip = $rowtemp['user_thistimelogin_ip'];
                                $user_thislogin_time = $rowtemp['user_thislogin_time'];
                                $user_right = $rowtemp['user_right'];
                                if ($user_right == 1) {//限制账号用户，1800秒有效期，专为堕落的猴子设计，温柔的哈娜呢
                                    if ($timedifference > 1800) {
                                        $sql = "DELETE FROM `cookiedata` WHERE `user_name`='$user' AND `user_cookie` ='$cookievalue'";
                                        delete($sql);
                                        setcookie("loginname", "", time() - 3600, "/");
                                        setcookie("loginid", "", time() - 3600, "/");
                                        $logincheck = 0;
                                        echo "<a href='login.php' onclick='return Login.open()'>登入</a> 或 <a href='" . SITEHOST . "register.php'>注册一个账号</a></li><li class='top-core top-data'><a href='" . SITEHOST . "faq.php'>FAQ</a></li><li class='top-core top-data'><a href='" . SITEHOST . "account.php'>账号管理</a></li><li class='top-core top-final'><a href='" . SITEHOST . "donate.php'>捐赠</a>";
                                    } else {
                                        $logincheck = 1;
                                        $userip = getIP();
                                        $sql = "UPDATE `cookiedata` SET `user_login_ip`='$userip' WHERE `user_name`='$user' AND `user_cookie` ='$cookievalue'";
                                        update($sql);
                                        echo "欢迎，" . strtoupper($user) . " | <a  onclick=\"if(confirm('若你的账号在其他电脑登录过本站,亦会一并登出,你确认要登出吗'))return true;else return false;\" href='" . SITEHOST . "logout.php'>登出</a></li><li class='top-core top-data'><a href='" . SITEHOST . "account.php'>账号管理</a></li><li class='top-core top-data'><a href='" . SITEHOST . "myauthall.php'>我的安全令</a></li><li class='top-core top-final'><a href='" . SITEHOST . "donate.php'>捐赠</a>";
                                    }
                                } else {
                                    $_SESSION['loginuser'] = $user;
                                    echo "欢迎，" . strtoupper($user) . " | <a  onclick=\"if(confirm('若你的账号在其他电脑登录过本站,亦会一并登出,你确认要登出吗'))return true;else return false;\" href='" . SITEHOST . "logout.php'>登出</a></li><li class='top-core top-data'><a href='" . SITEHOST . "account.php'>账号管理</a></li><li class='top-core top-data'><a href='" . SITEHOST . "myauthall.php'>我的安全令</a></li><li class='top-core top-final'><a href='" . SITEHOST . "donate.php'>捐赠</a>";
                                    $logincheck = 1;
                                    $userip = getIP();
                                    $date = date('Y-m-d H:i:s');
                                    $sql = "UPDATE `cookiedata` SET `user_login_ip`='$userip' WHERE `user_name`='$user' AND `user_cookie` ='$cookievalue'";
                                    update($sql);
                                    $sql = "UPDATE `users` SET `user_lastlogin_ip`='$user_thistimelogin_ip',`user_thistimelogin_ip`='$userip',`user_lastlogin_time`='$user_thislogin_time', `user_thislogin_time`='$date' WHERE `user_name`='$user'";
                                    update($sql);
                                }
                            } else {
                                $sql = "DELETE FROM `cookiedata` WHERE `user_name`='$user' AND `user_cookie` ='$cookievalue'";
                                delete($sql);
                                setcookie("loginname", "", time() - 3600, "/");
                                setcookie("loginid", "", time() - 3600, "/");
                                echo "<a href='login.php' onclick='return Login.open()'>登入</a> 或 <a href='" . SITEHOST . "register.php'>注册一个账号</a></li><li class='top-core top-data'><a href='" . SITEHOST . "faq.php'>FAQ</a></li><li class='top-core top-data'><a href='" . SITEHOST . "account.php'>账号管理</a></li><li class='top-core top-final'><a href='" . SITEHOST . "donate.php'>捐赠</a>";
                            }
                        } else {
                            setcookie("loginname", "", time() - 3600, "/");
                            setcookie("loginid", "", time() - 3600, "/");
                            echo "<a href='login.php' onclick='return Login.open()'>登入</a> 或 <a href='" . SITEHOST . "register.php'>注册一个账号</a></li><li class='top-core top-data'><a href='" . SITEHOST . "faq.php'>FAQ</a></li><li class='top-core top-data'><a href='" . SITEHOST . "account.php'>账号管理</a></li><li class='top-core top-final'><a href='" . SITEHOST . "donate.php'>捐赠</a>";
                        }
                    } else {
                        echo "<a href='login.php' onclick='return Login.open()'>登入</a> 或 <a href='" . SITEHOST . "register.php'>注册一个账号</a></li><li class='top-core top-data'><a href='" . SITEHOST . "faq.php'>FAQ</a></li><li class='top-core top-data'><a href='" . SITEHOST . "account.php'>账号管理</a></li><li class='top-core top-final'><a href='" . SITEHOST . "donate.php'>捐赠</a>";
                    }
                    if (check_data('authid','get')) {
                        if ($logincheck == 1) {
                            if (ctype_digit($_GET['authid'])) {//不是整数不通过，防止SQL注入
                                $auth_id = $_GET['authid'];
                                $sql = "SELECT * FROM `users` WHERE `user_name`='$user'";
                                $rowtemp = queryRow($sql);
                                $user_id = $rowtemp['user_id'];
                                $user_right = $rowtemp['user_right'];
                                $sql = "SELECT * FROM `authdata` WHERE `user_id`='$user_id' AND `auth_id`='$auth_id'";
                                $rowauth = queryRow($sql);
                                if ($rowauth) {//是你的
                                    $autherrid = 0; //没错
                                } else {
                                    $autherrid = 1; //1不是你所有的安全令
                                }
                            } else {
                                $autherrid = 2; //2错误的GET数据
                            }
                        } else {
                            $autherrid = 3; //3他妈没登入就想玩啊
                        }
                    } else {
                        $autherrid = 2;//2错误的GET数据
                    }
                    ?></li>

            </ul>
        </div>
        <div id="header" style="height:<?php if ($topnavvalue) echo 170;
                    else echo 130; ?>px;">
            <div id="toplogo">
                <a href="<?php echo SITEHOST ?>" title="首页"><img src="resources/img/bn-logo.png" alt=""></a>
            </div>
            <?php
            if ($topnavvalue) {
                echo '<div id="navigation"><div id="page-menu" class="large"><h2 id="isolated" class="isolated">' . $topnavvalue . '</h2></div></div>';
            }
            ?>
        </div>
    </div>
</div>