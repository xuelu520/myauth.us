<?php
defined("ZHANGXUAN") or die("no hacker.");
$navurladd = SITEHOST . "about.php";
//fixed mysql func
?>
<div id="layout-middle" style="height: 975px;">
    <div id="homewrapper">
        <div id="content">
            <div id="page-content">
                <div id="breadcrumb">
                    <ol class="ui-breadcrumb">
                        <li><a href="<?php echo SITEHOST; ?>">首页</a></li>
                        <li class="last"><a href="<?php echo $navurladd; ?>"><?php echo $topnavvalue ?></a></li>
                    </ol>
                </div>
                <div class="article-column">
                    <div id="article-container">
                        <div id="article">
                            <div class="article-games">
                                <a href="/"><img src="resources/img/auth.png" alt=""></a>
                            </div>
                            <h2 id="article-title"> 欢迎使用战网安全令在线版 </h2>
                            <div id="article-content">
                                <h3 class="article-ci"> 关于本站 </h3>
                                <p>
                                    本站是由竹井詩織里开发的战网安全令颁发与动态密码查看站点<br>
                                    本站属于业余开发，请不要与专业团队相提并论，开发人员比较呆蠢笨，容易犯错误，如发现BUG请<a href="mailto:webmaster@myauth.us">联系我们</a>
                                </p>
                                <p>
                                    战网安全令在线版开发团队(竹井詩織里)未非盈利机构，不会为本站服务向您强制收取任何费用，您所享受的一切服务都是免费的<br>
                                    请认准本站唯一域名<a href="<?php echo SITEHOST ?>"><?php echo SITEHOST ?></a>，虽然我们不钓鱼，但是其他网站说不定哪天就来钓本站的鱼了
                                </p>
                                <p>
                                    2014年2月26日正式版上线,修复几个错误,同时邮件地址认证功能实装了.<br>
                                    2015年6月22日新版上线,修复多个BUG,使用非对称加密技术确保密码传输过程中的安全性.
                                    <br>开放源代码地址:<a href="https://github.com/ymback/myauth.us">https://github.com/ymback/myauth.us</a>,License:GNU GPL v2.
                                </p>
                                <p>麻烦用我的Github里的源码建站的朋友留下点我的信息谢谢啊，我看的有个网站把我的信息全给删了，还把开发者叫XX，你这样也算是混Git的？</p>
                                <h3 class="article-ci"> 本站认证 </h3>
                                <p class="alignleft" style="font-size: 16px;margin-bottom: 0px;">①360网站安全认证</p>
                                <a href="http://webscan.360.cn/index/checkwebsite/url/www.myauth.us">
                                    <img border="0" src="http://img.webscan.360.cn/status/pai/hash/295153ef7bd118d60bd1e664e13de7a9" alt=""></a>
                                <p class="alignleft" style="font-size: 16px;margin-bottom: 0px;">②W3C-HTML代码验证</p>
                                <a href="http://validator.w3.org/check?uri=referer"><img
                                        src="http://www.w3.org/Icons/valid-xhtml10"
                                        alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
                                <p class="alignleft" style="font-size: 16px;margin-bottom: 0px;">③W3C-CSS3代码验证</p>
                                <a href="http://jigsaw.w3.org/css-validator/check/referer">
                                    <img style="border:0;width:88px;height:31px"
                                         src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
                                         alt="Valid CSS!" />
                                </a>

                                <p class="alignleft" style="font-size: 16px;margin-bottom: 0px;">④IPv6启用认证</p>
                                <div id=ipv6_enabled_www_test_logo>
                                    <?php if (is_SSL()) { ?>
                                        <div id="ipv6_enabled_www_test_logo"><div style="background-image:url(http://www.ipv6forum.com/ipv6_enabled/public/images/dynamic_logo_background_right.png);padding:0px;background-position:right;background-repeat:no-repeat;width:240px;height:98px;margin:0px;text-align:left;font-size:9pt;line-height:100%;"><div style="color:#fff;font-size:9pt;height:98px;width:235px;repeat:repeat-y; background-image:url(http://www.ipv6forum.com/ipv6_enabled/public/images/dynamic_logo_backgroud_main.png);margin:0;padding:0"><div style="float:left;margin:0;padding:0"><img src="http://www.ipv6forum.com/ipv6_enabled/public/images/dynamic_logo_background_left.png"></div><div style="padding-right:0;padding-bottom:0;padding-top:5px;padding-left:80px;word-break:break-all;"><span style="font-weight:bold;font: arial,sans-serif;color:#3EC73C">Status:</span><span style="font-style:italic;font: arial,sans-serif;color:#fff;"><a href="http://www.ipv6forum.com/ipv6_enabled/approval_list.php" style="color:#fff;text-decoration: none;background:transparent"> IPv6 Enabled</a><br></span><span style="font-weight:bold;font: arial,sans-serif;color:#3EC73C">Last:  </span><span style="font-style:italic;font: arial,sans-serif;color:#fff;"> 2015-03-20<br></span><span style="font-weight:bold;font: arial,sans-serif;color:#3EC73C">URL:   </span><span style="font-style:italic;font: arial,sans-serif;color:#fff;">myauth.us<br></span>
                                                        <?php if (!is_ipv6()) { ?>
                                                            <span style="font-weight:bold;font: arial,sans-serif;color:#50001E">  ACCESSING VIA IPv4 NOW</span>
                                                            <?php } ?>
                                                            <span style="font-weight:bold;font: arial,sans-serif;color:#50001E"></span></div></div></div></div>
                                        <?php } ?>    
                                    </div>
                                    <br>
                                    <h3 class="article-ci"> 版权所有 </h3>
                                    <p>战网安全令在线版 ©
                                        <?php
                                        if (date('Y') == 2013)
                                            echo "2013";
                                        else
                                            echo "2013-" . date('Y');
                                        ?> 竹井詩織里  <br>All rights reserved
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div></div>
    <?php if (!is_SSL()) { ?>
        <script language="JavaScript" type="text/javascript">
            var Ipv6_Js_Server = (("https:" == document.location.protocol) ? "https://" : "http://");
            document.write(unescape("%3Cscript src='" + Ipv6_Js_Server + "www.ipv6forum.com/ipv6_enabled/sa/SA.php?id=4376' type='text/javascript'%3E%3C/script%3E"));
        </script>      
    <?php } ?>    