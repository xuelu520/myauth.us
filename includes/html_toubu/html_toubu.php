<?php
defined("ZHANGXUAN") or die("no hacker.");
//fixed mysql func
?>
<!DOCTYPE html>
<html>
    <head> 
        <script>
            var siteaddressforalljsfile="<?php echo SITEHOST; ?>";
            var ifnotloginiframecanchangethisvalue=false;
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="og:title" content="<?php echo TITLENAME ?>">
        <meta name="og:description" content="<?php echo WEIBOMESSAGE ?>">
        <meta property="og:image" content="resources/weiboimg/fbshare.png" />
        <title><?php echo TITLENAME . "-$topnavvalue" ?></title>
        <link rel="stylesheet" href="resources/css/articles.css" type="text/css" />
        <link rel="stylesheet" href="resources/css/header.css" type="text/css" />
        <link rel="stylesheet" href="resources/css/body.css" type="text/css" />
        <link rel="stylesheet" href="resources/css/footer.css" type="text/css" />
        <link rel="shortcut icon" type="image/x-icon" href="resources/img/favicon.ico"> 
        <?php
        if (SSLMODE == 1) {
            echo '<script type="text/javascript" src="https://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>';
        } else {
            echo '<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>';
        }
        ?>
        <script type="text/javascript" src="resources/js/common.js"></script>
        <script type="text/javascript" src="resources/js/third-party.js"></script>
        <script type="text/javascript" src="resources/js/rsa.js"></script>
        <script type="text/javascript" src="resources/js/md5.js"></script>
        <script type="text/javascript">
            Login.embeddedUrl = '<?php echo SITEHOST ?>iframelogin.php';
        </script>
        <script type="text/javascript">
            var _hmt = _hmt || [];
            (function() {
                var hm = document.createElement("script");
                var Baidu_Js_Server = (("https:" == document.location.protocol) ? "https://" : "http://");
                hm.src = Baidu_Js_Server+"hm.baidu.com/hm.js?0abf57ffe072b473a0418ad8c368f7d2";
                var s = document.getElementsByTagName("script")[0]; 
                s.parentNode.insertBefore(hm, s);
            })();
        </script>
    </head>
    <body>
