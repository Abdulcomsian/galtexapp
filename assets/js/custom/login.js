/***********************************************************************************
*****************To show/clear toaster messages start ******************************
************************************************************************************/

function showToaster(msgType,title,msg)
{
  toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "rtl": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": 300,
    "hideDuration": 1000,
    "timeOut": 5000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  toastr[msgType](msg, title);
}

function clearToaster()
{
  toastr.clear();
}

/***********************************************************************************
*****************To show/clear toaster messages end ********************************
************************************************************************************/

/***********************************************************************************
***************************Show/hide progress bar start ****************************
************************************************************************************/

function showProgressBar()
{
  NProgress.start();
}

function hideProgressBar()
{
  NProgress.done();
}

/***********************************************************************************
***************************Show/hide progress bar end ******************************
************************************************************************************/


/*****************************************************************************
****************To get query string from url start ***************************
******************************************************************************/

function getQueryStringValue(key)
{  
  var vars = [], hash;
  var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
  for(var i = 0; i < hashes.length; i++)
  {
    hash = hashes[i].split('=');
    vars.push(hash[0]);
    vars[hash[0]] = hash[1];
  }
  return (!vars[key]) ? '' : vars[key];
}

/*****************************************************************************
****************To get query string from url end *****************************
******************************************************************************/


/*****************************************************************************
******************** To manage ajax error start ******************************
******************************************************************************/

function manageAjaxError(jqXHR,exception) 
{
    if (jqXHR.status === 0) {
        showToaster('error','Error !','Not connect.\n Verify Network.');
    } else if (jqXHR.status == 404) {
        showToaster('error','Error !','Requested page not found. [404]');
    } else if (jqXHR.status == 500) {
        showToaster('error','Error !','Internal Server Error [500].');
    } else if (exception === 'parsererror') {
        showToaster('error','Error !','Requested JSON parse failed.');
    } else if (exception === 'timeout') {
        showToaster('error','Error !','Time out error.');
    } else if (exception === 'abort') {
        showToaster('error','Error !','Ajax request aborted.');
    } else {
        showToaster('error','Error !','Uncaught Error.\n' + jqXHR.responseText);
    }
}

/*****************************************************************************
******************** To manage ajax error end ********************************
******************************************************************************/

$(document).ready(function(){

showProgressBar();
setTimeout(function(){
  hideProgressBar();
},1000);


/*****************************************************************************
***********************Prevent Copy/Paste value start ************************
******************************************************************************/

var class_exist = $('input').hasClass('prevent-copy-paste');
if (class_exist == true) {
  $('.prevent-copy-paste').bind('cut copy paste contextmenu',function(e){
    e.preventDefault();
  });
}

/*****************************************************************************
***********************Prevent Copy/Paste value end **************************
******************************************************************************/

/**************** User Login Script Start *************/

$('body').on('click','button.get_otp_phone_call',function(){
  let phone_number = $('input[name="phone_number"]').val();
  if(!phone_number){
    showToaster('error',error,'Please enter mobile number.'); 
    return false; 
  }
  $.ajax({
        url  : api_url + "login/send_otp_phone_call",
        type : "POST",
        data : {phone_number:phone_number,login_type:$('input[name="login_type"]:checked').val()},   
        dataType : "JSON",   
        beforeSend:function(){
          ajaxindicatorstart();
        },       
        success: function(resp){
         if(resp.status == 200){
            showToaster('success',success,resp.message);
            $('.opt_group').slideDown(); 
            $('button.get_otp_phone_call').addClass('hidden');           
            $('button.login-btn').removeClass('hidden');           
          }else{
            showToaster('error',error,resp.message);  
          }
          ajaxindicatorstop();
      },
        error:function(jqXHR, exception){
          manageAjaxError(jqXHR,exception);
          ajaxindicatorstop();
        }
    });
});

$("#login-form").submit(function(event) {
	event.preventDefault();
	var form_data = new FormData($('#login-form')[0]);
	$.ajax({
        url  : api_url + "login",
        type : "POST",
        data : form_data,   
        dataType : "JSON",   
        cache: false,
        contentType: false,
        processData: false,   
        beforeSend:function(){
          $('.login-btn').attr('disabled',true).val(loading);
        },       
        success: function(resp){
         if(resp.status == 200){
            showToaster('success',success,resp.message);
                localStorage.setItem('login_session_key',resp.data.login_session_key);
                localStorage.setItem('user_guid',resp.data.user_guid);
            setTimeout(function(){
            	window.location.href = resp.data.redirect_uri;
            },1000);
        }else{
          	showToaster('error',error,resp.message);  
          }
          $('.login-btn').attr('disabled',false).val(login);
      },
        error:function(jqXHR, exception){
        	manageAjaxError(jqXHR,exception);
          $('.login-btn').attr('disabled',false).val(login);
        }
    });
});


/**************** User Login Script End **************/

$('body').on('change','input[name="login_type"]',function(){
  let login_type = $(this).val();
  $('div.password-section').css('display','none');
  $('.opt_group').slideUp(); 
  $('input#phoneOtp').val("");
  if(login_type === 'OTP'){
    $('div.password-section').slideUp();
    $('button.login-btn').addClass('hidden'); 
    $('button.get_otp_phone_call').text(receive_otp_message).removeClass('hidden');    
  }else if(login_type === 'Phone'){
    $('div.password-section').slideUp();
    $('button.login-btn').addClass('hidden'); 
    $('button.get_otp_phone_call').text(receive_phone_call).removeClass('hidden');           
  }else if(login_type === 'Password'){
    $('button.get_otp_phone_call').addClass('hidden');           
    $('button.login-btn').removeClass('hidden').text(login);
    $('div.password-section').slideDown().css('display','block');
  }
});

$("#help-form").submit(function(event) {
  event.preventDefault();
  var form_data = new FormData($('#help-form')[0]);
  $.ajax({
        url  : api_url + "login/send_enquiry",
        type : "POST",
        data : form_data,   
        dataType : "JSON",   
        cache: false,
        contentType: false,
        processData: false,   
        beforeSend:function(){
          $('.send-btn').attr('disabled',true).val(loading);
        },       
        success: function(resp){
         if(resp.status == 200){
            showToaster('success',success,resp.message);
            setTimeout(function(){
                $('#havingTroubleModal').modal('hide');
            },200);
            $('textarea[name="message"]').val("");
          }else{
            showToaster('error',error,resp.message);  
          }
          $('.send-btn').attr('disabled',false).val(send);
        },
        error:function(jqXHR, exception){
          manageAjaxError(jqXHR,exception);
          $('.send-btn').attr('disabled',false).val(send);
        }
    });
});


});


$(".mobileHeader button").click(function(){
  if($(".hdr_main .navbar-collapse").hasClass("show")){
    $(".hdr_main .navbar-collapse").removeClass("show")
  }
})

