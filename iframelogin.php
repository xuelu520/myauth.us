<?php

include('includes/config.php');
include('includes/html_toubu/html_toubu_iframelogin.php');
include('includes/login/login_check.php');
if ($logincheck == 1)
    include ('includes/login/iframelogin_checked.php');
elseif ($logincheck == 2)
    include ('includes/login/iframelogin_lowright.php');
else
    include('includes/login/iframelogin_inc.php');
?>

