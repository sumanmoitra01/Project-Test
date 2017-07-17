<?php
include("header.php");

if(!$_SESSION['total_price'])
{
    echo "<script>window.location.href='".Site_Url."'</script>";
}

require('stripe-php-4.4.0/config.inc.php');
?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<?php
// Set the Stripe key:
// Uses STRIPE_PUBLIC_KEY from the config file.
echo '<script type="text/javascript">Stripe.setPublishableKey("' . STRIPE_PUBLIC_KEY . '");</script>';
?>
      <!-- header Ends -->

    <div class="inner-content other">
        <div class="container">

            <div class="payment-switch-field">
                <h3>Payable amount: <span>$<?php echo $_SESSION['total_price'];?> USD</span></h4>                
            </div>  
            <div class="row">
                <div class="col-sm-offset-3 col-sm-6">  
                <form id="payment-form" data-toggle="validator" role="form">

                    <div id="payment-errors"></div>

                    <span class="help-block">You can pay using: Mastercard, Visa, American Express, JCB, Discover, and Diners Club.</span>
                    <div class="form-group">
                        <label class="control-label">Card Number</label>
                        <input type="text" maxlength="16" autocomplete="off" class="form-control card-number input-medium" required>
                        <div class="help-block">Enter the number without spaces or hyphens.</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">CVC</label>
                        <input type="text" maxlength="4" autocomplete="off" class="form-control card-cvc input-mini" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Expiration (MM/YYYY)</label>
                        <input type="text" maxlength="2" class="form-control card-expiry-month input-mini" required>
                        <span> / </span>
                        <input type="text" maxlength="4" class="form-control card-expiry-year input-mini" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn style2" id="submitBtn">Submit Payment</button>
                    </div>

                </form>
                </div> 
            </div>  
        </div>
    </div>

<!-- footer Starts -->
<?php include("footer.php");?>

<script src="<?php echo Site_Url;?>stripe-php-4.4.0/buy.js"></script>