$(document).ready(function(){
  var navListItems = $('div.stepwizard-step > a'),
          allWells = $('.setup-content'),
          allNextBtn = $('.nextBtn');

  allWells.hide();

  navListItems.click(function (e) {
      e.preventDefault();
      var $target = $($(this).attr('href')),
              $item = $(this);

              //console.log($item.attr('disabled'));

      if (!$item.attr('disabled')) {
          navListItems.removeClass('active');
          $item.addClass('active');
          allWells.hide();
          $target.show();
          $target.find('input:eq(0)').focus();
      }

      /*console.log($item.parent().index());
      console.log($('.stepwizard-step').length);*/

      for(var i = $item.parent().index(); i <= $('.stepwizard-step').length; i++)
      {
        $('.stepwizard-step:eq('+(parseInt(i)+1)+') > a').attr('disabled','disabled');
      }

  });

  allNextBtn.click(function(){
      var curStep = $(this).closest(".setup-content"),
          curStepBtn = curStep.attr("id"),
          nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
          curInputs = curStep.find("input[type='text'],input[type='url']"),
          isValid = false;

          if($(".item-col").hasClass('active'))
          {
            isValid = true;
          }
          else
          {
            //alert("Please select any product.");
            bootbox.alert("Please select any product.");
          }

          if(curStepBtn=='step-2' && (parseInt($("#range_val").val())<1) || !$("#range_val").val())
          {
            isValid = false;
            bootbox.alert("Quantity can not be less than 1.");
          }
          else if(curStepBtn=='step-2' && $("#isLogin").val()==0)
          {
             console.log($("#range_val").val());
            isValid = false;
            $('#loginModal').modal('show');
          }

          if(curStepBtn=='step-3' && $("#shipping_date").val()=="")
          {
            isValid = false;
            bootbox.alert("Please select date.");
          }

          if(curStepBtn=='step-3')
          {
            var order_details = '<span>Item:</span> '+$("#product_name").html()+'<br>'+
                          '<span>Quantity:</span> '+$("#range_val").val()+'<br>'+
                          '<span>Dates:</span> '+$("#shipping_date").val()+'<br>'+
                          '<span>Total Cost:</span> $'+$("#total_amount").val();
            $("#order_details").html(order_details);
          }

      $(".form-group").removeClass("has-error");
      for(var i=0; i<curInputs.length; i++){
          if (!curInputs[i].validity.valid){
              isValid = false;
              $(curInputs[i]).closest(".form-group").addClass("has-error");
          }
      }

      if (isValid)
          nextStepWizard.removeAttr('disabled').trigger('click');
  });

  $('div.setup-panel div a.active').trigger('click');
});