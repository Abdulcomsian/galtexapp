<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="zmdi zmdi-view-web zmdi-hc-fw" aria-hidden="true"></span> <?php echo lang('view_product_details'); ?>
                        <a href="<?php echo base_url(); ?>admin/products/list" class="btn btn-primary pull-right admin-right-btn"><?php echo lang('back_to_product_list'); ?></a>
                    </div>
                    <br/>
                    <div class="current_games_section">
                          <table id="example" class="table">
                            <tr>
                                <td><?php echo lang('product_name'); ?></td>
                                <td><?php echo $details['product_name']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('category'); ?></td>
                                <td><?php echo $details['category_name']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('price_range'); ?> (<?php echo CURRENCY_SYMBOL; ?>)</td>
                                <td><?php echo $details['min_price']."-".$details['max_price']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('warranty'); ?></td>
                                <td><?php echo $details['warranty']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('product_descprition'); ?></td>
                                <td><?php echo $details['product_descprition']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('created_date'); ?></td>
                                <td style="width:1200px;"><?php echo convertDateTime($details['created_date']); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('main_photo'); ?></td>
                                <td><div class="lightbox row"><a href="<?php echo $details['product_main_photo']; ?>" class="col-sm-2 col-xs-6"><img src="<?php echo $details['product_main_photo']; ?>" alt="product-img"></a></div></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('gallery_images'); ?></td>
                                <td>
                                    <div class="lightbox row">
                                    <?php if(!empty($details['product_gallery_images'])){ foreach ($details['product_gallery_images'] as $value) { ?>
                                        <a class="col-sm-2 col-xs-6" href="<?php echo base_url().'uploads/products/'.$value; ?>">
                                            <img src="<?php echo base_url().'uploads/products/'.$value; ?>" alt="product-img">
                                        </a>
                                    <?php } } ?>
                                    </div>
                                </td>
                            </tr>
                          </table>
                      </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</section>
