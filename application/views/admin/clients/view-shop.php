<section id="content">
    <div class="container"> 
        <div class="tile">
            <div class="t-header">
                <div class="th-title"><?php echo "(".CURRENCY_SYMBOL.$employee_budget." ".lang('budget').") ".lang('view_shop'); ?></div>
            </div>
            <div class="t-body tb-padding">
                <div role="tabpanel">
                    <ul class="tab-nav tab-nav-right" role="tablist">
                        <li role="presentation" class="active"><a href="#within" aria-controls="within" role="tab" data-toggle="tab" aria-expanded="false"><?php echo lang('within_the_budget'); ?> (<?php echo addZero($within_the_budget_products['data']['total_records']+@$packages['data']['total_records']); ?>)</a></li>
                        <li role="presentation"><a href="#above" aria-controls="above" role="tab" data-toggle="tab" aria-expanded="true"><?php echo lang('above_the_budget'); ?> (<?php echo addZero($above_the_budget_products['data']['total_records']); ?>)</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="within">
                            <div class="row">
                                <?php if($within_the_budget_products['data']['total_records']) { foreach($within_the_budget_products['data']['records'] as $product) { ?>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="thumbnail">
                                            <img src="<?php echo $product['product_main_photo']; ?>" alt="product" class="img-responsive">
                                            <div class="caption">
                                                <h4><?php echo $product['category_name']; ?> - <?php echo $product['product_name']; ?></h4>
                                                <div class="clearfix"></div>
                                                <div class="m-t-10">
                                                    <div style="cursor:pointer;"><i class="heart fa <?php if($product['client_status'] == 'Liked') {echo "fa-heart";} else {echo "fa-heart-o";} ?>  heart-icon within_budget_products" data-shop-product-id="<?php echo $product['shop_product_id']; ?>-<?php echo ($product['client_status'] == 'Liked') ? 'Liked' : 'Deleted'; ?>"></i></div>
                                                </div>
                                                <div class="m-t-10">
                                                    <p><?php echo lang('quantities'); ?> : <?php echo $product['quantity']; ?></p> 
                                                    <p><?php echo lang('sold_quantity'); ?> : <?php echo $product['sold_quantity']; ?> </p> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } } ?>
                            </div>
                            <?php if($packages['data']['total_records']) { ?>
                                <hr/>
                                <div class="row">
                                    <div class="t-header">
                                        <div class="th-title"><?php echo lang('packages'); ?> (<?php echo addZero($packages['data']['total_records']); ?>)</div>
                                    </div>
                                    <?php foreach($packages['data']['records'] as $package) { ?>
                                        <div class="col-xs-6 col-md-2">
                                            <div class="thumbnail">
                                                <div class="images">
                                                    <?php foreach($package['products']['data']['records'] as $product) { ?>
                                                        <img src="<?php echo $product['product_main_photo']; ?>" alt="product" class="img-responsive">
                                                    <?php } ?>
                                                </div>
                                                <div class="caption">
                                                    <h4 title="<?php echo $package['no_of_products']." ".lang('products'); ?>"><?php echo $package['package_name']; ?> (<?php echo addZero($package['no_of_products']); ?>)</h4>
                                                    <p><?php echo lang('quantity').": ".$package['quantity']; ?></p>
                                                    <p><?php echo lang('sold_quantity').": ".$package['sold_quantity']; ?></p>
                                                    <div class="clearfix"></div>
                                                    <div class="m-t-10">
                                                        <div style="cursor:pointer;"><i class="heart fa <?php if($package['client_status'] == 'Liked') {echo "fa-heart";} else {echo "fa-heart-o";} ?>  heart-icon client_packages" data-shop-product-id="<?php echo $package['package_guid']; ?>@<?php echo ($package['client_status'] == 'Liked') ? 'Liked' : 'Deleted'; ?>"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if($within_the_budget_products['data']['total_records'] || $packages['data']['total_records']) { ?>
                                <center><button class="btn btn-success set-shop send-to-galtex col-sm-6 col-md-3" type="button"><?php echo lang('send_to_galtex'); ?></button></center>
                            <?php } ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="above">
                            <div class="row">
                                <?php if($above_the_budget_products['data']['total_records']) { foreach($above_the_budget_products['data']['records'] as $product) { ?>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="thumbnail">
                                            <img src="<?php echo $product['product_main_photo']; ?>" alt="product" class="img-responsive">
                                            <div class="caption">
                                                <h4><?php echo $product['category_name']; ?> - <?php echo $product['product_name']; ?></h4>
                                                <p>+ <?php echo CURRENCY_SYMBOL."".$product['above_budget_price']; ?></p>
                                                <div class="clearfix"></div>
                                                <div class="m-t-10">
                                                    <div style="cursor:pointer;"><i class="heart fa <?php if($product['client_status'] == 'Liked') {echo "fa-heart";} else {echo "fa-heart-o";} ?>  heart-icon above_budget_products" data-shop-product-id="<?php echo $product['shop_product_id']; ?>-<?php echo ($product['client_status'] == 'Liked') ? 'Liked' : 'Deleted'; ?>"></i></div>
                                                </div>
                                                <div class="m-t-10">
                                                    <p><?php echo lang('quantities'); ?> : <?php echo $product['quantity']; ?> </p>
                                                    <p><?php echo lang('sold_quantity'); ?> : <?php echo $product['sold_quantity']; ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } } ?>
                                </div>
                                <?php if($above_the_budget_products['data']['total_records']) { ?>
                                    <center><button class="btn btn-success set-shop send-to-galtex col-sm-6 col-md-3" type="button"><?php echo lang('send_to_galtex'); ?></button></center>
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Package View -->
<div class="modal" id="view_package" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-cyan m-b-20"> 
                <button type="button" class="close white-clr" data-dismiss="modal">X</button>
                <h4 class="modal-title white-clr"><?php echo lang('create_package'); ?></h4>
            </div>
            <div class="modal-body">               
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label"><?php echo lang('package_name'); ?></label>
                            <input type="text" class="form-control" name="package_name" placeholder="<?php echo lang('package_name'); ?>" maxlength="150" autocomplete="off">
                        </div>
                    </div>
                </div> 
                <hr> 
                <div class="row package-products">

                </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-primary submit-package"><?php echo lang('submit'); ?></button>
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        </div>
    </div>
</div>
</div>