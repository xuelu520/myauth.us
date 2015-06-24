<?php
//fix
defined("ZHANGXUAN") or die("no hacker.");
?>
<script language='javascript' type='text/javascript'>
    function refresh() {
        location.reload();
    }
</script>

<link rel="stylesheet" href="resources/css/authbody.css" type="text/css" />
<div id="layout-middle">
    <div id="homewrapper">
        <div id="content">
            <div id="page-content">
                <div id="breadcrumb">
                    <ol class="ui-breadcrumb">
                        <li><a href="<?php echo SITEHOST; ?>">首页</a></li>
                        <li class="last"><a href="<?php echo $navurladd; ?>"><?php echo $topnavvalue ?></a></li>
                    </ol>
                </div>
            </div>
            <div id="contentloged" class="login">
                <h2 style="text-align: center;"><br><br><?php echo $jumptxt; ?></h2> 
            </div>
            <div id="ShowDiv"><h3>暴雪安全令服务器拒绝了本次请求，<a href="javascript:viod(0);" onclick="refresh();">请点击刷新</a>再试</h3></div>

        </div>
    </div>
</div>