		<footer id="footer">
		    <?php echo lang('copyright'); ?> © <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>
		</footer>

    <div id="modal-section"></div>

    <!--  Error & Success Messages -->
    <script type="text/javascript">
    $(document).ready(function(){
      <?php if($this->session->flashdata('error')){ ?>
        showToaster('error',"<?php echo lang('error'); ?>","<?php echo $this->session->flashdata('error') ?>")
      <?php } ?>
      <?php if($this->session->flashdata('success')){ ?>
        showToaster('success',"<?php echo lang('success'); ?>","<?php echo $this->session->flashdata('success') ?>")
      <?php } ?>
    });

    /* Manage JS Language Fields */
    var success = "<?php echo lang('success'); ?>";
    var error = "<?php echo lang('error'); ?>";
    var info = "<?php echo lang('info'); ?>";
    var category = "<?php echo lang('category'); ?>";
    var add_new_category = "<?php echo lang('add_new_category'); ?>";
    var edit_category = "<?php echo lang('edit_category'); ?>";
    var are_you_sure = "<?php echo lang('are_you_sure'); ?>";
    var yes = "<?php echo lang('yes'); ?>";
    var no = "<?php echo lang('no'); ?>";
    var select_gallery_images = "<?php echo lang('select_gallery_images'); ?>";
    var max_10_gallery_images = "<?php echo lang('max_10_gallery_images'); ?>";
    var pickup_address = "<?php echo lang('pickup_address'); ?>";
    var select_products = "<?php echo lang('select_products'); ?>";
    var set_package_name = "<?php echo lang('set_package_name'); ?>";
    var add_selected_product_prices = "<?php echo lang('add_selected_product_prices'); ?>";
    var products_uploaded = "<?php echo lang('products_uploaded'); ?>";
    var employees_uploaded = "<?php echo lang('employees_uploaded'); ?>";
    </script>
   </body>
</html>

 
