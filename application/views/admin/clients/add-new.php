<section id="content">
    <div class="container"> 
        <div class="tile">
            <div class="t-header">
                <div class="th-title"><?php echo lang('add_new_client'); ?></div>
            </div>
            <div class="t-body tb-padding">
                <form role="form" method="post" class="add-new-client-form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('company_name'); ?></label>
                                <input type="text" class="form-control" name="company_name" placeholder="<?php echo lang('company_name'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('contact_name'); ?></label>
                                <input type="text" class="form-control" name="contact_name" placeholder="<?php echo lang('contact_name'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('contact_number'); ?></label>
                                <input type="text" class="form-control" name="contact_number" placeholder="<?php echo lang('contact_number'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('employee_budget'); ?> (<?php echo CURRENCY_SYMBOL; ?>)</label>
                                <input type="text" class="form-control validate-no" name="employee_budget" placeholder="<?php echo lang('employee_budget'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('client')." ".lang('first_name'); ?></label>
                                <input type="text" class="form-control" name="first_name" placeholder="<?php echo lang('first_name'); ?>" maxlength="30" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('client')." ".lang('last_name'); ?></label>
                                <input type="text" class="form-control" name="last_name" placeholder="<?php echo lang('last_name'); ?>" maxlength="30" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('email_address'); ?></label>
                                <input type="email" class="form-control" name="email" placeholder="<?php echo lang('email_address'); ?>" maxlength="250" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('password'); ?></label>
                                <input type="text" class="form-control" name="password" placeholder="<?php echo lang('password'); ?>" autocomplete="off" value="<?php echo mt_rand(); ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('shop_title'); ?></label>
                                <input type="text" class="form-control" name="shop_title" placeholder="<?php echo lang('shop_title'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('theme_color'); ?></label>
                                <input type="color" class="form-control" name="theme_color" placeholder="<?php echo lang('theme_color'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('delivery_method'); ?></label>
                                <select class="form-control chosen-select" name="delivery_method">
                                    <option value=""><?php echo lang('delivery_method'); ?></option>
                                    <option value="Pickup"><?php echo lang('pickup'); ?></option>
                                    <option value="Door to Door"><?php echo lang('door_to_door'); ?></option>
                                    <option value="Both"><?php echo lang('both'); ?> (<?php echo lang('pickup')." & ".lang('door_to_door'); ?>)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('deadline'); ?></label>
                                <input type="text" id="deadline" class="form-control" name="deadline" placeholder="<?php echo lang('deadline'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label class="control-label"><?php echo lang('company_logo'); ?></label><br/>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="line-height: 150px;"></div>
                                <div>
                                    <span class="btn btn-info btn-file">
                                        <span class="fileinput-new"><?php echo lang('select_image'); ?></span>
                                        <span class="fileinput-exists"><?php echo lang('change'); ?></span>
                                        <input type="hidden" value=""><input type="file" name="company_logo">
                                    </span>
                                    <a href="javascript:void(0);" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"><?php echo lang('remove'); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8 pickup-address-section hidden">
                            <label class="control-label"><?php echo lang('pickup_addresses'); ?></label><br/>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="pickup_addresses[]" placeholder="<?php echo lang('pickup_address'); ?>" maxlength="500" autocomplete="off">
                                    </div>
                                    <div class="col-sm-4">
                                        <a href="javascript:void(0);" style="width:80px;" class="btn btn-primary add-more-address"><?php echo lang('add_more'); ?></a>
                                    </div>
                                </div>
                            <div class="more-pickup-address">
                                <div class="row m-t-10"><div class="col-sm-8"><input type="text" class="form-control" name="pickup_addresses[]" placeholder="<?php echo lang('pickup_address'); ?>" maxlength="500" autocomplete="off"></div><div class="col-sm-4"><a href="javascript:void(0);" style="width:80px;" class="btn btn-danger remove-address"><?php echo lang('remove'); ?></a></div></div>
                                <div class="row m-t-10"><div class="col-sm-8"><input type="text" class="form-control" name="pickup_addresses[]" placeholder="<?php echo lang('pickup_address'); ?>" maxlength="500" autocomplete="off"></div><div class="col-sm-4"><a href="javascript:void(0);" style="width:80px;" class="btn btn-danger remove-address"><?php echo lang('remove'); ?></a></div></div>
                                <div class="row m-t-10"><div class="col-sm-8"><input type="text" class="form-control" name="pickup_addresses[]" placeholder="<?php echo lang('pickup_address'); ?>" maxlength="500" autocomplete="off"></div><div class="col-sm-4"><a href="javascript:void(0);" style="width:80px;" class="btn btn-danger remove-address"><?php echo lang('remove'); ?></a></div></div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 text-center m-t-20">
                            <button class="btn btn-primary" ><?php echo lang('submit'); ?></button>
                            <button type="button" class="btn btn-danger reset-btn"><?php echo lang('reset'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>