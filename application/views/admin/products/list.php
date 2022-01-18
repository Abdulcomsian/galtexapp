<section id="content" data-page="products-list">
    <div class="container"> 
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="zmdi zmdi-view-web zmdi-hc-fw" aria-hidden="true"></span> <?php echo lang('products'); ?> (<?php echo addZero($products['data']['total_records']); ?>) &nbsp;&nbsp;

                            <div class="products-actions">
                                <a href="javascript:void(0);" class="btn btn-primary upload-tasks-btn"><?php echo lang('upload_products'); ?></a>
                                <a href="<?php echo base_url(); ?>admin/products/add-new" class="btn btn-primary"><?php echo lang('add_new_product'); ?></a>
                            </div>
                    </div><br/>
                    <div class="current_games_section">
                        <table class="table table-striped table-bordered my-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo lang('s_no'); ?></th>
                                    <th><?php echo lang('product_name'); ?></th>
                                    <th><?php echo lang('category'); ?></th>
                                    <th><?php echo lang('price_range'); ?></th>
                                    <th><?php echo lang('main_photo'); ?></th>
                                    <th><?php echo lang('created_date'); ?></th>
                                    <th><?php echo lang('action'); ?></th>
                                </tr> 
                            </thead>
                            <tbody> 
                            <?php if(!empty($products['data']['records'])){ $i = 1; foreach ($products['data']['records'] as $value) { ?>
                            <tr>
                                <td><?php echo addZero($i); ?> </td>
                                <td><?php echo $value['product_name']; ?></td>
                                <td><?php echo $value['category_name']; ?></td>
                                <td><?php echo $value['min_price']."-".$value['max_price']; ?></td>
                                <td><a href="<?php echo $value['product_main_photo']; ?>" target="_blank"><img src="<?php echo $value['product_main_photo']; ?>" class="img-responsive img-thumbnail" width="150px" height="150px"></a></td>
                                <td><?php echo convertDateTime($value['created_date']); ?> </td>
                                <td>
                                   <button class="btn bg-cyan btn-icon" onclick="window.location.href='details/<?php echo $value['product_guid']; ?>'" title="<?php echo lang('view_product_details'); ?>"><i class="zmdi zmdi-eye"></i></button>
                                    <button class="btn bg-orange btn-icon" onclick="window.location.href='edit/<?php echo $value['product_guid']; ?>'" title="<?php echo lang('edit_product'); ?>"><i class="zmdi zmdi-edit"></i></button>
                                    <button class="btn btn-danger btn-icon" onclick="showConfirmationBox('<?php echo lang('are_you_sure'); ?>','<?php echo lang('are_you_sure_delete'); ?> <b style=   &quot;color:red; &quot;></b> <?php echo lang('product'); ?>?','<?php echo lang('yes'); ?>','<?php echo lang('no'); ?>','delete/<?php echo $value['product_guid']; ?>')" title="<?php echo lang('delete_product'); ?>"><i class="zmdi zmdi-delete"></i></button>
                                </td>
                           </tr>
                            <?php $i++; } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>        
        </div>
    </div>
    <div class="modal" id="noAnimation" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-blue m-b-20"> 
                    <button type="button" class="close white-clr" data-dismiss="modal">X</button>
                    <h4 class="modal-title white-clr"><?php echo lang('upload_products'); ?></h4>
                </div>
                <form role="form" method="post" class="upload-product-form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('upload_products'); ?></label>
                                    <a class="product-download-btn" href="../../products-csv-sample.csv" download ><?php echo lang('download_products_csv_sample'); ?></a>
                                    <input type="file" class="form-control" name="products_csv" onchange="validateFile(this,'csv')" accept=".csv">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary"><?php echo lang('upload'); ?></button>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="task_errors" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-blue m-b-20"> 
                    <button type="button" class="close white-clr" data-dismiss="modal">X</button>
                    <h4 class="modal-title white-clr"><?php echo lang('error')." ".lang('upload_products'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success success-area hidden" role="alert">
                        <strong></strong>
                    </div>
                    <div class="current_games_section">
                        <table class="table table-striped table-bordered error-datatable hidden">
                            <thead>
                                <tr>
                                    <th><?php echo lang('s_no'); ?></th>
                                    <th><?php echo lang('error_descprition'); ?></th>
                                </tr>
                            </thead>
                            <tbody> 

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary download-report"><?php echo lang('download_report'); ?></button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" onclick="window.location.reload();"><?php echo lang('close'); ?></button>
                </div>
            </div>
        </div>
    </div>
</section>

