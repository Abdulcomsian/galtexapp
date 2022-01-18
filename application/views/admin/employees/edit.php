<section id="content">
    <div class="container">
        <div class="tile">
            <div class="t-header">
                <div class="th-title"><?php echo lang('edit_employee'); ?></div>
            </div>
            <div class="t-body tb-padding">
                <form role="form" method="post" class="edit-employee-form">
                    <input type="hidden" name="user_guid" value="<?php echo $details['user_guid']; ?>">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('first_name'); ?></label>
                                <input type="text" value="<?php echo $details['first_name'];?>" class="form-control" name="first_name" placeholder="<?php echo lang('first_name'); ?>" maxlength="30" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('last_name'); ?></label>
                                <input type="text" value="<?php echo $details['last_name'];?>" class="form-control" name="last_name" placeholder="<?php echo lang('last_name'); ?>" maxlength="30" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('email_address'); ?></label>
                                <input type="email" class="form-control" value="<?php echo $details['email'];?>" name="email">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('mobile_number'); ?></label>
                                <input type="text" value="<?php echo $details['phone_number'];?>" class="form-control" name="phone_number">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('password'); ?></label>
                                <input type="text" class="form-control" name="password" placeholder="<?php echo lang('password'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('select_client'); ?></label>
                                <select class="form-control chosen-select">
                                    <?php if($clients['data']['total_records'] > 0) { foreach($clients['data']['records'] as $value) { ?>
                                        <option value="<?php echo $value['user_guid']; ?>" <?php if($details['user_guid'] == $value['user_guid']) echo "selected"; ?>><?php echo $value['first_name']." ".$value['last_name']; ?> (<?php echo $value['email']; ?>)</option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('select_status'); ?></label>
                                <select class="form-control chosen-select" name="user_status">
                                    <option  value=""><?php echo lang('select_status'); ?></option>
                                    <option <?php if($details['user_status'] == "Pending") echo "selected"; ?> value="Pending"><?php echo lang('pending'); ?></option>
                                    <option <?php if($details['user_status'] == "Verified") echo "selected"; ?> value="Verified"><?php echo lang('verified'); ?></option>
                                    <option <?php if($details['user_status'] == "Blocked") echo "selected"; ?> value="Blocked"><?php echo lang('blocked'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 text-center m-t-20">
                            <button class="btn btn-primary" ><?php echo lang('submit'); ?></button>
                             <button type="button" class="btn btn-danger" onclick="window.location.href='list'"><?php echo lang('cancel'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>