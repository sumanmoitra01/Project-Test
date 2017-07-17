<?php 
check_login(current_url());
$user_array=$user->user_display($db->tbl_pre."users_tbl",array(),"where id='".$_SESSION['user_id']."'");
?>