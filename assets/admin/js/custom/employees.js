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
	       aTargets: [0,7]
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

/**************** Add New Employee Script Start *************/

var form_object = jQuery(".add-new-employee-form");
form_object.validate({
  ignore: ":hidden:not(select.chosen-select)",
  rules:{
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
        phone_number:{
            required: true,
        },
        password:{
            required: true,
            minlength:6
        },
        client_guid:{
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
            url: api_url + 'employees/add',
            type:"POST",
            data: $('.add-new-employee-form').serialize(),
            success: function(resp){
                if(resp.status == 200){
                    showToaster('success',success,resp.message);  
                    setTimeout(function(){
		            	window.location.href = base_url + 'admin/employees/list';
		            },500);
                }else{
                    showToaster('error',error,resp.message);  
                }
                hideProgressBar();
            }
        });
    }
});

/**************** Add New Employee Script End ***************/


/**************** Edit Employee Script Start ***************/

var form_object = jQuery(".edit-employee-form");
form_object.validate({
    ignore: ":hidden:not(select.chosen-select)",
    rules:{
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
        phone_number:{
            required: true,
        },
        user_status:{
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
            url: api_url + 'employees/edit',
            type:"POST",
            data: $('.edit-employee-form').serialize(),
            success: function(resp){
                if(resp.status == 200){
                    showToaster('success',success,resp.message);  
                    setTimeout(function(){
                        window.location.href = base_url + 'admin/employees/list';
                    },500);
                }else{
                    showToaster('error',error,resp.message);  
                }
                hideProgressBar();
            }
        });
    }
});

/**************** Edit Employee Script End *****************/

/**************** View Employee Script Start *************/ 

$('body').on('click','button.view-user-details',function(){
    let user_guid = $(this).attr('data-user-guid');
    $.ajax({
        url: api_url + 'employees/details',
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

/**************** View Employee Script End ***************/

$('body').on('click','a.upload-employee-btn',function(){
    showProgressBar();
    $('form.upload-employee-form')[0].reset();
    resetFormValidations();
    setTimeout(function(){
        $('#noAnimationCsv').modal({show:true});
    },200);
    hideProgressBar();
});

var form_object = jQuery(".upload-employee-form");
form_object.validate({
    ignore: ":hidden:not(select.chosen-select)",
    rules:{
        user_guid:{
            required: true
        },
        employees_csv:{
            required: true
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
        ajaxindicatorstart();
        $.ajax({
            url: api_url + 'employees/upload',
            type:"POST",
            data: new FormData($(".upload-employee-form")[0]),
            dataType : "JSON",   
            cache: false,
            contentType: false,
            processData: false,
            success: function(resp){
                if(resp.status == 200){
                    let data = resp.data;
                    let errors = data.error_array;
                    $('#noAnimation').modal('hide');
                    if(parseInt(data.total_success_records) > 0){
                        $('div.success-area').removeClass('hidden');
                        $('div.success-area > strong').text(data.total_success_records+' '+employees_uploaded);
                    }
                    if(errors.length > 0){
                        task_errors = errors;
                        let td_html = '';
                        for (var i = 0; i < errors.length; i++) {
                            td_html += "<tr><td>"+(i+1)+"</td><td>"+errors[i]+"</td></tr>";
                        }
                        $('table.error-datatable > tbody').html(td_html);
                        setTimeout(function(){
                            jQuery('.error-datatable').dataTable({
                                dom: 'Bfrtip',
                                buttons: [
                                    'colvis'
                                ],
                                aoColumnDefs: [{
                                   bSortable: false,
                                   aTargets: [0]
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
                            $('table.error-datatable').removeClass('hidden');
                            $('#task_errors').modal({show:true});
                        },500);
                    }else{
                        showToaster('success',success,data.total_success_records+' '+employees_uploaded);  
                        setTimeout(function(){
                            window.location.href = base_url + 'admin/employees/list';
                        },500);
                    }
                }else{
                    showToaster('error',error,error);  
                }
                ajaxindicatorstop();
                hideProgressBar();
            }
        });
    }
});

$('body').on('click','button.download-report',function(){
    showProgressBar();

    //define the heading for each row of the data  
    var csv = 'Error descprition\n';  
      
    //merge the data with CSV  
    task_errors.forEach(function(row) {  
        csv += row;  
        csv += "\n";  
    });  
   
    var hiddenElement = document.createElement('a');  
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);  
    hiddenElement.target = '_blank';  
      
    //provide the name for the CSV file to be downloaded  
    hiddenElement.download = 'employees-errors.csv';  
    hiddenElement.click();  
    hideProgressBar();
})

});

