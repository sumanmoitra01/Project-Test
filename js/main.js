$(document).ready(function(){
var quantitywise_price_range = "";
	// Menu toggle
	$(".navbar-toggle").on("click", function () {
		$(this).toggleClass("active");
	});

	function myFunction() {
	    if ($( window ).width() > 1024) {
	            $("#navbar-collapse-1").find('#navbar-collapse-1 > ul').show();			         
	    }
	    else
	    {        
				
	    }
	}

	//initialize
	myFunction();

	//call when the page resizes.
	$(window).resize(function() {
	    myFunction();
	});

	//for lvl 1 subnav
	$(".main-menu ul.menu > li > ul").parent().prepend('<div class="menu-button">' + '<span>' + '</span>' + '</div>');
	
	$(".main-menu ul.menu > li > .menu-button").click( function(){
		$(this).parent("li").toggleClass('selected');				
		$(this).parent("li").find("ul:first").slideToggle();
	});

	$('.item-col').click(function(){
	  $('.item-col').removeClass('active');
	  $(this).addClass('active');
	});	
  
  // Datepicker  ///////////////////////////////////////////
  $('.date-picker').datepicker({
    startDate: '+13d',
  });

  // On image upload show image///////////////////////////////
  function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#art_img').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });
    $(".remove_img").click(function(){
      $("#art_img").attr("src","images/artwork_img.png")
    });

    $(".draggable").draggable();

  // Range slider ///////////////////////////////
  $('input[type="range"]').rangeslider({
    polyfill: false,
    rangeClass: 'rangeslider',
    fillClass: 'rangeslider__fill',
    handleClass: 'rangeslider__handle',

    // Callback function
    onInit: function() {},

    // Callback function
    onSlide: function(position, value) {0},

    // Callback function
    onSlideEnd: function(position, value) {}
});


  $("input[type='range'],#range_val").bind('load change keyup', function(e) {
    //console.log(quantitywise_price_range);
    //var quantity = $(this).val();
    var quantity = $("#range_val").val();
    var price = 0;
    $.each( quantitywise_price_range, function( key, value ) {
      if(parseInt(quantity) >= parseInt(value.quantity_from) && parseInt(quantity) <= parseInt(value.quantity_to))
      {
        //console.log(value.quantity_from+"  "+value.quantity_to);
        price = value.price;
        $("#cost_per_wristband").val(price);
        var total_cost = (price*quantity).toFixed(2);
        $("#total_cost").val("$"+total_cost);
        $("#total_amount").val(total_cost);
      }
    });
  });


  // Equal height
  if (jQuery(".mHeight").length > 0) {
    jQuery(".mHeight").matchHeight();
  }


  $(".item-col").click(function(){
    console.log($(this).data('id'));
    var product_id = $(this).data('id');
    $.ajax({
      type : 'post',
      url : 'ajax/product_data_load.php',
      data : {'product_id' : product_id},
      dataType : 'json',
      beforeSend : function()
      {
        //console.log("beforeSend");
      },
      success : function(result)
      {
        //console.log(result);
        $("#step-2 #product_id").val(result.product_id);
        if(result.product_image2)
        {
          $("#step-2 .product-img img").attr('src', result.product_image2);
        }
        $("#step-2 #product_name").html(result.product_name);
        $("#product_price_range").html('');

        quantitywise_price_range = result.price_range;

        var quantity = $("#range_val").val();
        var price = 0;

        $.each( result.price_range, function( key, value ) {
          $("#product_price_range").append('<li><span>'+value.quantity_from+' - '+value.quantity_to+' Wristbands:</span> $'+value.price+' ea</li>');
          //console.log( key + ": " + value.price );

          if(parseInt(quantity) >= parseInt(value.quantity_from) && parseInt(quantity) <= parseInt(value.quantity_to))
          {
            //console.log(value.quantity_from+"  "+value.quantity_to);
            price = value.price;
            $("#cost_per_wristband").val(price);
            var total_cost = (price*quantity).toFixed(2);
            $("#total_cost").val("$"+total_cost);
            $("#total_amount").val(total_cost);
          }

        });

        $("#productdetails .product_name").html(result.product_name);
        if(result.product_image1)
        {
          $("#productdetails .product_image").attr('src', result.product_image1);
        }
        $("#productdetails .product_description").html(result.product_description);

      }
    });
  });


/*For User Registration*/
  jQuery('#user_registration').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
      // handle the invalid form...
    } else {
      data = jQuery( this ).serializeArray();
    jQuery.ajax({
      type : 'post',
      url : 'ajax/user_registration.php',
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
      url : 'ajax/user_login.php',
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
            window.location.href='index.php';
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
      url : 'ajax/user_forgot_password.php',
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




  //Slimscroll
   /* jQuery("#past-order-table > .divBody").mCustomScrollbar({
      theme:"light-thick",
      scrollbarPosition:"inside"
    });*/

  // td equal height
  // var eq_el_height = function(els, min_or_max) {

  //   els.each(function() {
  //       $(this).height('auto');
  //   });

  //   var m = $(els[0]).height();

  //   els.each(function() {
  //       var h = $(this).height();

  //       if (min_or_max === "max") {
  //           m = h > m ? h : m;
  //       } else {
  //           m = h < m ? h : m;
  //       }
  //   });

  //   els.each(function() {
  //       $(this).height(m);
  //   });
  // };

  // $('.headRow, .divRow').each(function(){
  //     eq_el_height($(this).find('.divCell'), "max");
  // });

// $('#past-order-table tr').each(function(){
//       eq_el_height($(this).find('td'), "max");
//   });

});