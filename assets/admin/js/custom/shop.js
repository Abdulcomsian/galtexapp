$(document).ready(function(){

$(".heart-icon").click(function() {
  let self = $(this);
  let shop_product_id = self.attr('data-shop-product-id');
  if(self.hasClass('fa-heart')){ // Like to Dislike
    self.attr('data-shop-product-id',shop_product_id.replace("Liked","Deleted"));
  }else{ // Dislike to Like
    self.attr('data-shop-product-id',shop_product_id.replace("Deleted","Liked"));
  }
  self.toggleClass("fa-heart fa-heart-o");
});

$('body').on('click','button.send-to-galtex',function(){

    /* Get Selected Products (Within Budget) */
    let within_product_guids = $.makeArray($('i.within_budget_products').map(function(idx, elm) {
                                  var jElm = $(elm);
                                  var value = jElm.attr('data-shop-product-id');
                                  return value;
                                }));

    /* Get Selected Products (Above Budget) */
    let above_product_guids = $.makeArray($('i.above_budget_products').map(function(idx, elm) {
                                  var jElm = $(elm);
                                  var value = jElm.attr('data-shop-product-id');
                                  return value;
                                }));

    /* Get Selected Packages (Under Budget) */
    let client_packages = $.makeArray($('i.client_packages').map(function(idx, elm) {
                          var jElm = $(elm);
                          var value = jElm.attr('data-shop-product-id');
                          return value;
                        }));

    if(within_product_guids.length === 0 && above_product_guids.length === 0){
        showToaster('error',error,select_products);
        return false;
    }
    $.ajax({
        url: api_url + 'shop/like_dislike_shop_products',
        type:"POST",
        data: {client_packages:client_packages,within_product_guids:within_product_guids,above_product_guids:above_product_guids},
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

});