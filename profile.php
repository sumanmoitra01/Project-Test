<?php
include("header.php");

include("includes/session.php");

$_SESSION['user_manage_url'] = Site_Url.'profile.php';
$user_id = $_SESSION['user_id'];

$action = $_REQUEST['action'];

if ($_REQUEST['submit'] == 'Save')
{
  $name = $_REQUEST['name'];
  $company_name = $_REQUEST['company_name'];
  $email = $_REQUEST['email'];
  $country_code = $_REQUEST['country_code'];
  $phone = $_REQUEST['phone'];
  $address = $_REQUEST['address'];
  $city = $_REQUEST['city'];
  $state = $_REQUEST['state'];
  $zip_code = $_REQUEST['zip_code'];
  
  $name_value = array('name' => rep($name), 'company_name' => rep($company_name), 'email' => rep($email), 'country_code' => rep($country_code), 'phone' => rep($phone), 'address' => rep($address), 'city' => rep($city), 'state' => rep($state), 'zip_code' => rep($zip_code));

  if($_REQUEST['password'])
  {
    $password = md5($_REQUEST['password']);
    $name_value['password'] = $password;
  }

  $user->user_edit($name_value, $user_id, "Profile updated successfully.", "Sorry, nothing is updated.", "Sorry, email is already added. Please use another email.", "Sorry, phone number is already added. Please use another phone number.");

}
?>

