<?php
include("header.php");

$body = '<tr>
                          <td colspan="4" style="padding: 30px 21px 0">
                              <h3 style="font-size:30px;font-weight:700;color:#1596ed;margin:10px 0;">Dear S Nag,</h3>
                              <p style="font-size:16px;font-weight:400;">Your account has been successfully created as User.</p>
                    <p style="font-size:15px;font-weight:400;">Please <a href="">click here</a> to verify your email or directly open the below link.</p>
                    <p style="font-size:15px;font-weight:400;">email verification link</p>
                    <p style="font-size:15px;font-weight:400;">Login details has been given below.</p>
                    <p style="font-size:15px;font-weight:400;">Website Url: '.Site_Url.'</p>
                    <p style="font-size:15px;font-weight:400;">Username: eee</p>
                    <p style="font-size:15px;font-weight:400;">Password: eee</p>
                    <p style="font-size:15px;font-weight:400;"><br><br>Thank you,<br>'.Site_Title.' Team</p>
                          </td>
                      </tr>';

echo get_email_layout($body);
?>


      <!-- header Ends -->

      <div class="inner-content">
        <div class="container">  
          <div class="stepwizard">
              <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                  <a href="#step-1" class="active">
                  <p>1</p>
                  <p class="title">CHOOSE YOUR<br>WRISTBAND</p>
                  </a>
                </div>
                <div class="stepwizard-step">
                  <a href="#step-2" class="" disabled="disabled">
                  <p>2</p>
                  <p class="title">SELECT YOUR<br>QUANTITY</p></a>                  
                </div>
                <div class="stepwizard-step">
                  <a href="#step-3" class="" disabled="disabled">
                  <p>3</p>
                  <p class="title">SELECT DATE<br>AND SHIPPING</p></a>                  
                </div>
                <div class="stepwizard-step">
                  <a href="#step-4" class="" disabled="disabled">
                  <p>4</p>
                  <p class="title">PURCHASE YOUR<br>WRISTBANDS</p></a>                 
                </div>
              </div>
            </div>
            
            <form role="form" class="stepwizard-form" id="oreder_form" action="payment.php" method="post">
              <div class="row setup-content" id="step-1">
                <div class="col-md-12">
                  <div class="wiz-con">
                    
                    <?php
                    $i=1;
                    $product_array = $product_module->product_display($db->tbl_pre . "product_tbl", array(), "WHERE status='1'");
                    foreach($product_array as $single_product)
                    {
                      if($i%4==1)
                      {
                        echo '<div class="row">';
                      }
                    ?>
                      <div class="col-md-3 col-sm-6">
                        <div class="item-col" data-id="<?php echo $single_product['id'];?>">
                          <span>
                            <?php echo $single_product['product_svg'];?>
                          </span>
                          <h3><?php echo $single_product['product_name'];?></h3>
                          <?php echo autop($single_product['product_description']);?>
                        </div>
                      </div>
                      <?php
                      if($i%4==0 || count($product_array)==$i)
                      {
                        echo "</div>";
                      }

                      $i++;
                    }
                    ?>
                      
                  </div>
                  <div class="stepBtn"><button class="nextBtn" type="button" >CONTINUE TO SELECT QUANTITY</button></div>
                  
                </div>
              </div>
              <div class="row setup-content" id="step-2">
                <div class="col-md-12">
                  <div class="wiz-con step-2">
                    <div class="row">
                      <div class="col-md-4 col-sm-5">
                        <div class="product-img">
                          <input type="hidden" name="product_id" id="product_id" value="" />
                          <span><img src="<?php echo Site_Url;?>images/p_img.png"></span>
                          <p id="product_name"></p>
                        </div>
                      </div>
                      <div class="col-md-8 col-sm-7">
                        <div class="row">
                          <div class="col-md-5">
                            <h3 class="t-label">ENTER QUANTITY:</h3>
                            <input oninput="amount.value=rangeInput.value" id="slider" type="range" value="1" min="1" max="10000"  name="rangeInput" />
                            <input id="range_val" class="form-control sm" type="number" value="1" name="amount" for="rangeInput" oninput="rangeInput.value=amount.value" min="1" max="10000" />
                          </div>
                          <div class="col-md-7">                            
                            <div class="pricing-list">
                              <h3 class="t-label right">QUANTITY PRICING:</h3>
                              <ul id="product_price_range">
                              </ul>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="amount-wrap">
                              <div class="row">
                                <div class="col-md-8 col-sm-12">
                                  <h3 class="t-label">COST PER WRISTBAND:</h3>
                                  <input id="cost_per_wristband" class="form-control white sm" type="text" value="$0" name="" disabled="" />
                                  <a class="sync-btn right" href="#" data-toggle="modal" data-target="#productdetails">WRISTBAND INFO</a>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                  <h3 class="t-label right">TOTAL COST:</h3>
                                  <input id="total_cost" class="form-control sm right" type="text" value="$0" name="" disabled="" />
                                  <input name="total_cost" id="total_amount" type="hidden" value="0"/>
                                </div>
                              </div>
                            </div>                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>                  
                  <div class="stepBtn"><button class="nextBtn" type="button" >CONTINUE TO EVENT DATE // SHIPPING</button></div>
                </div>
              </div>
              <div class="row setup-content" id="step-3">
                <div class="col-md-12">
                  <div class="wiz-con step-3">
                    <div class="row">
                      <div class="col-md-7 col-sm-7">
                        <div class="shipping-form">
                          <h3 class="t-label">ENTER SHIPPING ADDRESS:</h3>

                          <?php
                          if($_SESSION['user_login']=='success'){?> <input type="checkbox" id="same_as_billing" value="1" /> Same as billing address<?php }?>

                          <div class="form-group">
                            <input class="form-control" type="text" name="shipping_name" placeholder="Full Name" required>
                          </div>
                          <div class="form-group">
                            <input class="form-control" type="text" name="shipping_company_name" placeholder="Company Name" required>
                          </div>
                          <div class="form-group">
                            <input class="form-control" type="text" name="shipping_address_line1" placeholder="Address Line 1" required>
                          </div>
                          <div class="form-group">
                            <input class="form-control" type="text" name="shipping_address_line2" placeholder="Address Line 2">
                          </div>
                          <div class="form-group">
                            <input class="form-control" type="text" name="shipping_address_line3" placeholder="Address Line 3">
                          </div>
                          <div class="form-group grp">
                            <div class="frm-holder lg">
                              <input class="form-control" type="text" name="shipping_city" placeholder="City">
                            </div>
                            <div class="frm-holder">
                              <input class="form-control" type="text" name="shipping_state" placeholder="State">
                            </div>
                            <div class="frm-holder">
                              <input class="form-control" type="text" name="shipping_zip_code" placeholder="Zip Code">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-5 col-sm-5">
                        <div class="ship-cal">
                          <h3 class="t-label right">SELECT DATES:</h3>
                          <!--<div id="" class="date-picker" data-date-format="mm/dd/yyyy"> </div>-->
                          
                          <div id="dncalendar-container"></div>
                          <input type="hidden" name="shipping_date" id="shipping_date">
                        </div>                        
                      </div>
                    </div>
                    <p class="help-txt">* A minimum 2 week lead time is needed to successfully process all orders. If you need a rush order, please call us at: (631) 838-6087 *</p>
                  </div>
                  <div class="stepBtn"><button class="nextBtn" type="button">CONTINUE TO UPLOAD ARTWORK</button></div>
                </div>
              </div>
              <div class="row setup-content" id="step-4">
                <div class="col-md-12">
                  <div class="wiz-con step-4">
                    <div class="row">
                      <div class="col-sm-6">
                        <h3 class="t-label">UPLOAD ARTWORK:</h3>
                        <p class="help-txt">To ensure accuracy, please upload your artwork as a .PDF with all layers embeded, a transparent background, and any fonts outlined. File must be provided with dimensions of 450px by 100px. To see a rendering of your logo, please also upload a transparent PNG of your artwork, with the same dimensions of 450px by 100px:</p>
                        <div class="form-group">
                          <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename">Upload PDF here:</span></div>
                            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new"><img src="<?php echo Site_Url;?>images/upload_icon.png"></span><span class="fileinput-exists"><img src="<?php echo Site_Url;?>images/change_icon.png"></span><input type="file" name="artwork_file_path" id="artwork_file"></span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                          </div>
                          <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename">Upload PNG mockup here:</span></div>
                            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new"><img src="<?php echo Site_Url;?>images/upload_icon.png"></span><span class="fileinput-exists"><img src="<?php echo Site_Url;?>images/change_icon.png"></span><input id="imgInp" type="file" name="..."></span>
                            <a href="#" class="input-group-addon btn btn-default fileinput-exists remove_img" data-dismiss="fileinput"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                          </div>
                          <textarea class="form-control area" name="comments" placeholder="Comments:"></textarea>
                        </div>
                      </div>
                      <div class="col-sm-6">                        
                        <div class="order-dtls">
                          <h3 class="t-label right">ORDER DETAILS:</h3>
                          <span class="p-small"><img src="<?php echo Site_Url;?>images/p_small_img.png"></span>
                          <p id="order_details"><span>Item:</span> <br>
                          <span>Quantity:</span> <br>
                          <span>Dates:</span> <br>
                          <span>Total Cost:</span> </p>
                        </div>
                        <div class="artwork-box">
                          <span>
                            <img id="art_img" class="draggable" src="<?php echo Site_Url;?>images/artwork_img.png" alt="" width="100" height="78">                          
                          </span>
                          <img src="<?php echo Site_Url;?>images/product_img.png" alt="">
                        </div>                        
                      </div>
                    </div>
                  </div>
                  <div class="stepBtn"><button class="" type="submit">COMPLETE PURCHASE ORDER</button></div>
                </div>
              </div>
            </form>  
          </div>

      </div>

      <!-- footer Starts -->
      <?php include("footer.php");?>
	  
  <script type="text/javascript">
    $("#same_as_billing").click( function() {
      if($(this).is(":checked"))
      {
        $(".shipping-form input[name='shipping_name']").val("<?php echo $user_array1[0]['name'];?>");
        $(".shipping-form input[name='shipping_company_name']").val("<?php echo $user_array1[0]['company_name'];?>");
        $(".shipping-form input[name='shipping_address_line1']").val("<?php echo $user_array1[0]['address'];?>");
        $(".shipping-form input[name='shipping_city']").val("<?php echo $user_array1[0]['city'];?>");
        $(".shipping-form input[name='shipping_state']").val("<?php echo $user_array1[0]['state'];?>");
        $(".shipping-form input[name='shipping_zip_code']").val("<?php echo $user_array1[0]['zip_code'];?>");
      }
      else
      {
        $(".shipping-form input[type='text']").val("");
      }
    });

    $("#oreder_form").submit(function(){
      var filename = $('#artwork_file').val().replace(/.*(\/|\\)/, '').split(".");
      filename.reverse();
      //console.log(filename);
      if($.inArray(filename[0].toLowerCase(), ['pdf'])==-1 ||  $('#artwork_file').val()=="")
      {
        bootbox.alert("Please upload valid pdf file.");
        return false
      }
    })

  </script>
      
      