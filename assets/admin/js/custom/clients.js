$(document).ready(function(){

/**************** Datatable Script Start *************/

if($('table').hasClass('my-datatable')){
	jQuery('.my-datatable').dataTable({
		dom: 'Bfrtip',
	    buttons: [
	        'colvis'
	    ],
        bStateSave : true,
	    aoColumnDefs: [{
	       bSortable: false,
	       aTargets: [0,8]
	    },
	 	],
        language : {
            search : "חיפוש",
            paginate: {
                first:      "ראשון",
                previous:   "הקודם",
                next:       "הבא",
                last:       "אחרון"
            },
            info : 'מראה _PAGE_ שֶׁל _PAGES_',
            infoFiltered:   "(מסונן מ _MAX_ סך השיאים)",
            zeroRecords : 'אין נתונים זמינים בטבלה'
        }
	  });
}

/**************** Datatable Script End *************/

/**************** Add New Client Script Start *************/

var form_object = jQuery(".add-new-client-form");
form_object.validate({
  ignore: ":hidden:not(select.chosen-select)",
  rules:{
        company_name:{
            required: true
        },
        contact_name:{
            required: true
        },
        contact_number:{
            required: true
        },
        first_name:{
            required: true
        },
        last_name:{
            required: true
        },
        email:{
            required: true,
            email: true,
        },
        employee_budget:{
            required: true,
        },
        shop_title:{
            required: true,
        },
        theme_color:{
            required: true,
        },
        password:{
            required: true,
            minlength:6
        },
        delivery_method:{
            required: true,
        }
  },
    highlight: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
      jQuery(element[0]).remove();
    },
    submitHandler: function() {
        $.ajax({
            url: api_url + 'clients/add',
            type:"POST",
            data: new FormData($(".add-new-client-form")[0]),
            dataType : "JSON",   
            cache: false,
            contentType: false,
            processData: false,
            success: function(resp){
                if(resp.status == 200){
                    showToaster('success',success,resp.message);  
                    setTimeout(function(){
		            	window.location.href = base_url + 'admin/clients/list';
		            },500);
                }else{
                    showToaster('error',error,resp.message);  
                }
                hideProgressBar();
            }
        });
    }
});

/**************** Add New Client Script End ***************/


/**************** Edit Client Script Start ***************/

var form_object = jQuery(".edit-client-form");
form_object.validate({
    ignore: ":hidden:not(select.chosen-select)",
    rules:{
        company_name:{
            required: true
        },
        contact_name:{
            required: true
        },
        contact_number:{
            required: true
        },
        first_name:{
            required: true
        },
        last_name:{
            required: true
        },
        shop_title:{
            required: true,
        },
        theme_color:{
            required: true,
        },
        delivery_method:{
            required: true,
        },
        user_status:{
            required: true,
        },
        deadline:{
            required: true,
        }
    },
    highlight: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
      jQuery(element[0]).remove();
    },
    submitHandler: function() {
        $.ajax({
            url: api_url + 'clients/edit',
            type:"POST",
            data: new FormData($('.edit-client-form')[0]),
            dataType : "JSON",   
            cache: false,
            contentType: false,
            processData: false,
            success: function(resp){
                if(resp.status == 200){
                    showToaster('success',success,resp.message);  
                    setTimeout(function(){
                        window.location.href = base_url + 'admin/clients/list';
                    },500);
                }else{
                    showToaster('error',error,resp.message);  
                }
                hideProgressBar();
            }
        });
    }
});

/**************** Edit Client Script End *****************/

/**************** View Client Script Start *************/ 

$('body').on('click','button.view-user-details',function(){
    let user_guid = $(this).attr('data-user-guid');
    $.ajax({
        url: api_url + 'clients/details',
        type:"POST",
        data: {user_guid:user_guid,data_type:'html'},
        success: function(resp){
            $('div#modal-section').html(resp);
            setTimeout(function(){
                $('#noAnimation').modal({show:true});
            },200);
            hideProgressBar();
        }
    });
})

/**************** View Client Script End ***************/

$('body').on('change','select[name="delivery_method"]',function(){
    let delivery_method = $(this).val();
    if(delivery_method === 'Pickup' || delivery_method === 'Both'){
        $('div.pickup-address-section').removeClass('hidden');
    }else{
        $('div.pickup-address-section').addClass('hidden');
    }
});

$('body').on('click','a.add-more-address',function(){
    let html = '<div class="row m-t-10"><div class="col-sm-8">';
        html += '<input type="text" class="form-control" name="pickup_addresses[]" placeholder="'+pickup_address+'" maxlength="500" autocomplete="off">';
        html += '</div><div class="col-sm-4"><a href="javascript:void(0);" style="width:80px;" class="btn btn-danger remove-address">Remove</a>';
        html += '</div></div>';
    $('div.more-pickup-address').append(html);
});

$('body').on('click','a.remove-address',function(){
    $(this).parent().parent().remove();
});


/**************** View Pick Up Address Script Start *************/ 

