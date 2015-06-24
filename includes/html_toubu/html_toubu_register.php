<?php
defined("ZHANGXUAN") or die("no hacker.");
?>
<!DOCTYPE html>
<html>
    <head>
        <script>
            var siteaddressforalljsfile="<?php echo SITEHOST; ?>";
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="og:title" content="<?php echo TITLENAME ?>">
        <meta name="og:description" content="<?php echo WEIBOMESSAGE ?>">
        <meta property="og:image" content="resources/weiboimg/fbshare.png" />
        <title>战网安全令在线版-注册</title>
        <link rel="stylesheet" href="resources/css/articles.css" type="text/css" />
        <link rel="shortcut icon" type="image/x-icon" href="resources/img/favicon.ico"> 
        <link rel="stylesheet" href="resources/css/header.css" type="text/css" />
        <link rel="stylesheet" href="resources/css/body.css" type="text/css" />
        <link rel="stylesheet" href="resources/registercss/register.css" type="text/css" />
        <link rel="stylesheet" href="resources/css/footer.css" type="text/css" />
        <?php
        if (SSLMODE == 1) {
            echo '<script type="text/javascript" src="https://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>';
        } else {
            echo '<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>';
        }
        ?>
        <script type="text/javascript" src="resources/js/class-inheritance.js"></script>
        <script type="text/javascript" src="resources/js/md5.js"></script>
        <script type="text/javascript" src="resources/js/rsa.js"></script>
        <script type="text/javascript" src="resources/js/inputs.js"></script>
        <script type="text/javascript" src="resources/js/streamlined-creation.js"></script>
        <script type="text/javascript">
            //<![CDATA[
            $(function() {
                var inputs = new Inputs('#creation');
                var creation = new Creation('#creation');
            });
            jquerycodechecked=false;
            $(document).ready(function(){
                $("#letters_code").keyup(function(){
                    if($("#letters_code")[0].value.length==6){
                        checkyanzhenma($("#letters_code")[0].value);
                        jquerycodechecked=true;
                    }else{
                        jquerycodechecked=false;
                        document.getElementById('checkyanzhenmaajax').innerHTML = "";
                    }
                });
            });
            //]]>
        </script>
        <script>
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