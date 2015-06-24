<?php
defined("ZHANGXUAN") or die("no hacker.");
?>
<script language='javascript' type='text/javascript'>
    var secs =3; //倒计时的秒数
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
        document.getElementById('ShowDiv').innerHTML = '<h3>将在'+num+'秒后自动关闭并刷新主页</h3>' ;
        if(num == 0) { 
            window.parent.window.location.href=URL
        }
    }
</script>
<div id="embedded-login">
    <h1>Battle.net</h1>
    <div id="contentloged" class="login">
        <h2 style="text-align: center;"><br><br>恭喜你，你已成功登入，即将跳转到主页</h2>
        <script language="javascript">   
            Load("<?php echo SITEHOST ?>"); //要跳转到的页面   
        </script>    
    </div>
    <div id="ShowDiv"></div>
    <script> 
        $(window.parent.document).find("iframe").load(function(){
            var main = $(window.parent.document).find("iframe");
            var thisheight = $(document).height();
            $(window.parent.document).find("#login-embedded").height(thisheight);
            main.height(thisheight);
            parent.ifnotloginiframecanchangethisvalue=true;
        });
    </script>
</div>
</body>
</html>