$('body').on('click','button.view-pickup-address',function(){
    let user_guid = $(this).attr('data-user-guid');
    $.ajax({
        url: api_url + 'clients/pickup_addresses',
        type:"POST",
        data: {user_guid:user_guid,data_type:'html'},
        success: function(resp){
            $('div#modal-section').html(resp);
            setTimeout(function(){
                $('#noAnimation').modal({show:true});
            },200);
            hideProgressBar();
        }
    });
})

/**************** View Pick Up Address Script End ***************/

$('body').on('click','button.create-package',function(){
    if($('input[name="under_budget_products[]"]:checked').length === 0){
        showToaster('error',error,select_products);
        return false;
    }

    /* Get Selected Products */
    let product_guids = $('input.under_budget_products:checkbox:checked').map(function() {
                            return this.value;
                        }).get();

    let products_html = "";
    for (var i = 0; i < product_guids.length; i++) {
        products_html += '<div class="col-sm-6 col-md-3"><div class="thumbnail">';
        products_html += '<img src="'+$('div[data-product="'+product_guids[i]+'"] > div.thumbnail > img').attr('src')+'" alt="product" class="img-responsive">';
        products_html += '<div class="caption"><h4>'+$('div[data-product="'+product_guids[i]+'"] > div.thumbnail > div.caption > h4').text()+'</h4>';
        products_html += '<p>'+$('div[data-product="'+product_guids[i]+'"] > div.thumbnail > div.caption > p').text()+'</p><div class="clearfix"></div>';
        products_html += '</div></div></div>';
    }
    $('div.package-products').html(products_html);
    setTimeout(function(){
        $('#view_package').modal({show:true});
    },200);
});

$('body').on('click','button.submit-package',function(){
    let package_name = $('input[name="package_name"]').val();
    if(!package_name){
        showToaster('error',error,set_package_name);
        return false;
    }

    /* Get Selected Products */
    let product_guids = $('input.under_budget_products:checkbox:checked').map(function() {
                            return this.value;
                        }).get();

    if(product_guids.length === 0){
        showToaster('error',error,select_products);
        return false;
    }
    $.ajax({
        url: api_url + 'clients/create_package',
        type:"POST",
        data: {package_name:package_name,product_guids:product_guids,user_guid:$('input[name="user_guid"]').val(),quantity:$('input[name="quantity"]').val()},
        success: function(resp){
            if(resp.status == 200){
                showToaster('success',success,resp.message);  
                setTimeout(function(){
                    window.location.reload();
                },500);
            }else{
                showToaster('error',error,resp.message);  
            }
            hideProgressBar();
        }
    });
});

$('body').on('change','input.above_budget_products',function(){
    let self = $(this);
    if(self.is(":checked")){
        self.parent().parent().prev().removeClass('hidden');
    }else{
        self.parent().parent().prev().addClass('hidden');
    }
});

$('body').on('click','button.set-shop',function(){

    /* Get Selected Products (Within Budget) */
    let within_product_guids = $('input.within_budget_products:checkbox:checked').map(function() {
                            return this.value;
                        }).get();

    /* Get Selected Products (Above Budget) */
    let above_product_guids = $('input.above_budget_products:checkbox:checked').map(function() {
                            return this.value;
                        }).get();

    /* Get Selected Products Price (Above Budget) */
    let above_product_additional_prices = $('input.additional_prices').map(function() {
                            return this.value;
                        }).get();

    let within_budget_product_quantities = $('input.within_budget_product_quantities').map(function() {
                            return this.value;
                        }).get();

    let above_budget_product_quantities = $('input.above_budget_product_quantities').map(function() {
                            return this.value;
                        }).get();

    if(within_product_guids.length === 0 && above_product_guids.length === 0){
        showToaster('error',error,select_products);
        return false;
    }
    if(above_product_guids.length > 0){
        above_product_additional_prices = above_product_additional_prices.filter(item => item);
        for (var i = 0; i < above_product_guids.length; i++) {
            if(!above_product_additional_prices[i]){
                showToaster('error',error,add_selected_product_prices);
                return false;
            }
        }
    }
    $.ajax({
        url: api_url + 'clients/set_shop',
        type:"POST",
        data: {user_guid:$('input[name="user_guid"]').val(),within_product_guids:within_product_guids,above_product_guids:above_product_guids,above_product_additional_prices:above_product_additional_prices,within_budget_product_quantities:within_budget_product_quantities,above_budget_product_quantities:above_budget_product_quantities},
        success: function(resp){
            if(resp.status == 200){
                showToaster('success',success,resp.message);  
                setTimeout(function(){
                    window.location.reload();
                },500);
            }else{
                showToaster('error',error,resp.message);  
            }
            hideProgressBar();
        }
    });
});

var dateToday = new Date();
$( function() {
    $( "#deadline" ).datepicker({
        minDate: dateToday
    });
});

var url = document.URL;
var hash = url.substring(url.indexOf('#'));

$(".tab-nav").find("li a").each(function(key, val) {
    if (hash == $(val).attr('href')) {
        $(val).click();
    }
    
    $(val).click(function(ky, vl) {
        location.hash = $(this).attr('href');
    });
});

});

