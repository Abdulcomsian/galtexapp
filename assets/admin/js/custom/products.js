var gallery_images = [];
var removed_gallery_images = [];
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
	       aTargets: [0,4,6]
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

/**************** Add New Product Script Start *************/

var form_object = jQuery(".add-new-product-form");
form_object.validate({
    ignore: ":hidden:not(select.chosen-select)",
    rules:{
        product_name:{
            required: true
        },
        product_category_id:{
            required: true
        },
        min_price:{
            required: true
        },
        max_price:{
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
        var formData = new FormData($(".add-new-product-form")[0]);
        if(gallery_images.length > 0){
            for (var i = 0; i < gallery_images.length; i++) {
              formData.append('product_gallery_images[]', gallery_images[i]);
            }
        }else{
            showToaster('error',error,select_gallery_images); 
            return false;
        }
        $.ajax({
            url: api_url + 'products/add',
            type:"POST",
            data: formData,
            dataType : "JSON",   
            cache: false,
            contentType: false,
            processData: false,
            success: function(resp){
                if(resp.status == 200){
                    showToaster('success',success,resp.message);  
                    setTimeout(function(){
		            	window.location.href = base_url + 'admin/products/list';
		            },500);
                }else{
                    showToaster('error',error,resp.message);  
                }
                hideProgressBar();
            }
        });
    }
});

/**************** Add New Product Script End ***************/


/**************** Edit Product Script Start ***************/

var form_object = jQuery(".edit-product-form");
form_object.validate({
    ignore: ":hidden:not(select.chosen-select)",
    rules:{
        product_name:{
            required: true
        },
        product_category_id:{
            required: true
        },
        min_price:{
            required: true
        },
        max_price:{
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
    submitHandler: function (form) {
        var formData = new FormData($(".edit-product-form")[0]);
        if(gallery_images.length > 0){
            for (var i = 0; i < gallery_images.length; i++) {
              formData.append('product_gallery_images[]', gallery_images[i]);
            }
        }
        if(removed_gallery_images.length > 0){
            for (var i = 0; i < removed_gallery_images.length; i++) {
              formData.append('removed_product_gallery_images[]', removed_gallery_images[i]);
            }
        }
        $.ajax({
            url: api_url + 'products/edit',
            type:"POST",
            data: formData,
            dataType : "JSON",   
            cache: false,
            contentType: false,
            processData: false,
            success: function(resp){
                if(resp.status == 200){
                    showToaster('success',success,resp.message);  
                    setTimeout(function(){
                        window.location.href = base_url + 'admin/products/list';
                    },500);
                }else{
                    showToaster('error',error,resp.message);  
                }
                hideProgressBar();
            }
        });
    }
});

/**************** Edit Product Script End *****************/

/* DropZone */
if($('section#content').attr('data-page') != 'products-list'){
    Dropzone.autoDiscover = false;
    $("#dZUpload").dropzone({
        url: api_url + 'main/upload_product_gallery_image',
        addRemoveLinks: true,
        autoProcessQueue: true,
        paramName: "gallery_image",
        maxFiles: 10,
        init: function() {
            myDropzone = this;
            this.on("maxfilesexceeded", function(file){
              showToaster('error',error,max_10_gallery_images);  
              this.removeFile(file);
            });
            this.on("removedfile", function(file){
                if(file.hasOwnProperty('php_file_name')){ // Add
                    const index = gallery_images.indexOf(file.php_file_name);
                    if (index > -1) {
                      gallery_images.splice(index, 1);
                    }
                    $.ajax({
                        url: api_url + 'main/remove_product_image',
                        type:"POST",
                        data: {gallery_image:file.php_file_name},
                        success: function(resp){
                           console.log('file removed !!');
                        }
                    });
                }else{ // Edit
                    removed_gallery_images.push(file.name);
                }
            });
            let old_gallery_images = $('input[name="old_gallery_images"]').val();
            if(old_gallery_images){
                $.each(JSON.parse(old_gallery_images), function(key,value) {
                  var mockFile = { name: value.name, size: value.size };
                  myDropzone.emit("addedfile", mockFile);
                  myDropzone.emit("thumbnail", mockFile, value.path);
                  myDropzone.emit("complete", mockFile);
                });
                $('input[name="old_gallery_images"]').removeAttr('name');
            }
        },
        success: function (file, response) {
            gallery_images.push(response);
            file.php_file_name = response;
            file.previewElement.classList.add("dz-success");
        },
        error: function (file, response) {
            showToaster('error',error,response);  
            file.previewElement.classList.add("dz-error");
            this.removeFile(file);
        }
    });
}

$('body').on('click','a.upload-tasks-btn',function(){
    showProgressBar();
    $('form.upload-product-form')[0].reset();
    resetFormValidations();
    setTimeout(function(){
        $('#noAnimation').modal({show:true});
    },200);
    hideProgressBar();
});

var form_object = jQuery(".upload-product-form");
form_object.validate({
    ignore: ":hidden:not(select.chosen-select)",
    rules:{
         products_csv:{
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
            url: api_url + 'products/upload',
            type:"POST",
            data: new FormData($(".upload-product-form")[0]),
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
                        $('div.success-area > strong').text(data.total_success_records+' '+products_uploaded);
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
                        showToaster('success',success,data.total_success_records+' '+products_uploaded);  
                        setTimeout(function(){
                            window.location.href = base_url + 'admin/products/list';
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
    hiddenElement.download = 'products-errors.csv';  
    hiddenElement.click();  
    hideProgressBar();
})

});
