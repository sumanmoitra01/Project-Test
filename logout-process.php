<?php
include "includes/frontend_common.php";
session_destroy();
session_start();
$_SESSION['user_msg'] = messagedisplay("You have successfully logout.",1);
header('Location: '. Site_Url);
?>
