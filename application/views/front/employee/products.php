<main class="main_content">
    <div class="cardBlur">
    <section id="card">
        <div class="inner_banner_sec">
            <div class="innerbanner_cap text-center">
                <div class="container">
                    <div class="watermark_text rounded">
                        <!-- <h1 class="head_1"><?php echo lang('products'); ?></h1> -->
                        <p class="watermark wow zoomIn text-white" data-wow-delay="0.4s"><?php echo $this->session->userdata('webuserdata')['client_configs']['shop_title']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="welcomeText">
                        <p>Welcome User!,<br> You are welcome to pick the present that best suits you.<br> You are even able to upgrade it if you want.</p>
                    </div>
    </section>
    </div>
    <div class="content_main_sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-lg-4 col-xl-3 mobileHide">
                    <div class="cat_sidebar">
                        <div class="sidebar_block">
                            <h4 class="sidebar_head wow fadeInDown"><?php echo lang('budget_categories'); ?></h4>
                            <ul class="list-unstyled catlist_item">
                                <li class="wow fadeInLeft" data-wow-delay="0.3s">
                                    <input type="checkbox" id="chk_Apple" value="within" name="budget_category[]" class="budget-categories" <?php if(in_array('within', $budget_categories)) echo "checked"; ?> />
                                    <label for="chk_Apple">
                                        <span><i class="fas fa-check"></i></span> <?php echo lang('within_the_budget'); ?>
                                    </label>
                                </li>
                                <li class="wow fadeInLeft" data-wow-delay="0.6s">
                                    <input type="checkbox" id="chk_Canon" value="above" name="budget_category[]" class="budget-categories" <?php if(in_array('above', $budget_categories)) echo "checked"; ?> />
                                    <label for="chk_Canon">
                                        <span><i class="fas fa-check"></i></span> <?php echo lang('above_the_budget'); ?>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="sidebar_block">
                            <h4 class="sidebar_head wow fadeInDown"><?php echo lang('main_categories'); ?></h4>
                            <ul class="list-unstyled catlist_item">
                                <?php if($categories['data']['total_records']) { foreach($categories['data']['records'] as $category) { ?>
                                <li class="wow fadeInLeft" data-wow-delay="0.3s">
                                    <input type="checkbox" id="category_<?php echo $category['category_guid']; ?>" name="main_category[]" value="<?php echo $category['category_guid']; ?>" <?php if(in_array($category['category_guid'], $main_categories)) echo "checked"; ?> class="main_categories" />
                                    <label for="category_<?php echo $category['category_guid']; ?>">
                                        <span><i class="fas fa-check"></i></span> <?php echo $category['category_name']; ?>
                                    </label>
                                </li>
                                <?php } } ?>
                            </ul>
                        </div>
                        <!-- <div class="sidebar_block hide_mobile">
                      <div class="new_arrival wow fadeInUp" data-wow-delay="0.4s">
                         <img src="images/new_arrival.jpg">
                         <h2 class="font_merienda">New <span>Arrival</span></h2>
                         <a href="#">Shop Now</a>
                      </div>
                   </div> -->
                    </div>
                </div>
                <div class="col-md-8 col-lg-8 col-xl-9">
                    <?php if(!empty($within_the_budget_products) || !empty($packages)) { ?>

                        <div class="list_row packages_por row">
                            <?php if(!empty($packages)) { ?>
                                <div class="col-sm-12">
                                    <h2 class="head_common2 wow fadeInRight"><?php echo lang('packages'); ?> (<?php echo addZero($packages['data']['total_records']); ?>)</h2>
                                </div>
                            <?php } ?>
                            <?php foreach($packages['data']['records'] as $package) { ?>
                                <div class="prod_coll col-xs-6 col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                                    <div class="proimage">
                                        <div class="pro_img_box pro_package_slider">
                                            <?php foreach($package['products']['data']['records'] as $package_product) { ?>
                                                <div class="pro_pack_slide">
                                                    <a href="<?php echo base_url(); ?>package/details/<?php echo $package['package_guid']; ?>"><img src="<?php echo $package_product['product_main_photo']; ?>" /></a>
                                                    <div class="hover_box">
                                                        <?php $package_cart = is_product_into_cart($package['package_guid']); if($package_cart['is_added_into_cart'] > 0) { ?>
                                                            <a href="../employees/cart" class="add_cart"><?php echo lang('go_to_cart'); ?></a>
                                                        <?php } else { ?>

                                                            <?php if($package['remaining_quantity'] > 0) { ?>

                                                                <a href="javascript:void(0);" data-type="package" data-guid="<?php echo $package['package_guid']; ?>" class="add_cart add-to-cart"><?php echo lang('add_to_cart'); ?></a>

                                                            <?php } else { ?>

                                                                <a href="javascript:void(0);" style="color:red;" class="add_cart"><?php echo lang('out_of_stock'); ?></a>

                                                            <?php } ?>
                                                        
                                                        <?php } ?>
                                                    </div>

                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="pro_bottom clerfix">
                                            <div class="product_name">
                                                <a href="<?php echo base_url(); ?>package/details/<?php echo $package['package_guid']; ?>"><?php echo $package['package_name']; ?></a>
                                            </div>
                                            <div class="product_price">
                                                <p>(<?php echo addZero($package['no_of_products']); ?> <?php echo lang('products'); ?>)</p>
                                                <?php if($package['remaining_quantity'] < REMAINING_PRODUCTS_QUANTITY_LIMIT) { ?>
                                                    <p><?php echo lang('remaining_quantity'); ?> <?php echo $package['remaining_quantity']; ?> </p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="list_row row">
                        <div class="col-sm-12">
                            <h2 class="head_common2 wow fadeInRight"><?php echo lang('products'); ?> (<?php echo addZero(@$within_the_budget_products['data']['total_records'] + @$above_the_budget_products['data']['total_records']); ?>)</h2>
                        </div>
                        <?php foreach($within_the_budget_products['data']['records'] as $product) { ?>
                            <div class="prod_coll col-xs-6 col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                                <div class="proimage">
                                    <div class="pro_img_box">
                                        <a href="<?php echo base_url(); ?>product/details/<?php echo $product['product_guid']; ?>"><img src="<?php echo $product['product_main_photo']; ?>" /></a>
                                        <!-- <a href="<?php echo base_url(); ?>product/details/<?php echo $product['product_guid']; ?>"><img src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTN8fHByb2R1Y3RzfGVufDB8fDB8fA%3D%3D&w=1000&q=80" /></a> -->
                                        <div class="hover_box">
                                            <?php $product_cart = is_product_into_cart($product['product_guid']); if($product_cart['is_added_into_cart'] > 0) { ?>
                                                <a href="../employees/cart" class="add_cart"><?php echo lang('go_to_cart'); ?></a>
                                            <?php } else { ?>

                                                <?php if($product['remaining_quantity'] > 0) { ?>

                                                    <a href="javascript:void(0);" data-type="product" data-guid="<?php echo $product['product_guid']; ?>" class="add_cart add-to-cart"><?php echo lang('add_to_cart'); ?></a>

                                                <?php } else { ?>

                                                    <a href="javascript:void(0);" style="color:red;" class="add_cart"><?php echo lang('out_of_stock'); ?></a>

                                                <?php } ?>
                                            
                                            <?php } ?>
                                        </div>
                                        <p class="productPrice">
                                            200USD
                                        </p>
                                    </div>
                                    <div class="pro_bottom clerfix">
                                        <div class="product_name">
                                            <a href="<?php echo base_url(); ?>product/details/<?php echo $product['product_guid']; ?>"><?php echo $product['product_name']; ?></a>
                                        </div>
                                        <div class="product_description">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec maximus enim non mattis.</p>
                                        </div>
                                        <!-- <div class="product_price">
                                            <p><?php echo $product['category_name']; ?> </p>
                                            <?php if($product['remaining_quantity'] < REMAINING_PRODUCTS_QUANTITY_LIMIT) { ?>
                                                <p><?php echo lang('remaining_quantity'); ?> <?php echo $product['remaining_quantity']; ?> </p>
                                            <?php } ?>
                                        </div> -->
                                        <div class="readMore">
                                            <a href="<?php echo base_url(); ?>product/details/<?php echo $product['product_guid']; ?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> More Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php foreach($above_the_budget_products['data']['records'] as $product) { ?>
                            <div class="prod_coll col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                                <div class="proimage">
                                    <div class="pro_img_box">
                                        <a href="<?php echo base_url(); ?>product/details/<?php echo $product['product_guid']; ?>"><img src="<?php echo $product['product_main_photo']; ?>" /></a>
                                        <!-- <a href="<?php echo base_url(); ?>product/details/<?php echo $product['product_guid']; ?>"><img src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTN8fHByb2R1Y3RzfGVufDB8fDB8fA%3D%3D&w=1000&q=80" /></a> -->
                                        <div class="hover_box">
                                            <?php $product_cart = is_product_into_cart($product['product_guid']); if($product_cart['is_added_into_cart'] > 0) { ?>
                                                <a href="../employees/cart" class="add_cart"><?php echo lang('go_to_cart'); ?></a>
                                            <?php } else { ?>

                                            <?php if($product['remaining_quantity'] > 0) { ?>
                                                <a href="javascript:void(0);" data-type="product" data-guid="<?php echo $product['product_guid']; ?>" class="add_cart add-to-cart"><?php echo lang('add_to_cart'); ?></a>
                                            <?php } else { ?>
                                                <a href="javascript:void(0);" style="color:red;" class="add_cart"><?php echo lang('out_of_stock'); ?></a>
                                            <?php } } ?>
                                        </div>
                                        <p class="productPrice">
                                            200USD
                                        </p>
                                    </div>
                                    <div class="pro_bottom clerfix">
                                        <div class="product_name">
                                            <a href="<?php echo base_url(); ?>product/details/<?php echo $product['product_guid']; ?>"><?php echo $product['product_name']; ?></a>
                                        </div>
                                        <div class="product_description">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec maximus enim non mattis.</p>
                                        </div>
                                        <!-- <div class="product_price">
                                            <p><?php echo $product['category_name']; ?> (+ <?php echo CURRENCY_SYMBOL.$product['above_budget_price']; ?>) </p>
                                            <?php if($product['remaining_quantity'] < REMAINING_PRODUCTS_QUANTITY_LIMIT) { ?>
                                                <p><?php echo lang('remaining_quantity'); ?> <?php echo $product['remaining_quantity']; ?> </p>
                                            <?php } ?>
                                        </div> -->
                                        <div class="readMore">
                                        <a href="<?php echo base_url(); ?>product/details/<?php echo $product['product_guid']; ?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> More Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- <div class="pagination_main">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <li class="page-item disabled prev">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><img src="<?php echo base_url(); ?>assets/images/arrow-left.png" /></a>
                        </li>
                        <li class="page-item"><a class="page-link active" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item next">
                            <a class="page-link" href="#"><img src="<?php echo base_url(); ?>assets/images/arrow-right.png" /></a>
                        </li>
                    </ul>
                </nav>
            </div> -->
        </div>
    </div>
</main>