<div class="inner-content other">
        <div class="container">
          <div class="title-wrap">
            <h1>Dashboard</h1>
          </div>
          <div class="row">
           <div class="profile_details">
            <div class="col-md-6 col-sm-6">
              <div class="dboard-col mHeight">
                <ul>
                  <li><i class="fa fa-user" aria-hidden="true"></i>Name : <span><?php echo $user_array[0]['name'];?></span></li>
                  <li><i class="fa fa-building" aria-hidden="true"></i>Company Name : <span><?php echo $user_array[0]['company_name'];?></span></li>
                  <li><i class="fa fa-envelope" aria-hidden="true"></i>Email Address : <span><?php echo $user_array[0]['email'];?></span></li>
                  <li><i class="fa fa-phone" aria-hidden="true"></i>Phone Number : <span><?php echo $user_array[0]['country_code'].$user_array[0]['phone'];?></span></li>
                </ul>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="dboard-col mHeight">
                <h6>Address :</h6>
                <p><?php echo $user_array[0]['address'];?></p>
                <div class="row">
                  <div class="col-md-5">
                    <h6>City :</h6>
                    <p><?php echo $user_array[0]['city'];?></p>
                  </div>
                  <div class="col-md-3">
                    <h6>State :</h6>
                    <p><?php echo $user_array[0]['state'];?></p>
                  </div>
                  <div class="col-md-4">
                    <h6>Zip Code :</h6>
                    <p><?php echo $user_array[0]['zip_code'];?></p>
                  </div>
                </div>
              </div>
            </div>
           </div>
           
           <div class="profile_edit">
           <form action="<?php echo Site_Url;?>profile.php" data-toggle="validator" role="form" class="clearfix" method="post"> 
            <div class="col-md-6 col-sm-6">
              <div class="dboard-col mHeight clearfix">
                
                  <div class="form-group"><label>Name :</label><input type="text" name="name" value="<?php echo $user_array[0]['name'];?>" class="form-control" required/></div>
                  <div class="form-group"><label>Company Name :</label> <span><input type="text" name="company_name" value="<?php echo $user_array[0]['company_name'];?>" class="form-control" required /></div>
                  <div class="form-group"><label>Email Address :</label> <span><input type="email" name="email" value="<?php echo $user_array[0]['email'];?>" class="form-control" data-error="Enter valid email address." required/>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group"><label>Country Code :</label> 
                  <?php
                  $str = file_get_contents('includes/phone_countrycode.json');
                  $json = json_decode($str, true);
                  ?>
                    <select name="country_code" id="country_code" class="form-control" required>
                      <option value="">Select Country Code</option>
                      <?php
                      foreach($json['countries'] as $code_with_country)
                      {
                        $code_value = str_replace(' ','',$code_with_country['code']);
                      ?>
                      <option value="<?php echo $code_value;?>" <?php if($user_array[0]['country_code']==$code_value){?> selected="selected" <?php }?>><?php echo $code_with_country['name']." (".$code_with_country['code'].")";?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group"><label>Phone Number :</label> <span><input type="number" name="phone" value="<?php echo $user_array[0]['phone'];?>" class="form-control" required /></div>
                  <div class="form-group">
                    <label>Password :</label>   
                    <input type="password" name="password" id="password" data-minlength="6" class="form-control" placeholder="Password" autocomplete="off">
                    <div class="help-block">Minimum of 6 characters</div>
                  </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="dboard-col mHeight clearfix">
                <div class="form-group"><label>Address :</label><textarea class="form-control" name="address" style="height:105px;"><?php echo $user_array[0]['address'];?></textarea></div>
                  
                <div class="form-group"><label>City :</label><span><input type="text" name="city" value="<?php echo $user_array[0]['city'];?>" class="form-control" /></div>
                  
                <div class="form-group"><label>State :</label><input type="text" name="state" value="<?php echo $user_array[0]['state'];?>" class="form-control" /></div>
                  
                <div class="form-group"><label>Zip Code :</label><input type="text" name="zip_code" value="<?php echo $user_array[0]['zip_code'];?>" class="form-control" /></div>
                  
                <div class="form-group">
                    <label>Retype Password :</label>  
                    <input type="password" name="retype_password" id="retype_password" class="form-control" placeholder="Re-enter Password" autocomplete="off" data-match="#password" data-match-error="Passwords do not match">
                    <div class="help-block with-errors"></div>
                </div>
               
              </div>
            </div>  
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input class="btn style2" type="submit" name="submit" value="Save">
              <input class="btn style2 show_profile" type="button" value="Cancel" style="background-color:#1596ed;float: right; margin-right: 10px; color: #fff;">  
             </div>
            </form>         
           </div> 
           
            <div class="col-md-12">
              <a class="sync-btn pull-right edit_pro" href="javascript:void(0);">Edit Profile</a>
            </div>
          </div>

          <?php
          $order_status_array = array('0'=>'Unconfirmed', '1'=>'Confirmed', '2'=>'Processing', '3'=>'Shipped');
          ?>

          <div class="title-wrap other">
            <h2 class="secTitle">Current Order</h2>
          </div>
          <div id="order-table" class="divTable">
           <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead>
            <tr class="hidden-xs">
              <td>Order Date</td>
              <td>Products Name</td>
              <td>Quantity</td>
              <td>Price</td>
              <td>Delivery Date</td>
              <td>Transaction Id</td>
              <td>Shipping Address</td>
              <td>Status</td>
            </tr>
            <?php
            $order_array = $order_module->order_display($db->tbl_pre . "order_tbl", array(), "WHERE user_id='".$user_id."' and order_status!='3'","","date desc");  //3=> Shipped
            foreach($order_array as $single_order)
            {
              $product_array = $product_module->product_display($db->tbl_pre . "product_tbl", array(), "WHERE id='".$single_order['product_id']."'");
              ?>
              </thead>
              <tbody>
              <tr class="">
                <td data-title="Order Date"><?php echo date("d/m/Y",strtotime($single_order['date']));?></td>
                <td data-title="Products Name"><?php echo $product_array[0]['product_name'];?></td>
                <td data-title="Quantity"><?php echo $single_order['quantity'];?></td>
                <td data-title="Price">$<?php echo $single_order['total_price'];?></td>
                <td data-title="Delivery Date"><?php echo date("d/m/Y",strtotime($single_order['shipping_date']));?></td>
                <td data-title="Transaction Id">
                  <?php echo $single_order['transaction_id'];?>
                </td>
                <td data-title="Shipping Address">
                  <p><b>Name</b>: <?php echo $single_order['shipping_name'];?></p>
                  <p><b>Company Name</b>: <?php echo $single_order['shipping_company_name'];?></p>
                  <p><b>Address</b>: <?php echo $single_order['shipping_address_line1'];?> <?php echo $single_order['shipping_address_line2'];?> <?php echo $single_order['shipping_address_line3'];?></p>
                  <p><b>City</b>: <?php echo $single_order['shipping_city'];?></p>
                  <p><b>State</b>: <?php echo $single_order['shipping_state'];?></p>
                  <p><b>Zip Code</b>: <?php echo $single_order['shipping_zip_code'];?></p>
                </td>
                <td data-title="Status"><?php echo $order_status_array[$single_order['order_status']];?></td>
              </tr>
              </tbody>
              <?php
            }
            ?>
            </table>
          </div>
          <div class="title-wrap other">
            <h2 class="secTitle">Past Orders</h2>
          </div>
          <div id="past-order-table" class="divTable">

            <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <thead>
            <tr class="hidden-xs">
              <td>Order Date</td>
              <td>Products Name</td>
              <td>Quantity</td>
              <td>Price</td>
              <td>Delivery Date</td>
              <td>Transaction Id</td>
              <td>Shipping Address</td>
              <td>Status</td>
            </tr>
            <?php
            $past_order_array = $order_module->order_display($db->tbl_pre . "order_tbl", array(), "WHERE user_id='".$user_id."' and order_status='3'","","date desc");  //3=> Shipped
            foreach($past_order_array as $single_order)
            {
              $product_array = $product_module->product_display($db->tbl_pre . "product_tbl", array(), "WHERE id='".$single_order['product_id']."'");
              ?>
              </thead>
              <tbody>
              <tr class="">
                <td data-title="Order Date"><?php echo date("d/m/Y",strtotime($single_order['date']));?></td>
                <td data-title="Products Name"><?php echo $product_array[0]['product_name'];?></td>
                <td data-title="Quantity"><?php echo $single_order['quantity'];?></td>
                <td data-title="Price">$<?php echo $single_order['total_price'];?></td>
                <td data-title="Delivery Date"><?php echo date("d/m/Y",strtotime($single_order['shipping_date']));?></td>
                <td data-title="Transaction Id">
                  <?php echo $single_order['transaction_id'];?>
                </td>
                <td data-title="Shipping Address">
                  <p><b>Name</b>: <?php echo $single_order['shipping_name'];?></p>
                  <p><b>Company Name</b>: <?php echo $single_order['shipping_company_name'];?></p>
                  <p><b>Address</b>: <?php echo $single_order['shipping_address_line1'];?> <?php echo $single_order['shipping_address_line2'];?> <?php echo $single_order['shipping_address_line3'];?></p>
                  <p><b>City</b>: <?php echo $single_order['shipping_city'];?></p>
                  <p><b>State</b>: <?php echo $single_order['shipping_state'];?></p>
                  <p><b>Zip Code</b>: <?php echo $single_order['shipping_zip_code'];?></p>
                </td>
                <td data-title="Status"><?php echo $order_status_array[$single_order['order_status']];?></td>
              </tr>
              </tbody>
              <?php
            }
            ?>
            </table>

          </div>
        </div>
      </div>

<?php
include("footer.php");
?>

<script>
jQuery('.edit_pro').click( function() {
	jQuery(this).hide();
	jQuery('.profile_details').hide();
	jQuery('.profile_edit').fadeIn();	
});

jQuery('.show_profile').click( function() {
	jQuery('.profile_edit').hide();
	jQuery('.edit_pro').show();
	jQuery('.profile_details').fadeIn();
});

</script>