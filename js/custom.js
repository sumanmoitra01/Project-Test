$(document).ready(function(){

	/*For User Registration*/
	jQuery('#user_registration').validator().on('submit', function (e) {
	  if (e.isDefaultPrevented()) {
	    // handle the invalid form...
	  } else {
	    data = jQuery( this ).serializeArray();
		jQuery.ajax({
			type : 'post',
			url : 'user_registration.php',
			data : data,
			dataType : 'json',
			beforeSend : function(){
				jQuery("#loading").show();
				jQuery("#user_registration input[name='submit']").attr('disabled','disabled');
			},
			success : function(result){
				jQuery("#user_registration input[name='submit']").removeAttr('disabled');
				jQuery("#loading").hide();
				jQuery("#register_result").html(result.message);
				if(result.type==1)
				{
					jQuery("#register_result").html('');
					jQuery('#user_registration').trigger('reset');

					//jQuery('#registerModal').modal('hide');
					jQuery('body').removeClass('scroll_stop');
		            jQuery('html').removeClass('scroll_stop');
		            jQuery('.popup_bg').fadeOut();

					jQuery('#alertMessageModal .modal-body').html(result.message);
        			jQuery('#alertMessageModal').modal('show');
				}
			}
		});
	  	return false;
	  }
	});

	/*For User Login*/
	jQuery('#user_login').validator().on('submit', function (e) {
	  if (e.isDefaultPrevented()) {
	    // handle the invalid form...
	  } else {
	    data = jQuery( this ).serializeArray();
	    var redirect_url = jQuery("#redirect_url").val();
		jQuery.ajax({
			type : 'post',
			url : 'user_login.php',
			data : data,
			dataType : 'json',
			beforeSend : function(){
				jQuery("#loading").show();
				jQuery("#user_login input[name='submit']").attr('disabled','disabled');
			},
			success : function(result){
				jQuery("#user_login input[name='submit']").removeAttr('disabled');
				jQuery("#loading").hide();
				jQuery("#login_result").html(result.message);
				jQuery('#user_login').trigger('reset');
				if(result.type==1)
				{
					if(redirect_url)
					{
						window.location.href=redirect_url;
					}
					else
					{
						window.location.href='influencer-search.php';
					}
				}
			}
		});
	  	return false;
	  }
	});


	/*For Forgot Password*/
	jQuery('#user_forgot_password').validator().on('submit', function (e) {
	  if (e.isDefaultPrevented()) {
	    // handle the invalid form...
	  } else {
	    data = jQuery( this ).serializeArray();
		jQuery.ajax({
			type : 'post',
			url : 'user_forgot_password.php',
			data : data,
			dataType : 'json',
			beforeSend : function(){
				jQuery("#loading").show();
				jQuery("#user_forgot_password input[name='submit']").attr('disabled','disabled');
			},
			success : function(result){
				jQuery("#user_forgot_password input[name='submit']").removeAttr('disabled');
				jQuery("#loading").hide();
				jQuery("#forgot_password_result").html(result.message);
				if(result.type==1)
				{
					jQuery('#user_forgot_password').trigger('reset');
				}
			}
		});
	  	return false;
	  }
	});


	/*For Review Submit*/
	jQuery('#review_modal').validator().on('submit', function (e) {
	  if (e.isDefaultPrevented()) {
	    // handle the invalid form...
	  } else {
	    data = jQuery( this ).serializeArray();
		jQuery.ajax({
			type : 'post',
			url : 'review_submit.php',
			data : data,
			beforeSend : function(){
				jQuery("#loading").show();
			},
			success : function(result){
				window.location.href='contracts.php';
			}
		});
	  	return false;
	  }
	});

	/*For User Registration*/
	jQuery('#contact_form').validator().on('submit', function (e) {
	  if (e.isDefaultPrevented()) {
	    // handle the invalid form...
	  } else {
	    data = jQuery( this ).serializeArray();
		jQuery.ajax({
			type : 'post',
			url : 'contact_form_submit.php',
			data : data,
			dataType : 'json',
			beforeSend : function(){
				jQuery("#loading").show();
				jQuery("#contact_form input[name='submit']").attr('disabled','disabled');
			},
			success : function(result){
				jQuery("#contact_form input[name='submit']").removeAttr('disabled');
				jQuery("#loading").hide();
				jQuery("#contact_form_result").html(result.message);
				if(result.type==1)
				{
					jQuery('#contact_form').trigger('reset');
				}
			}
		});
	  	return false;
	  }
	});

});

function review_call(id)
{
	$("#review_contract_id").val(id);
}