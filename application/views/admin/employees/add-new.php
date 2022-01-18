<section id="content">
    <div class="container"> 
        <div class="tile">
            <div class="t-header">
                <div class="th-title"><?php echo lang('add_new_employee'); ?></div>
            </div>
            <div class="t-body tb-padding">
                <form role="form" method="post" class="add-new-employee-form">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('first_name'); ?></label>
                                <input type="text" class="form-control" name="first_name" placeholder="<?php echo lang('first_name'); ?>" maxlength="30" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('last_name'); ?></label>
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
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('mobile_number'); ?></label>
                                <input type="text" class="form-control" name="phone_number" placeholder="<?php echo lang('mobile_number'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('select_client'); ?></label>
                                <select class="form-control chosen-select" name="client_guid">
                                    <option value=""><?php echo lang('select_client'); ?></option>
                                    <?php if($clients['data']['total_records'] > 0) { foreach($clients['data']['records'] as $value) { ?>
                                        <option value="<?php echo $value['user_guid']; ?>"><?php echo $value['first_name']." ".$value['last_name']; ?> (<?php echo $value['email']; ?>)</option>
                                    <?php } } ?>
                                </select>
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