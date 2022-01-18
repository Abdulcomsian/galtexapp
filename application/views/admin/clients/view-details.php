<div class="modal" id="noAnimation" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-cyan m-b-20"> 
                <button type="button" class="close white-clr" data-dismiss="modal">X</button>
                <h4 class="modal-title white-clr"><?php echo lang('view_client_details'); ?></h4>
            </div>
            <div class="modal-body">               
              <div class="row table-responsive">
                  <table class="table table-hover">
                       <tbody>
                          <tr>
                               <td><?php echo lang('company_name'); ?></td>
                               <td><?php echo $details['client_configs']['company_name']; ?></td>
                           </tr>
                           <tr>
                               <td><?php echo lang('contact_name'); ?></td>
                               <td><?php echo $details['client_configs']['contact_name']; ?></td>
                           </tr>
                           <tr>
                               <td><?php echo lang('contact_number'); ?></td>
                               <td><?php echo $details['client_configs']['contact_number']; ?></td>
                           </tr>
                           <tr>
                               <td><?php echo lang('shop_title'); ?></td>
                               <td><?php echo $details['client_configs']['shop_title']; ?></td>
                           </tr>
                           <tr>
                               <td><?php echo lang('theme_color'); ?></td>
                               <td style="color:<?php echo $details['client_configs']['theme_color']; ?>"><strong><?php echo lang('theme_color'); ?></strong></td>
                           </tr>
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
                               <td><?php echo lang('employee_budget'); ?></td>
                               <td><?php echo CURRENCY_SYMBOL.$details['employee_budget']; ?></td>
                           </tr>
                            <tr>
                               <td><?php echo lang('delivery_method'); ?></td>
                               <td><?php echo getDeliveryMethod($details['delivery_method']); ?></td>
                           </tr>
                           <tr>
                               <td><?php echo lang('status'); ?></td>
                               <td style="color:<?php echo getUserStatusColor($details['user_status']); ?>"><strong><?php echo getUserStatusName($details['user_status']); ?></strong> </td> 
                           </tr>
                           <tr>
                               <td><?php echo lang('deadline'); ?></td>
                               <td ><?php echo convertDateTime($details['deadline'],'dS F Y'); ?></td> 
                           </tr>
                           <tr>
                               <td><?php echo lang('created_date'); ?></td>
                               <td><?php echo convertDateTime($details['created_date']); ?></td>
                           </tr>
                           <tr>
                               <td><?php echo lang('company_logo'); ?></td>
                               <td><img width="100" height="100" src="<?php echo base_url().'uploads/company/'.$details['client_configs']['company_logo']; ?>" alt="company-logo" class="img-responsive img-thumbnail"></td>
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