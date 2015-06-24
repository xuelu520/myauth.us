<?php
//fix
session_start();
include('../config.php');
if (check_data('code','get')) {
    if (md5(strtolower($_GET['code'])) == $_SESSION['letters_code']) {
        echo "true";
    } else {
        echo "false";
    }
}else
    echo "false";
?>