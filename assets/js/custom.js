/**
* Custom jQuery common functions 
* Author: Sorav Garg
* Author Email: soravgarg123@gmail.com
* version: 1.0
*/

/*****************************************************************************
***************************Page Stay/leave script start **********************
******************************************************************************/

window.thisPage = window.thisPage || {};
window.thisPage.isDirty = false;

window.thisPage.closeEditorWarning = function (event) {
    var class_exist = $('form').hasClass('serialize-form');
    if(class_exist == true){
      if($('.serialize-form').serialize()!= $('.serialize-form').data('serialize-form-data')){
        window.thisPage.isDirty = true;
      }else{
        window.thisPage.isDirty = false;
      }
    }else{
      window.thisPage.isDirty = false;
    }
    if (window.thisPage.isDirty)
        return 'It looks like you have been editing something' +
               ' - if you leave before saving, then your changes will be lost.'
    else
        return undefined;
};

window.onbeforeunload = window.thisPage.closeEditorWarning;

/*****************************************************************************
***************************Page Stay/leave script end ************************
******************************************************************************/

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

/***********************************************************************************
***************************Confirmation Box start **********************************
************************************************************************************/

function showConfirmationBox(title,text,confirmButtonText,cancelButtonText,redirectURL)
{
  swal({   
      title: title,   
      text: text,   
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: confirmButtonText,   
      cancelButtonText: cancelButtonText,   
      closeOnConfirm: false,   
      closeOnCancel: false,
      animation: true,
      showLoaderOnConfirm: true
  }, function(isConfirm){   
      if (isConfirm) {     
        window.location.href = redirectURL;  
      } else {     
        swal.close();
      } 
  });
}

/***********************************************************************************
***************************Confirmation Box end ************************************
************************************************************************************/

/***********************************************************************************
**************************Manage Broken Images start *******************************
************************************************************************************/
$(window).load(function() {
  $('img').each(function() {
    if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
      this.src = 'http://www.omsakthiamma.org/images/404.png';
      this.width = 150;
    }
  });
});

/***********************************************************************************
**************************Manage Broken Images end *********************************
************************************************************************************/

$(document).ready(function($) {

now       = new Date();
daysArr   = new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
monthsArr = new Array('January','February','March','April','May','June','July','August','September','October','November','December');

showProgressBar();
setTimeout(function(){
  hideProgressBar();
},1000);


/*****************************************************************************
***************************Cancel button start *******************************
******************************************************************************/

$('body').on('click','.cancel-btn',function(){
  window.history.back();
});

/*****************************************************************************
***************************Cancel button end *********************************
******************************************************************************/

/*****************************************************************************
***************************Show/hide password start **************************
******************************************************************************/

$('body').on('click','.toggle-password',function(){
  let self = this;
  self.toggleClass("fa-eye fa-eye-slash");
  let input = $(self.attr("toggle"));
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

/*****************************************************************************
***************************Show/hide password end ****************************
******************************************************************************/

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

/*****************************************************************************
***************************Select Chosen Start *******************************
******************************************************************************/

var class_exist = $('select').hasClass('chosen-select');
if (class_exist == true) {
  $("select.chosen-select").chosen({disable_search_threshold: 10});
}

/*****************************************************************************
***************************Select Chosen Start *******************************
******************************************************************************/

/*****************************************************************************
**********************Onload form save current state Start *******************
******************************************************************************/

var class_exist = $('form').hasClass('serialize-form');
if (class_exist == true) {
  $('.serialize-form').data('serialize-form-data',$('.serialize-form').serialize());
}

/*****************************************************************************
**********************Onload form save current state end *********************
******************************************************************************/

/*****************************************************************************
***********************Validate only numbers end *****************************
******************************************************************************/

$('body').on('keypress','.validate-no',function(event){
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode == 46){
       return false;
    }
    if (event.keyCode == 9 || event.keyCode == 8 || event.keyCode == 46) {
       return true;
    }
    else if ( key < 48 || key > 57 ) {
       return false;
    }
    else return true;
});

/*****************************************************************************
***********************Validate only numbers end *****************************
******************************************************************************/

/*****************************************************************************
****************For Phone no format 10 digits start **************************
******************************************************************************/

$('body').on('keyup', '.phone', function(e) {
  if(e.keyCode > 36 && e.keyCode < 41)
  {
      return true;
  }
  if ((e.keyCode > 47 && e.keyCode <58) || (e.keyCode < 106 && e.keyCode > 95))
  {
      this.value = this.value
      .match(/\d*/g).join('')
      .match(/(\d{0,3})(\d{0,3})(\d{0,4})/).slice(1).join('-')
      .replace(/-*$/g, '');
      return true;
  }
  this.value = this.value.replace(/[^\-0-9]/g,'');
});

/*****************************************************************************
****************For Phone no format 10 digits end ****************************
******************************************************************************/

/*****************************************************************************
****************Bootstrap common functions start *****************************
******************************************************************************/

$('.modal').on('hidden.bs.modal', function () {
  $('input, select, textarea').val('');
});

$('[data-toggle="tooltip"]').tooltip();

$('.popover').popover();

$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
  var id = $(e.target).attr("href").substr(1);
  window.location.hash = id;
});

var hash = window.location.hash;
$('ul.nav-tabs a[href="' + hash + '"]').tab('show');

/*****************************************************************************
****************Bootstrap common functions end *******************************
******************************************************************************/

/*****************************************************************************
****************Add title on all anchor tags start ****************************
******************************************************************************/

$('a:not([title])').each(function(){
   $(this).attr('title',$(this).text().trim());
});

/*****************************************************************************
****************Add title on all anchor tags end *****************************
******************************************************************************/

$('textarea').on('input', function () {
  this.style.height = 'auto';
  this.style.height = (this.scrollHeight) + 'px';
});

});

