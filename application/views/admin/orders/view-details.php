<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                        <div class="th-title"><span class="zmdi zmdi-view-web zmdi-hc-fw" aria-hidden="true"></span> <?php echo lang('view_order_details'); ?>
                        <a href="<?php echo base_url(); ?>admin/orders/list" class="btn btn-primary pull-right admin-right-btn"><?php echo lang('back_to_order_list'); ?></a>
                    </div>
                    <br/>
                    <div class="current_games_section">
                          <table id="example" class="table">
                            <tr>
                                <td><?php echo lang('order_id'); ?></td>
                                <td>OID-<?php echo $details['order_id']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('employee_name'); ?></td>
                                <td><?php echo $details['employee_name']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('client_name'); ?></td>
                                <td><?php echo $details['client_name']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('amount'); ?></td>
                                <td><?php echo CURRENCY_SYMBOL.$details['order_amount']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('used_credits'); ?></td>
                                <td><?php echo CURRENCY_SYMBOL.$details['used_credits']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('credit_card_amount'); ?></td>
                                <td><?php echo CURRENCY_SYMBOL.$details['credit_card_amount']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('address_mode'); ?></td>
                                <td><?php echo getDeliveryMethod($details['address_mode']); ?></td>
                            </tr>
                            <?php if($details['address_mode'] == 'Pickup') { ?>

                                <tr>
                                    <td><?php echo lang('pickup_address'); ?></td>
                                    <td><?php echo $details['pickup_address']; ?></td>
                                </tr>

                            <?php } else { ?>

                                <tr>
                                    <td><?php echo lang('city'); ?></td>
                                    <td><?php echo $details['city']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('apartment'); ?></td>
                                    <td><?php echo $details['apartment']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('street_house'); ?></td>
                                    <td><?php echo $details['street_house']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo lang('postal_code'); ?></td>
                                    <td><?php echo $details['postal_code']; ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><?php echo lang('created_date'); ?></td>
                                <td style="width:1200px;"><?php echo convertDateTime($details['created_date']); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('order_status'); ?></td>
                                <td><?php echo getOrderStatus($details['order_status']); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo lang('payment_status'); ?></td>
                                <td><?php echo ($details['credit_card_amount'] > 0) ? getPaymentStatus($details['payment_status']) : 'N/A'; ?></td>
                            </tr>
                            <?php if($details['order_status'] == 'Cancelled') { ?>

                                <tr>
                                    <td><?php echo lang('cancelled_date'); ?></td>
                                    <td style="width:1200px;"><?php echo convertDateTime($details['cancelled_date']); ?></td>
                                </tr>

                            <?php } ?>
                          </table>
                          <table class="table">
                            <thead>
                                <th><?php echo lang('s_no'); ?></th>
                                <th><?php echo lang('product_package_name'); ?></th>
                                <th><?php echo lang('type'); ?></th>
                                <th><?php echo lang('quantity'); ?></th>
                                <th><?php echo lang('amount'); ?> (<?php echo CURRENCY_SYMBOL; ?>)</th>
                            </thead>
                            <tbody>
                                <?php foreach ($details['order_product_details'] as $key => $value){?>
                                    <tr>
                                        <td style="text-align:center"><?php echo addZero($key+1); ?> </td>
                                        <td style="text-align:center"><?php echo $value['product_package_name'] ?></td>
                                        <td style="text-align:center"><?php echo $value['type'] ?></td>
                                        <td style="text-align:center"><?php echo $value['quantity'] ?></td>
                                        <td style="text-align:center"><?php echo CURRENCY_SYMBOL.$value['amount'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                      </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</section>
