<?php
defined("ZHANGXUAN") or die("no hacker.");
?>
<script language='javascript' type='text/javascript'>
    var secs =<?php echo strtotime($user_thislogin_time) + 1800 - time(); ?>; //倒计时的秒数
    var URL ;
    function Load(url){
        URL =url;
        for(var i=secs;i>=0;i--)
        {
            window.setTimeout('doUpdate(' + i + ')', (secs-i) * 1000);
        }
    }
    function doUpdate(num)
    {
        document.getElementById('ShowDiv').innerHTML = '<h3>将在'+num+'秒后自动跳转<br>如果你的浏览器不支持自动跳转，<a href="<?php echo SITEHOST ?>">请点击跳转</a></h3>' ;
        if(num == 0) { window.top.location.href=URL }
    }
</script>
<div id="wrapper">
    <h1 id="logo"><a href="<?php echo SITEHOST; ?>"><img src="resources/img/bn-logo.png" alt=""></a></h1>
    <div id="contentloged" class="login">
        <h2 style="text-align: center;"><br><br>本共享账号上次登陆于<?php echo $user_thislogin_time ?>,距现在不足30分钟,请稍后再试.</h2>
        <script language="javascript">   
            Load("<?php echo SITEHOST ?>"); //要跳转到的页面   
        </script>    
    </div>
    <div id="ShowDiv"></div>
</div>