/*****************************************************************************
****************Google address autocomplete start ****************************
******************************************************************************/

function initializeGoogleAutocomplete(){
  var isClassExist = $('input').hasClass('google-autocomplete');
  if(isClassExist == true){ 
    var acInputs     = document.getElementsByClassName("google-autocomplete");
    var totalInputs  = parseInt(acInputs.length);
    if(totalInputs > 0)
    {
      for (var i = 0; i < totalInputs; i++) 
      {
        var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);
            autocomplete.inputId = acInputs[i].id;
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            var address = place.formatted_address;
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
        });
      }
    }
  }  
}

/*****************************************************************************
****************Google address autocomplete end ******************************
******************************************************************************/

/*****************************************************************************
**********************Tinymce editor start ***********************************
******************************************************************************/

function initEditor() {
    var class_exist = $('textarea').hasClass('mceEditor');
    if (class_exist == true) {
        tinymce.init({
            mode: "textareas",
            editor_selector: "mceEditor",
            theme: "modern",
            font_size_classes: "fontSize1, fontSize2, fontSize3, fontSize4, fontSize5, fontSize6",
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],

            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons | sizeselect | fontselect | fontsize | fontsizeselect",
            style_formats: [{
                title: 'Bold text',
                inline: 'b'
            }, {
                title: 'Red text',
                inline: 'span',
                styles: {
                    color: '#ff0000'
                }
            }, {
                title: 'Red header',
                block: 'h1',
                styles: {
                    color: '#ff0000'
                }
            }, {
                title: 'Example 1',
                inline: 'span',
                classes: 'example1'
            }, {
                title: 'Example 2',
                inline: 'span',
                classes: 'example2'
            }, {
                title: 'Table styles'
            }, {
                title: 'Table row 1',
                selector: 'tr',
                classes: 'tablerow1'
            }]
        });
    }
}

/*****************************************************************************
**********************Tinymce editor end *************************************
******************************************************************************/

window.onload = function() {
  initializeGoogleAutocomplete();
  initEditor();
};

/*****************************************************************************
**********************Ajax loader start ***************************************
******************************************************************************/

