<?php
include("header.php");

if($_SESSION['user_msg']=="")
{
	echo "<script>window.location.href='".Site_Url."'</script>";
}
?>

<?php
include("top.php");
?>

      <div class="inner-content">
        <div class="container">
          <div class="row">
            <div class="col-sm-12">
              <?php 
              	echo $_SESSION['user_msg'];
              	$_SESSION['user_msg']="";
              ?>
            </div>
          </div>
        </div>
      </div>

<?php
include("footer.php");
?>