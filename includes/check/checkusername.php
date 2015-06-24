<?php
//fix
include('../config.php');
if (check_data('id','get')) {
    if (!checkzhongwenzimushuzixiahuaxian($_GET['id'])) {
        echo "inlegal";
    } else {
        $user = db_iconv('id', 'get', true, true);
        $sql = "SELECT * FROM `users` WHERE `user_name`='$user'";
        if (queryNum_rows($sql) == 0) {
            echo "true";
        } else {
            echo "false";
        }
    }
} else {
    echo "";
}
?>