function ajaxindicatorstart()
{
    if(jQuery('body').find('#resultLoading').attr('id') != 'resultLoading'){
    jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="'+base_url+'assets/img/ajax-loader.gif"><div>Loading...</div></div><div class="bg"></div></div>');
    }
    
    jQuery('#resultLoading').css({
        'width':'100%',
        'height':'100%',
        'position':'fixed',
        'z-index':'10000000',
        'top':'0',
        'left':'0',
        'right':'0',
        'bottom':'0',
        'margin':'auto'
    }); 
    
    jQuery('#resultLoading .bg').css({
        'background':'#000000',
        'opacity':'0.7',
        'width':'100%',
        'height':'100%',
        'position':'absolute',
        'top':'0'
    });
    
    jQuery('#resultLoading>div:first').css({
        'width': '250px',
        'height':'75px',
        'text-align': 'center',
        'position': 'fixed',
        'top':'0',
        'left':'0',
        'right':'0',
        'bottom':'0',
        'margin':'auto',
        'font-size':'16px',
        'z-index':'10',
        'color':'#ffffff'
        
    });

    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeIn(300);
    jQuery('body').css('cursor', 'wait');
}

function ajaxindicatorstop()
{
    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeOut(300);
    jQuery('body').css('cursor', 'default');
}

/*****************************************************************************
**********************Ajax loader end ****************************************
******************************************************************************/

/*****************************************************************************
*******************Get Date/Time start ***************************************
******************************************************************************/

function getCurrentDate()
{
    var today = new Date();
    var dd = (today.getDate() >= 10) ? today.getDate() : "0"+today.getDate();
    var mm = (today.getMonth()+1 >= 10) ? today.getMonth()+1 : "0"+(today.getMonth()+1);
    var yyyy = today.getFullYear();
    var date = yyyy+'-'+mm+'-'+dd;
    return date;
}

function getCurrentTime()
{
   var d = new Date();
   var hours   = d.getHours();
   var minutes = (d.getMinutes() >= 10) ? d.getMinutes() : "0" + d.getMinutes();
   var ampm    = hours >= 12 ? 'PM' : 'AM';
   hours = (hours > 12)? hours -12 : hours;
   var time = (hours >= 10) ? hours : "0" +hours+":"+minutes+" "+ampm;
   return time;
}

/*****************************************************************************
*******************Get Date/Time end *****************************************
******************************************************************************/

/*****************************************************************************
***************** Convert Date/Time Start ************************************
******************************************************************************/

function timeConverter(timestamp)
{
  var a = new Date(timestamp * 1000);
  var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
  var days   = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  var year   = a.getFullYear();
  var month  = a.getMonth();
  var m_name = months[a.getMonth()];
  var date   = a.getDate();
  var day    = days[a.getDay()];
  var hour   = a.getHours();
  var min    = a.getMinutes();
  var sec    = a.getSeconds();
  var time   = {"year":year,"month":addZero(month),"month_name":m_name,"day":day,"date":addZero(date),"hour":addZero(hour),"min":addZero(min),"sec":addZero(sec)};
  return time;
}


/*****************************************************************************
***************** Convert Date/Time end **************************************
******************************************************************************/

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

function addZero(no)
{
  if(no >= 10){
    return no;
  }else{
    return "0" + no;
  }
}

/*****************************************************************************
*******************To validate file start ************************************
******************************************************************************/

function validateFile(input,ext,size)
{
  var file_name = input.value;
  var split_extension = file_name.split(".").pop();
  var extArr = ext.split("|");
  if($.inArray(split_extension.toLowerCase(), extArr ) == -1)
  {
    $(input).val("");
    showToaster('error','Error !','You Can Upload Only .'+extArr.join(", ")+' files !');
    return false;
  }
  if(size != ""){
    
  }
}

/*****************************************************************************
*******************To validate file end **************************************
******************************************************************************/

/*****************************************************************************
*******************To check null value start *********************************
******************************************************************************/

function null_checker(check_val)
{
  if (typeof(default_val) === undefined) default_val = "";
  if(check_val == null || check_val == undefined || check_val == ""){
    return default_val;
  }else{
    return check_val;
  }
}

/*****************************************************************************
*******************To check null value end ***********************************
******************************************************************************/

/*****************************************************************************
******************* To create unique id start ********************************
******************************************************************************/

function guid() 
{
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
}

/*****************************************************************************
******************* To create unique id end **********************************
******************************************************************************/

/*****************************************************************************
******************** To format number start **********************************
******************************************************************************/

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

/*****************************************************************************
******************** To format number end ************************************
******************************************************************************/

/*****************************************************************************
******************** To capitalize string start ******************************
******************************************************************************/

