<div class="modal" id="noAnimation" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-cyan m-b-20"> 
                <button type="button" class="close white-clr" data-dismiss="modal">X</button>
                <h4 class="modal-title white-clr"><?php echo $details['client_configs']['company_name']." - ".lang('pickup_addresses'); ?></h4>
            </div>
            <div class="modal-body">               
              <div class="row table-responsive">
                  <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?php echo lang('s_no'); ?></th>
                                <th><?php echo lang('pickup_address'); ?></th>
                            </tr>
                        </thead>
                       <tbody>
                        <?php for ($i=0; $i < count($address); $i++) { ?>
                           <tr>
                            <td><?php echo addZero($i+1); ?> </td>
                            <td><?php echo $address[$i]['pickup_address']; ?></td>
                        <?php } ?>
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