<?php
include("header.php");

$code = $_REQUEST['code'];
$password_reset_code_sql = $db->query("select * from " . $db->tbl_pre . "password_reset_code_tbl where code='" . $code . "'", PDO::FETCH_BOTH);  //email is used as username, '1'=>'admin', '2'=>'subadmin'
$password_reset_code_num = $db->total($password_reset_code_sql);
if ($password_reset_code_num != 0)
{
  $password_reset_code_row = $db->result($password_reset_code_sql);
}
else
{
  $_SESSION['user_msg'] = messagedisplay('Password reset code is expired.', 2);
  //header('location: '.Site_Url);
  echo "<script>window.location.href='".Site_Url."'</script>";
  exit();
}


if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Submit') {
  $password = $_REQUEST['password'];
  $retype_password = $_REQUEST['retype_password'];
  if($password=="" || $retype_password=="")
  {
    $_SESSION['user_msg'] = messagedisplay('Fields can not be blanked.', 2);
    //header('location: '.Site_Url.'password_reset_link.php?code='.$code);
    echo "<script>window.location.href='".Site_Url."password_reset_link.php?code=".$code."'</script>";
    exit();
  }
  elseif($password==$retype_password)
  {
    $password_reset_array = array('password' => md5($password));

    $password_reset_result = $db->update('users_tbl', $password_reset_array, "id='".$password_reset_code_row[0]['user_id']."'");
    if($password_reset_result['affectedRow']>0)
    {
      $db->delete("password_reset_code_tbl", "user_id='" . $password_reset_code_row[0]['user_id'] . "'");

      $_SESSION['user_msg'] = messagedisplay('Password has been reset successfully.', 1);
      //header('location: '.Site_Url);
      echo "<script>window.location.href='".Site_Url."'</script>";
      exit();
    }
    else
    {
      $_SESSION['user_msg'] = messagedisplay('Password does not reset due to error or you have entered old password again', 2);
      //header('location: '.Site_Url.'password_reset_link.php?code='.$code);
      echo "<script>window.location.href='".Site_Url."password_reset_link.php?code=".$code."'</script>";
      exit();
    }
  }
  else
  {
    $_SESSION['user_msg'] = messagedisplay('Password does not matched.', 2);
    //header('location: '.Site_Url.'password_reset_link.php?code='.$code);
    echo "<script>window.location.href='".Site_Url."password_reset_link.php?code=".$code."'</script>";
    exit();
  }
  
}

?>

<?php
include("top.php");
?>

      <div class="inner-content other">
        <div class="container">
          <div class="row">
            <div class="col-md-12 col-sm-12">
             <div class="forgot clearfix">
              <?php 
              	echo $_SESSION['user_msg'];
              	$_SESSION['user_msg']="";
              ?>
              	<form action="" method="post" data-toggle="validator" role="form">
	                <div class="form-group">
	                  <label for="passwordReset" class="control-label">Password</label>  
	                  <input type="password" name="password" id="passwordReset" data-minlength="6" class="form-control" autocomplete="off" required>
	                  <div class="help-block">Minimum of 6 characters</div>
	                </div>
	                <div class="form-group">
	                  <label for="retype_passwordReset" class="control-label">Retype Password</label>    
	                  <input type="password" name="retype_password" id="retype_passwordReset" class="form-control" autocomplete="off" data-match="#passwordReset" data-match-error="These don't match" required>
	                  <div class="help-block with-errors"></div>
	                </div>
	                <div class="form-group">  
	                  <input class="btn style2" type="submit" name="submit" value="Submit">
	                </div>
              </form>

            </div>
            </div>
          </div>
        </div>
      </div>

<?php
include("footer.php");
?>