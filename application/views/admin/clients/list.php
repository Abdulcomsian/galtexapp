<section id="content">
    <div class="container"> 
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="zmdi zmdi-account zmdi-hc-fw" aria-hidden="true"></span> <?php echo lang('clients'); ?> (<?php echo addZero($members['data']['total_records']); ?>)
                            <a href="<?php echo base_url(); ?>admin/clients/add-new" class="btn btn-primary pull-right admin-right-btn"><?php echo lang('add_new_client'); ?></a>
                    </div><br/>
                    <div class="current_games_section">
                        <table class="table table-striped table-bordered my-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo lang('s_no'); ?></th>
                                    <th><?php echo lang('company_name'); ?></th>
                                    <th><?php echo lang('contact_name'); ?></th>
                                    <th><?php echo lang('email'); ?></th>
                                    <th><?php echo lang('employee_budget'); ?></th>
                                    <th><?php echo lang('delivery_method'); ?></th>
                                    <th><?php echo lang('status'); ?></th>
                                    <th><?php echo lang('created_date'); ?></th>
                                    <th><?php echo lang('set_shop'); ?></th>
                                    <th><?php echo lang('export_orders'); ?></th>
                                    <th><?php echo lang('action'); ?></th>
                                </tr>
                            </thead>
                            <tbody> 
                            <?php if(!empty($members['data']['records'])){ $i = 1; foreach ($members['data']['records'] as $value) { ?>
                            <tr>
                                <td><?php echo addZero($i); ?> </td>
                                <td><?php echo $value['client_configs']['company_name']; ?></td>
                                <td><?php echo $value['client_configs']['contact_name']; ?></td>
                                <td><?php echo $value['email']; ?></td>
                                <td><?php echo CURRENCY_SYMBOL.$value['employee_budget']; ?></td>
                                <td><?php echo getDeliveryMethod($value['delivery_method']); ?></td>
                                <td style="color:<?php echo getUserStatusColor($value['user_status']); ?>"><strong><?php echo getUserStatusName($value['user_status']); ?></strong> </td>
                                <td><?php echo convertDateTime($value['created_date']); ?> </td>
                                <td><a href="shop/<?php echo $value['user_guid']; ?>" class="btn btn-success"><?php echo lang('set_shop'); ?></</a></td>
                                <td>
                                    <a href="export_employees_orders?client_id=<?php echo $value['user_id']; ?>" class="btn btn-primary"><?php echo lang('export_employees_orders'); ?></</a>

                                    <a href="export_products_orders?client_id=<?php echo $value['user_id']; ?>" class="btn btn-primary m-t-10"><?php echo lang('export_products_orders'); ?></</a>
                                </td>
                                <td>
                                    <?php if(($value['delivery_method'] == 'Pickup' || $value['delivery_method'] == 'Both')){ ?>
                                        <button class="btn bg-green btn-icon view-pickup-address" data-user-guid="<?php echo $value['user_guid']; ?>" title="<?php echo lang('pickup_address'); ?>"><i class="zmdi zmdi-my-location"></i></button>
                                    <?php } ?>
                                    <button class="btn bg-cyan btn-icon view-user-details" data-user-guid="<?php echo $value['user_guid']; ?>" title="<?php echo lang('view_client_details'); ?>"><i class="zmdi zmdi-eye"></i></button>
                                    <button class="btn bg-orange btn-icon" onclick="window.location.href='edit/<?php echo $value['user_guid']; ?>'" title="<?php echo lang('edit_client'); ?>"><i class="zmdi zmdi-edit"></i></button>
                                    <button class="btn btn-danger btn-icon" onclick="showConfirmationBox('<?php echo lang('are_you_sure'); ?>','<?php echo lang('are_you_sure_delete'); ?> <b style=   &quot;color:red; &quot;><?php echo $value['email']; ?></b> <?php echo lang('client'); ?>?','<?php echo lang('yes'); ?>','<?php echo lang('no'); ?>','delete/<?php echo $value['user_guid']; ?>')" title="<?php echo lang('delete_client'); ?>"><i class="zmdi zmdi-delete"></i></button>
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
</section>

