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
        document.getElementById('ShowDiv').innerHTML = '<h3>将在'+num+'秒后自动关闭</h3>' ;
        if(num == 0) { 
            closeiframe();
        }
    }
</script>
<div id="embedded-login">
    <h1>Battle.net</h1>
    <div id="contentloged" class="login">
        <h2 style="text-align: center;"><br><br>本共享账号上次登陆于<?php echo $user_thislogin_time ?>,距现在不足30分钟,请稍后再试.</h2><br>
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
        
        function closeiframe() { 
            $(window.parent.document).find("#login-embedded").fadeOut("slow", function() {
                $(window.parent.document).find("#blackout").css('display','none'); 
                $(this).remove();
            });
        }
    </script>
</div>
</body>
</html>