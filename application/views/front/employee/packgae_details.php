<main class="main_content">
   <section class="inner_banner_sec">
      <div class="innerbanner_cap text-center">
         <div class="container">
            <div class="watermark_text">
               <h1 class="head_1"><?php echo $details['package_name']; ?></h1>
               <p class="watermark wow zoomIn" data-wow-delay="0.4s"><?php echo lang('packages'); ?></p>
            </div>
         </div>
      </div>
   </section>

   <?php foreach($details['products']['data']['records'] as $product) { ?>
     <div class="single_product_page">
        <div class="container">
          <div class="row">
             <div class="col-md-6 wow fadeInUp">
                <div class="single_slider_main clearfix">
                      <div class="product_slider_main">
                        <div class="product_main_item ex1">
                          <img src="<?php echo $product['product_main_photo']; ?>" alt="main-photo" />
                        </div>

                        <?php foreach($product['product_gallery_images'] as $image) { ?>
                           <div class="product_main_item ex1">
                             <img src="<?php echo base_url(); ?>uploads/products/<?php echo $image; ?>" alt="gallery-image" />
                           </div>
                        <?php } ?>
                      </div>

                      <div class="product_slider_thumb arrow_center wow zoomIn">
                        <div class="product_thumb_item">
                          <div class="thumb_inner">
                            <img src="<?php echo $product['product_main_photo']; ?>" alt="main-photo" />
                          </div>
                        </div>

                        <?php foreach($product['product_gallery_images'] as $image) { ?>
                           <div class="product_thumb_item">
                             <div class="thumb_inner">
                               <img src="<?php echo base_url(); ?>uploads/products/<?php echo $image; ?>" alt="gallery-image" />
                             </div>
                           </div>
                        <?php } ?>
                      </div>
                </div>
             </div>
             <div class="col-md-6">
                <div class="product_right">
                   <div class="row">
                      <div class="col-md-12">
                         <h1 class="product_name wow bounce"><?php echo $product['product_name']; ?></h1>
                         <!-- <div class="product_price wow fadeInRight"> $26.00 <del>$34.00</del></div> -->
                         <div class="sku_main">
                           <p class="wow fadeInRight" data-wow-delay="0.4s"><span><?php echo lang('category'); ?>:</span> <span class="greenText ml-3"><?php echo $product['category_name']; ?></span></p>
                          <p class="wow fadeInRight" data-wow-delay="0.2s"><span><?php echo lang('warranty'); ?>:</span> <span class="ml-3"> <?php echo $product['warranty']; ?></span></p>
                          <?php if($details['remaining_quantity'] < REMAINING_PRODUCTS_QUANTITY_LIMIT) { ?>
                           <p class="wow fadeInRight" data-wow-delay="0.2s"><span><?php echo lang('remaining_quantity'); ?>:</span> <span class="ml-3"> <?php echo $details['remaining_quantity']; ?></span></p>
                           <?php } ?>
                         </div>
                      </div>
                   </div>
                   <div class="row">
                      <div class="col-md-12">
                         <div class="product_detail wow fadeInRight">
                            <p><?php echo $product['product_descprition']; ?></p>
                         </div>
                      </div>
                   </div>
                     <?php if($details['remaining_quantity'] > 0) { ?>
                       <!-- <div class="product_information wow fadeInUp">
                          <div class="quantity_box">
                             <label><?php //echo lang('quantity'); ?></label>
                             1
                          </div>
                       </div> -->
                     <?php } ?>
                </div>
             </div>
          </div>

        </div>
      </div>
      <div class="singleprod-devider"></div>
    <?php } ?>
    <center>

      <?php if($details['remaining_quantity'] > 0) { ?>
          <div class="quantity_box">
             <label><?php echo lang('quantity'); ?></label>
             <div class="quantity">
                <input class="touch-spin-count-ver" readonly type="text" value="<?php echo $quantity; ?>" name="pro_quantity">
             </div>
          </div>
      <?php } if($is_added_into_cart) { ?>
         <div class="product-button wow zoomIn"><a href="../../employees/cart" style="margin-bottom:10px;" class="btn btn_common"><?php echo lang('go_to_cart'); ?></a></div>
      <?php } else { ?>
         <?php if($details['remaining_quantity'] > 0) { ?>
            <div class="product-button wow zoomIn"><a href="javascript:void(0);" data-type="package" data-guid="<?php echo $details['package_guid']; ?>" style="margin-bottom:10px;" class="btn btn_common add-to-cart"><?php echo lang('add_to_cart'); ?></a></div>
         <?php } else { ?>
            <strong><a href="javascript:void(0);" style="margin-top:10px;color:red;"><?php echo lang('out_of_stock'); ?></a></strong>
      <?php } } ?>
      <div class="product-button wow zoomIn"><a href="../../employees/products" class="btn btn_common"><?php echo lang('back_to_store'); ?></a></div>
    </center>
</main>