function capitalizeEachWord(str) 
{
    return str.replace(/\w\S*/g, function(txt) {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}

/*****************************************************************************
******************** To capitalize string end ********************************
******************************************************************************/

/*****************************************************************************
******************** To user geolocation start *******************************
******************************************************************************/

function getLocation() 
{
  if (navigator.geolocation) {
       navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
       console.log("Geolocation is not supported by this browser.");
  }
 }

 function showPosition(position) 
 {
    let latLng = {"latitude":position.coords.latitude,"longitude":position.coords.longitude};
    console.log('latLng',latLng);
 }

/*****************************************************************************
******************** To user geolocation end *********************************
******************************************************************************/

/*****************************************************************************
****************Add Ajax Global Headers & Methods start **********************
******************************************************************************/

$.ajaxSetup({
    beforeSend: function (xhr){
       showProgressBar();         
       xhr.setRequestHeader("Accept","application/vvv.website+json;version=1");
       xhr.setRequestHeader("Authorization",get_login_session_key()); 
    },
    error:function(jqXHR,exception){
        manageAjaxError(jqXHR,exception);
        hideProgressBar(); 
    }
});

/*****************************************************************************
****************Add Ajax Global Headers & Methods end ***********************
******************************************************************************/

/*****************************************************************************
******************** To manage ajax error start ******************************
******************************************************************************/

function manageAjaxError(jqXHR,exception)  
{ 
    if (jqXHR.status === 0) {
        showToaster('error','Error !','Not connect.\n Verify Network.');
    } else if (jqXHR.status == 403) {
        showToaster('error','Error !',"You don't have permission, to access this module. [403]");
    } else if (jqXHR.status == 404) {
        showToaster('error','Error !','Requested page not found. [404]');
    } else if (jqXHR.status == 500) {
        showToaster('error','Error !','Internal Server Error [500].');
    } else if (jqXHR.status == 502) {
        showToaster('error','Error !',jqXHR.responseJSON.message);
        setTimeout(function(){
          window.location.href = base_url + 'home/logout/' + localStorage.getItem('login_session_key');
        },500);
    } else if (exception === 'parsererror') {
        showToaster('error','Error !','Some error occured, please try again.');
    } else if (exception === 'timeout') {
        showToaster('error','Error !','Time out error.');
    } else if (exception === 'abort') {
        showToaster('error','Error !','Ajax request aborted.');
    }  else {
        showToaster('error','Error !','Uncaught Error.\n' + jqXHR.responseText);
    }
}

/*****************************************************************************
******************** To manage ajax error end ********************************
******************************************************************************/

/*****************************************************************************
******************** To get login session key start **************************
******************************************************************************/

function get_login_session_key() 
{
    let login_session_key = localStorage.getItem('login_session_key');
    if(!login_session_key){
      showToaster('error','Error !','Session disconnected, please re-login.');
      setTimeout(function(){
        window.location.href = base_url + 'home/logout/' + login_session_key;
      },500);
    }
    return login_session_key;
}

/*****************************************************************************
******************** To get login session key end ****************************
******************************************************************************/

/*****************************************************************************
**********************Update Profile Password Script Start********************
******************************************************************************/

$("#password-form").submit(function(event) {
  event.preventDefault();
  var form_data = new FormData($('#password-form')[0]);
  $.ajax({
        url  : api_url + "user/change_password",
        type : "POST",
        data : form_data,   
        dataType : "JSON",   
        cache: false,
        contentType: false,
        processData: false,   
        success: function(resp){
        if(resp.status == 200){
          $('#password-form')[0].reset();
          $('#changePasswordModal').modal('hide');
          showToaster('success','Success',resp.message);
        }else{
          showToaster('error','Error !',resp.message);  
        }
      }
    });
});

/*****************************************************************************
********************Update Profile Password Script End ***********************
******************************************************************************/

/*****************************************************************************
 ****************Change Language Script start ********************************
 ******************************************************************************/

$('body').on('change','select.change-language',function(){
  let lang = $(this).val();
  $.ajax({
    url: api_url + "login/set_language",
    type: "POST",
    dataType : "JSON",
    data: {lang:lang},
    beforeSend:function(xhr){
      xhr.setRequestHeader("Authorization",""); 
    },  
    success: function(resp) {
      window.location.reload();
    },
    error:function(jqXHR, exception){
      manageAjaxError(jqXHR,exception);
    }
  });
});

/*****************************************************************************
 ****************Change Language Script end *********************************
 ******************************************************************************/


$('body').on('click','a.add-to-cart',function(){
  let self = $(this);
  let type = self.attr('data-type');
  let guid = self.attr('data-guid');
  let quantity = $('input[name="pro_quantity"]').val();
  $.ajax({
      url  : api_url + "employee/add_to_cart",
      type : "POST",
      data : {type:type,guid:guid,quantity:quantity},   
      dataType : "JSON",   
      beforeSend:function(xhr){
        ajaxindicatorstart();
        xhr.setRequestHeader("Accept","application/vvv.website+json;version=1");
        xhr.setRequestHeader("Authorization",get_login_session_key()); 
      },       
      success: function(resp){
       if(resp.status == 200){
          $('span.top-cart-info-count').text(resp.data.cart_total_items);
          showToaster('success',success,resp.message);
          window.location.reload();
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

$("#billing-form").submit(function(event) {
  event.preventDefault();
  var form_data = new FormData($('#billing-form')[0]);
  $.ajax({
        url  : api_url + "employee/checkout",
        type : "POST",
        data : form_data,   
        dataType : "JSON",   
        cache: false,
        contentType: false,
        processData: false,   
        beforeSend:function(xhr){
        ajaxindicatorstart();
          xhr.setRequestHeader("Accept","application/vvv.website+json;version=1");
          xhr.setRequestHeader("Authorization",get_login_session_key()); 
        },
        success: function(resp){
          if(resp.status == 200){
            if(resp.data.is_payment == 0){
              showToaster('success','Success',resp.message);
              setTimeout(function(){
                window.location.href = base_url + "employees/profile#myOrder";
              },500)
            }else{
              window.location.href = resp.data.payment_url;
            }
          }else{
            showToaster('error','Error !',resp.message);  
          }
          ajaxindicatorstop();
        },
        error:function(jqXHR, exception){
          manageAjaxError(jqXHR,exception);
          ajaxindicatorstop();
        }
    });
});

$('body').on('change','select[name="address_mode"]',function(){
  let address_mode = $(this).val();
  $('div.delivery-address-section').css('display','none');
  $('div.pickup-address-section').css('display','none');
  if(address_mode === 'Door to Door'){
    $('div.delivery-address-section').css('display','block');
    $('input[name="city"]').attr('required', true);
    $('input[name="street_house"]').attr('required', true);
    // $('input[name="postal_code"]').attr('required', true);
    $('select[name="pickup_address"]').removeAttr('required');
  }else if(address_mode === 'Pickup'){
    $('div.pickup-address-section').css('display','block');
    $('select[name="pickup_address"]').attr('required', true);
    $('input[name="city"]').removeAttr('required');
    $('input[name="street_house"]').removeAttr('required');
    // $('input[name="postal_code"]').removeAttr('required');
  }
});

$('body').on('click','button.cancel-order',function(){
  let self = $(this);
  let order_guid = self.attr('data-order-guid');
  swal({   
      title: cancel_order,   
      text: cancel_order_sure,   
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: confirmButtonText,   
      cancelButtonText: cancelButtonText,   
      closeOnConfirm: false,   
      closeOnCancel: false,
      animation: true,
      showLoaderOnConfirm: true
  }, function(isConfirm){   
      if (isConfirm) {     
        $.ajax({
          url  : api_url + "employee/cancel_order",
          type : "POST",
          data : {order_guid:order_guid},   
          dataType : "JSON",   
          beforeSend:function(xhr){
            ajaxindicatorstart();
            xhr.setRequestHeader("Accept","application/vvv.website+json;version=1");
            xhr.setRequestHeader("Authorization",get_login_session_key()); 
          },       
          success: function(resp){
           if(resp.status == 200){
              showToaster('success',success,resp.message);
              window.location.reload();
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
      } else {     
        swal.close();
      } 
  });

});

$(".filterBox .filterHeader button").click(function(){
  $(".filterBox").css("left","-280px")
})
$(".filterIconBtn").click(function(){
  $(".filterBox").css("left","0px")
})