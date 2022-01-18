<div class="modal" id="noAnimation" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-cyan m-b-20"> 
                <button type="button" class="close white-clr" data-dismiss="modal">X</button>
                <h4 class="modal-title white-clr"><?php echo lang('view_employee_details'); ?></h4>
            </div>
            <div class="modal-body">               
              <div class="row table-responsive">
                  <table class="table table-hover">
                       <tbody>
                          <tr>
                               <td><?php echo lang('first_name'); ?></td>
                               <td><?php echo $details['first_name']; ?></td>
                           </tr>
                           <tr>
                               <td><?php echo lang('last_name'); ?></td>
                               <td><?php echo $details['last_name']; ?></td>
                           </tr>
                           <tr>
                               <td><?php echo lang('email_address'); ?></td>
                               <td><?php echo $details['email']; ?></td>
                           </tr>
                            <tr>
                               <td><?php echo lang('mobile_number'); ?></td>
                               <td><?php echo $details['phone_number']; ?></td>
                           </tr>
                            <tr>
                               <td><?php echo lang('client'); ?></td>
                               <td><?php echo $details['client_first_name']." ".$details['client_last_name']; ?></td>
                           </tr>
                           <tr>
                               <td><?php echo lang('status'); ?></td>
                               <td style="color:<?php echo getUserStatusColor($details['user_status']); ?>"><strong><?php echo getUserStatusName($details['user_status']); ?></strong> </td> 
                           </tr>
                           <tr>
                               <td><?php echo lang('created_date'); ?></td>
                               <td><?php echo convertDateTime($details['created_date']); ?></td>
                           </tr>
                       </tbody>
                  </table>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
        </div>
    </div>
</div>
</div>