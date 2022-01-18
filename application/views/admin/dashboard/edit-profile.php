<section id="content">
    <div class="container">
        <div class="tile">
            <div class="t-header">
                <div class="th-title"><?php echo lang('edit_profile'); ?></div>
            </div>
            <div class="t-body tb-padding">
                <form role="form" method="post" class="edit-profile-form">
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
                                <input  value="<?php echo $details['email'];?>" type="email" class="form-control" readonly placeholder="<?php echo lang('email_address'); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('mobile_number'); ?></label>
                                <input type="text" value="<?php echo $details['phone_number'];?>" class="form-control" readonly placeholder="<?php echo lang('mobile_number'); ?>" maxlength="10" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label"><?php echo lang('select_gender'); ?></label>
                                <select class="form-control chosen-select" name="gender">
                                    <option  value=""><?php echo lang('select_gender'); ?></option>
                                    <option <?php if($details['gender'] == "Male") echo "selected"; ?> value="Male"><?php echo lang('male'); ?></option>
                                    <option <?php if($details['gender'] == "Female") echo "selected"; ?> value="Female"><?php echo lang('female'); ?></option>
                                    <option <?php if($details['gender'] == "Other") echo "selected"; ?> value="Other"><?php echo lang('other'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 text-center">
                            <button class="btn btn-primary create_btn" ><?php echo lang('update'); ?></button>
                            <button type="button" class="btn btn-danger" onclick="window.location.href='dashboard'"><?php echo lang('cancel'); ?></button>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>