<footer>
        <div class="footer-menu">
          <div class="container">          
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">Contact</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Event Quote</a></li>
              <li><a href="#">LED Wristbands</a></li>
            </ul>
          </div>
        </div>
      </footer>

      <div class="footer-end">
        <div class="conrainer">
          <div class="social">
            <ul>
              <li><a href="https://www.facebook.com/crowdsynctechnology" target="_blank"><img src="images/f_fb.png"></a></li>
              <li><a href="http://twitter.com/crowdsyncled" target="_blank"><img src="images/f_tweet.png"></a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Login Modal -->
      <div id="loginModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
              <h2 class="modal-title">Login</h2>
            </div>
            <div class="modal-body">
              <div id="login_result"></div>
              <form id="user_login" data-toggle="validator" role="form" class="clearfix">
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $_COOKIE['user_email'];?>" autocomplete="off" data-error="Enter valid email address." required>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo $_COOKIE['user_pass'];?>" autocomplete="off" required>
              </div>
              <div class="form-group remember">
                <label><input type="checkbox" id="remember_me" name="remember_me" class="form-control" value="1" <?php if($_COOKIE['user_remember']=='1'){?> checked="checked" <?php }?>> Remember me</label>
                <a class="f-p pull-right" href="#" data-dismiss="modal" data-toggle="modal" data-target="#forgotPasswordModal">Forgot Password?</a>
              </div>
              <input class="btn style2" type="submit" value="login">
            </form>
            <div class="plz_reg clearfix">
              <p class="reg-txt">Don’t have an account? <br /><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#registerModal">Register</a></p>
             </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Forgot Password Modal -->
      <div id="forgotPasswordModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
              <h2 class="modal-title">Forgot Password</h2>
            </div>
            <div class="modal-body">
            <div id="forgot_password_result"></div>
            <form id="user_forgot_password" data-toggle="validator" role="form">
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off" data-error="Enter valid email address." required>
                <div class="help-block with-errors"></div>
              </div>
              <input class="btn style2" type="submit" value="Submit">
            </form>
            <p class="reg-txt">Back to <a href="#loginModal" data-dismiss="modal" data-toggle="modal" >Login</a></p>
            </div>
          </div>

        </div>
      </div>

      <!-- Register Modal -->
      <div id="registerModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
              <h2 class="modal-title">Register</h2>
            </div>
            <div class="modal-body">
              <!--<input type="text" placeholder="Name">
              <input type="email" placeholder="Email">
              <input type="password" placeholder="Password">
              <input type="text" placeholder="Re-enter Password">
              <input type="text" placeholder="Phone No.">-->
              <form id="user_registration" data-toggle="validator" role="form">
              <div class="form-group">
                <input type="text" name="name" id="name" class="form-control" placeholder="Name" autocomplete="off" required>
              </div>
              <div class="form-group">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" autocomplete="off" data-error="Enter valid email address." required>
                <div class="help-block with-errors"></div>
              </div>
              <div class="form-group">  
                <input type="password" name="password" id="password" data-minlength="6" class="form-control" placeholder="Password" autocomplete="off" required>
                <div class="help-block">Minimum of 6 characters</div>
              </div>
              <div class="form-group">  
                <input type="password" name="retype_password" id="retype_password" class="form-control" placeholder="Re-enter Password" autocomplete="off" data-match="#password" data-match-error="Passwords do not match" required>
                <div class="help-block with-errors"></div>
              </div>

              <div class="form-group">  
              <?php
              $str = file_get_contents('includes/phone_countrycode.json');
              $json = json_decode($str, true);
              ?>
                <select name="country_code" id="country_code" class="form-control" required>
                  <option value="">Select Country Code</option>
                  <?php
                  foreach($json['countries'] as $code_with_country)
                  {
                  ?>
                  <option value="<?php echo str_replace(' ','',$code_with_country['code']);?>"><?php echo $code_with_country['name']." (".$code_with_country['code'].")";?></option>
                  <?php
                  }
                  ?>
                </select>
              </div> 

              <div class="form-group num_box">
                <input type="number" name="phone" id="phone" class="form-control" placeholder="Phone No. without country code" autocomplete="off" data-error="Enter valid phone number." required>
                <div class="help-block with-errors"></div>
              </div>
              
              <div class="form-group"> 
                <img src="phpcaptcha/captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br>
                Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.<br>
                <input id="captcha_code" name="captcha_code" placeholder="Enter the code above here" type="text" required>
              </div>

              <input class="btn style2" type="submit" value="Register">
              </form>
              <p class="reg-txt">Already have an account? <a href="#loginModal" data-dismiss="modal" data-toggle="modal" >Login</a></p>
              <div id="register_result"></div>
            </div>
          </div>

        </div>
      </div>
      
      
      <!-- product details popup -->
      <div id="productdetails" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">              
              <h3 class="modal-title">CONTROLLABLE LED WRISTBANDS</h3>
            </div>
            <div class="modal-body">
              <div class="pro_images clearfix">
               <img class="product_image" src="<?php echo Site_Url;?>images/1-Day-Controllable.png" alt="" />
              </div>
              <div class="specifications clearfix">
                <h4 class="product_name"></h4>
                <div class="product_description">
                  
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Alert and Message Modal -->
      <div id="alertMessageModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
            
            </div>
          </div>

        </div>
      </div>
      
      <div id="loading"><span>Loading...</span></div>
      
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="<?php echo Site_Url;?>js/jquery-1.11.3.min.js" type="text/javascript"></script>
      <script src="<?php echo Site_Url;?>js/jquery-ui.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script type="text/javascript" src="<?php echo Site_Url;?>js/bootstrap.min.js" ></script>
      <script type="text/javascript" src="<?php echo Site_Url;?>js/jasny-bootstrap.min.js" ></script>
      <script type="text/javascript" src="<?php echo Site_Url;?>js/bootstrap-datepicker.min.js" ></script>
      <script type="text/javascript" src="<?php echo Site_Url;?>js/jquery.matchHeight-min.js" ></script>
      <script type="text/javascript" src="<?php echo Site_Url;?>js/rangeslider.js" ></script>
      <script type="text/javascript" src="<?php echo Site_Url;?>js/custom-wizard.js"></script>
      <script type="text/javascript" src="<?php echo Site_Url;?>js/validator.js"></script>
      <script type="text/javascript" src="<?php echo Site_Url;?>js/bootbox.min.js"></script>
      
      <script type="text/javascript" src="<?php echo Site_Url;?>js/dncalendar.js"></script>
      <script>
      $(document).ready(function() {
			var my_calendar = $("#dncalendar-container").dnCalendar({
				minDate: "<?php echo date('Y-m-d',strtotime('+14 days'));?>",
				//maxDate: "2016-12-02",
				defaultDate: "2017-03-02",				
                dataTitles: { defaultDate: 'default', today : '' },
                notes: [
                		//{ "date": "2016-05-25", "note": [""] },
                		//{ "date": "2016-05-12", "note": [""] }
                		],
               // showNotes: true,                
				dayUseShortName: true,
	            monthUseShortName: true,
				startWeek: 'sunday',
                dayClick: function(date, view) {
                  var month = (date.getMonth() + 1);
                	var shipping_date = date.getFullYear() + "-" + (month < 10 ? '0'+month : month) + "-" + date.getDate() ;
                  $("#shipping_date").val(shipping_date);
				  $('#dncalendar-body td').removeClass('active_date');
				  $(this).addClass('active_date');
                }
			});

			// init calendar
			my_calendar.build();

			// update calendar
			// my_calendar.update({
			// 	minDate: "2016-01-05",
			// 	defaultDate: "2016-05-04"
			// });
		});
		
		
		</script>

      <?php
      if(@$_SESSION['user_msg']!="")
      {
      
      echo "<script>".
      
        "$('#alertMessageModal .modal-body').html(\"".$_SESSION['user_msg']."\");".
        "$('#alertMessageModal').modal('show');".
        
      "</script>";
      
      $_SESSION['user_msg']="";
      }
      ?>
      
      <script type="text/javascript" src="<?php echo Site_Url;?>js/main.js"></script>
      <script type="text/javascript">
      function refreshCaptcha(){
        var img = document.images['captchaimg'];
        img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
      }
      </script>
    </body>
    </html>