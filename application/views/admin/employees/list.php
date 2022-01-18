<section id="content">
    <div class="container"> 
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                <div class="t-header">
                    <div class="th-title"><span class="zmdi zmdi-account zmdi-hc-fw" aria-hidden="true"></span> <?php echo lang('employees'); ?> (<?php echo addZero($members['data']['total_records']); ?>) &nbsp;&nbsp;
                    <div class="employees-actions">
                        <a href="javascript:void(0);" class="btn btn-primary upload-employee-btn"><?php echo lang('upload_employees'); ?></a>
                        <a href="<?php echo base_url(); ?>admin/employees/add-new" class="btn btn-primary"><?php echo lang('add_new_employee'); ?></a>
                    </div>
                    </div><br/>
                    <div class="current_games_section">
                        <table class="table table-striped table-bordered my-datatable">
                            <thead>
                                <tr>
                                    <th><?php echo lang('s_no'); ?></th>
                                    <th><?php echo lang('first_name'); ?></th>
                                    <th><?php echo lang('last_name'); ?></th>
                                    <th><?php echo lang('email'); ?></th>
                                    <th><?php echo lang('mobile_number'); ?></th>
                                    <th><?php echo lang('client'); ?></th>
                                    <th><?php echo lang('status'); ?></th>
                                    <th><?php echo lang('created_date'); ?></th>
                                    <th><?php echo lang('action'); ?></th>
                                </tr>
                            </thead>
                            <tbody> 
                            <?php if(!empty($members['data']['records'])){ $i = 1; foreach ($members['data']['records'] as $value) { ?>
                            <tr>
                                <td><?php echo addZero($i); ?> </td>
                                <td><?php echo $value['first_name']; ?></td>
                                <td><?php echo $value['last_name']; ?></td>
                                <td><?php echo $value['email']; ?></td>
                                <td><?php echo $value['phone_number']; ?></td>
                                <td><?php echo $value['client_first_name']." ".$value['client_last_name']; ?></td>
                                <td style="color:<?php echo getUserStatusColor($value['user_status']); ?>"><strong><?php echo $value['user_status']; ?></strong> </td>
                                <td><?php echo convertDateTime($value['created_date']); ?> </td>
                                <td>
                                    <button class="btn bg-cyan btn-icon view-user-details" data-user-guid="<?php echo $value['user_guid']; ?>" title="<?php echo lang('view_employee_details'); ?>"><i class="zmdi zmdi-eye"></i></button>
                                    <?php // if($this->user_type_id == 1){ ?>
                                    <button class="btn bg-orange btn-icon" onclick="window.location.href='edit/<?php echo $value['user_guid']; ?>'" title="<?php echo lang('edit_employee'); ?>"><i class="zmdi zmdi-edit"></i></button>
                                    <button class="btn btn-danger btn-icon" onclick="showConfirmationBox('<?php echo lang('are_you_sure'); ?>','<?php echo lang('are_you_sure_delete'); ?> <b style=   &quot;color:red; &quot;><?php echo $value['email']; ?></b> <?php echo lang('employee'); ?>?','<?php echo lang('yes'); ?>','<?php echo lang('no'); ?>','delete/<?php echo $value['user_guid']; ?>')" title="<?php echo lang('delete_employee'); ?>"><i class="zmdi zmdi-delete"></i></button>
                                <?php // } ?>
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
    <div class="modal" id="noAnimationCsv" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-blue m-b-20"> 
                    <button type="button" class="close white-clr" data-dismiss="modal">X</button>
                    <h4 class="modal-title white-clr"><?php echo lang('upload_employees'); ?></h4>
                </div>
                <form role="form" method="post" class="upload-employee-form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('select_client'); ?></label>
                                    <select class="form-control chosen-select" name="user_guid">
                                        <option value=""><?php echo lang('select_client'); ?></option> 
                                        <?php if($clients['data']['total_records'] > 0) { foreach($clients['data']['records'] as $value) { ?>
                                            <option value="<?php echo $value['user_guid']; ?>"><?php echo $value['first_name']." ".$value['last_name']; ?> (<?php echo $value['email']; ?>)</option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"><?php echo lang('upload_employees'); ?></label>
                                    <a class="product-download-btn" href="../../employee-csv-sample.csv" download ><?php echo lang('download_employee_csv_sample'); ?></a>
                                    <input type="file" class="form-control" name="employees_csv" onchange="validateFile(this,'csv')" accept=".csv">
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
                    <h4 class="modal-title white-clr"><?php echo lang('error')." ".lang('upload_employees'); ?></h4>
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

