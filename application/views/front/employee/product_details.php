<main class="main_content">
   <div class="addToCartDiv desktopHide">
<?php if($details['remaining_quantity'] > 0) { ?>
                    
                      <?php } if($is_added_into_cart) { ?>
                        <div class="wow zoomIn"><a href="../../employees/cart" class="btn btn_common"><?php echo lang('go_to_cart'); ?></a></div>
                      <?php } else { ?>
                        <?php if($details['remaining_quantity'] > 0) { ?>
                        <div class="wow zoomIn"><a href="javascript:void(0);" data-type="product" data-guid="<?php echo $details['product_guid']; ?>" class="btn btn_common add-to-cart"><?php echo lang('add_to_cart'); ?></a></div>
                        <?php } else { ?>
                           <strong><a href="javascript:void(0);" style="margin-top:10px;color:red;"><?php echo lang('out_of_stock'); ?></a></strong>
                      <?php } } ?>
                      </div>
                      <div class="backToStore desktopHide">
                      <div class="wow zoomIn"><a href="../../employees/products" class="btn btn_common"><?php echo lang('back_to_store'); ?></a></div>
                      </div>
         <section class="inner_banner_sec productBg mobileHide" >
            <div class="innerbanner_cap text-center">
               <div class="container">
                  <div class="watermark_text">
                     <h1 class="head_1"><?php echo $details['product_name']; ?></h1>
                     <p class="watermark wow zoomIn" data-wow-delay="0.4s"><?php echo lang('products'); ?></p>
                  </div>
               </div>
            </div>
         </section>
         <section class="inner_banner_sec productBg desktopHide" >
            <div class="innerbanner_cap text-center">
               <div class="container">
                  <div class="watermark_text">
                     <h1 class="head_1"><?php echo $details['product_name']; ?></h1>
                     <p class="watermark wow zoomIn" data-wow-delay="0.4s"><?php echo lang('products'); ?></p>
                  </div>
               </div>
            </div>
         </section>
       <div class="single_product_page">
          <div class="container">
             <div class="row" style="margin-bottom: 10px;">
                <div class="col-12 text-right">
                        <a href="" class="additionalCosts desktopHide">
                           Additional costs
                        </a>
                </div>
             </div>
             <div class="product_description desktopHide">
                <div class="row">
                   <div class="col-lg-12 text-right">
                      <b style="padding:10px 0px; color: #373737;">10 last items</b>
                      <p style="line-height: 22px;"><?php echo $details['product_descprition']; ?> </p>
                   </div>
                </div>
             </div>
            <div class="row">
               <div class="col-md-6 wow fadeInUp">
                  <div class="single_slider_main clearfix mobileHide">
                        <div class="product_slider_main">
                          <div class="product_main_item ex1">
                            <img src="<?php echo $details['product_main_photo']; ?>" alt="main-image" />
                          </div>
                          <?php foreach($details['product_gallery_images'] as $image) { ?>
                             <div class="product_main_item ex1">
                               <img src="<?php echo base_url(); ?>uploads/products/<?php echo $image; ?>" alt="gallery-image" />
                             </div>
                          <?php } ?>
                        </div>

                        <div class="product_slider_thumb arrow_center wow zoomIn">
                          <div class="product_thumb_item">
                            <div class="thumb_inner">
                              <img src="<?php echo $details['product_main_photo']; ?>" alt="main-image" />
                            </div>
                          </div>
                          <?php foreach($details['product_gallery_images'] as $image) { ?>
                             <div class="product_thumb_item">
                               <div class="thumb_inner">
                                 <img src="<?php echo base_url(); ?>uploads/products/<?php echo $image; ?>" alt="gallery-image" />
                               </div>
                             </div>
                          <?php } ?>
                        </div>
                  </div>
                  <!-- Hamza Custom Code Here - Start -->
                     <div class="sliderProduct" style="display: none;">
                        <?php foreach($details['product_gallery_images'] as $image) { ?>
                           <div class="productImage">
                             <div class="product_thumb_item">
                               <div class="thumb_inner">
                                 <img src="<?php echo base_url(); ?>uploads/products/<?php echo $image; ?>" alt="gallery-image" />
                               </div>
                             </div>
                        </div>
                          <?php } ?>
                     </div>
                     <!-- Hamza Custom Code Here - End -->
               </div>
               <div class="col-md-6 mobileHide">
                  <div class="product_right">
                     <div class="row">
                        <div class="col-md-12">
                           <h1 class="product_name wow bounce"><?php echo $details['product_name']; ?></h1>
                           <?php if(!empty($details['above_budget_price'])) { ?>
                              <div class="product_price wow fadeInRight"> + <?php echo CURRENCY_SYMBOL.$details['above_budget_price']; ?></div>
                           <?php } ?>
                           <div class="sku_main">
                             <p class="wow fadeInRight" data-wow-delay="0.4s"><span><?php echo lang('category'); ?>:</span> <span class="greenText ml-3"><?php echo $details['category_name']; ?></span></p>
                             <p class="wow fadeInRight" data-wow-delay="0.2s"><span><?php echo lang('warranty'); ?>:</span> <span class="ml-3"> <?php echo $details['warranty']; ?></span></p>
                             <?php if($details['remaining_quantity'] < REMAINING_PRODUCTS_QUANTITY_LIMIT) { ?>
                              <p class="wow fadeInRight" data-wow-delay="0.2s"><span><?php echo lang('remaining_quantity'); ?>:</span> <span class="ml-3"> <?php echo $details['remaining_quantity']; ?></span></p>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="product_detail wow fadeInRight">
                              <p><?php echo $details['product_descprition']; ?> </p>
                           </div>
                        </div>
                     </div>
                     <div class="mobileHide">
                     <?php if($details['remaining_quantity'] > 0) { ?>
                      <div class="product_information wow fadeInUp">
                         <div class="quantity_box">
                            <label><?php echo lang('quantity'); ?></label>
                            <div class="quantity">
                               <input class="touch-spin-count-ver" readonly type="text" value="<?php echo $quantity; ?>" name="pro_quantity">
                            </div>
                         </div>
                      </div>
                      <?php } if($is_added_into_cart) { ?>
                        <div class="product-button wow zoomIn"><a href="../../employees/cart" class="btn btn_common"><?php echo lang('go_to_cart'); ?></a></div>
                      <?php } else { ?>
                        <?php if($details['remaining_quantity'] > 0) { ?>
                        <div class="product-button wow zoomIn"><a href="javascript:void(0);" data-type="product" data-guid="<?php echo $details['product_guid']; ?>" style="margin-bottom:10px;" class="btn btn_common add-to-cart"><?php echo lang('add_to_cart'); ?></a></div>
                        <?php } else { ?>
                           <strong><a href="javascript:void(0);" style="margin-top:10px;color:red;"><?php echo lang('out_of_stock'); ?></a></strong>
                      <?php } } ?>
                      <div class="product-button wow zoomIn"><a href="../../employees/products" class="btn btn_common"><?php echo lang('back_to_store'); ?></a></div>
                  
                     </div>
                     </div>
               </div>
               <!-- Hamza Custom Code Here - Start -->
               <div class="col-md-6 text-right desktopHide">
                  <p style="line-height: 22px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec maximus enim non mattis pharetra. Nulla hendrerit semper sem sed luctus. Maecenas vulputate lacinia ipsum ac rhoncus. Fusce ultricies quam at velit pharetra tempus eu nec ante. Etiam augue tellus, finibus sit amet consequat non, mattis aliquet quam. Nulla blandit, elit id congue luctus, nisl augue mollis odio, non suscipit magna justo quis massa. Nam maximus nisl vitae sollicitudin sollicitudin. Duis sed eleifend urna. Nunc blandit eget quam id lobortis. Nam eget egestas velit.</p>
               </div>
               <div class="col-md-6 cartDiv desktopHide">
                  <p style="line-height: 22px;text-align: center;">Additional 500₪</p>
                  <button class="commonBtn">Add to Cart</button>
               </div>
               <!-- Hamza Custom Code Here - End -->
            </div>
          </div>
         </div>
    </main>