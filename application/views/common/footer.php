<?php $language = $this->session->userdata('language'); ?>

<!-- <footer class="footer_sec">
        <section class="footer_top">
            <div class="container">
              <div class="row">
                 <div class="col-12 col-md-3">
                    <div class="ftr_main_block">
                       <div class="ftr_logo">
                         <!-- <img src="<?php echo base_url(); ?>assets/images/logo_white.png"> 
                         <img src="<?php echo base_url(); ?>uploads/company/<?php echo $this->session->all_userdata()['webuserdata']['client_configs']['company_logo']; ?>">
                       </div>
                        <ul class="ftr_contact list-unstyled">  
                            <li><span class="cont_icon"><i class="fas fa-map-marker-alt"></i></span> <?php echo $this->session->all_userdata()['webuserdata']['client_configs']['company_name']; ?></li>                    
                            <li><a href="tel:<?php echo $this->session->all_userdata()['webuserdata']['client_configs']['contact_number']; ?>"><span class="cont_icon"><i class="fas fa-phone-alt"></i></span> <?php echo $this->session->all_userdata()['webuserdata']['client_configs']['contact_number']; ?></a></li>                    
                            <li><a href="mailto:<?php echo CONTACT_EMAIL; ?>"><span class="cont_icon"><i class="far fa-envelope"></i></span><?php echo CONTACT_EMAIL; ?></a></li>                  
                        </ul>
                    </div>
                 </div>
                 <div class="col-6 col-md-3">
                    <div class="ftr_main_block">
                       <h4 class="ftr_title"><?php echo lang('services'); ?></h4>
                        <ul class="menu_list list-unstyled mb-0">
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('help_contactus'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('secure_payment'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('return_refund'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('terms_conditions'); ?></a>
                            </li>
                        </ul>
                    </div>
                 </div>
                 <div class="col-6 col-md-3">
                    <div class="ftr_main_block">
                       <h4 class="ftr_title"><?php echo lang('my_account'); ?></h4>
                        <ul class="menu_list list-unstyled mb-0">
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('discount'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('orders_history'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('personal_info'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('shipping_info'); ?></a>
                            </li>
                        </ul>
                    </div>
                 </div>
                 <div class="col-12 col-md-3">
                    <div class="ftr_main_block">
                       <h4 class="ftr_title"><?php echo lang('follow_us'); ?></h4>
                        <ul class="social_main list-unstyled mb-0">
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            </li>
                             <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-google"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>
                 </div>
              </div>
            </div>
        </section>
        <section class="footer_btm text-center">
            <div class="container">
               <?php echo lang('copyright_web'); ?>
            </div>
        </section>
    </footer> -->




    <footer class="footer_sec">
        <section class="footer_top">
            <div class="container">
              <div class="row">
                 <div class="col-6">
                    <div class="ftr_main_block">
                       <div class="ftr_logo">
                       <img src="<?php echo base_url(); ?>uploads/company/<?php echo $this->session->all_userdata()['webuserdata']['client_configs']['company_logo']; ?>">
                       </div>
                        <!-- <ul class="ftr_contact list-unstyled">  
                            <li><span class="cont_icon"><i class="fas fa-map-marker-alt"></i></span> <?php echo lang('galtex_store_pvt_ltd'); ?></li>                    
                            <li><a href="tel:<?php echo CONTACT_PHONE; ?>"><span class="cont_icon"><i class="fas fa-phone-alt"></i></span> <?php echo CONTACT_PHONE; ?></a></li>                    
                            <li><a href="mailto:<?php echo CONTACT_EMAIL; ?>"><span class="cont_icon"><i class="far fa-envelope"></i></span> <?php echo CONTACT_EMAIL; ?></a></li>                  
                        </ul> -->
                    </div>
                 </div>
                 <div class="col-6">
                 <div class="ftr_main_block">
                       <!-- <h4 class="ftr_title"><?php echo lang('follow_us'); ?></h4> -->
                        <ul class="social_main list-unstyled mb-0">
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            </li>
                             <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-google"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>
                 </div>
                 <div class="col-4">
                    <div class="ftr_main_block">
                       <h4 class="ftr_title">Menu</h4>
                        <ul class="menu_list list-unstyled mb-0">
                            <li>
                               <a href="javascript:void(0);">Category</a>
                            </li>
                            <li>
                               <a href="javascript:void(0);">Another Category</a>
                            </li>
                            <li>
                               <a href="javascript:void(0);">Someother Category</a>
                            </li>
                            <li>
                               <a href="javascript:void(0);">Privacy Policy</a>
                            </li>
                            <li>
                               <a href="javascript:void(0);">New Category</a>
                            </li>
                        </ul>
                    </div>
                 </div>
                 <div class="col-4">
                    <div class="ftr_main_block">
                       <h4 class="ftr_title"><?php echo lang('services'); ?></h4>
                        <ul class="menu_list list-unstyled mb-0">
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('help_contactus'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('secure_payment'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('return_refund'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('terms_conditions'); ?></a>
                            </li>
                        </ul>
                    </div>
                 </div>
                 <div class="col-4">
                    <div class="ftr_main_block">
                       <h4 class="ftr_title"><?php echo lang('my_account'); ?></h4>
                        <ul class="menu_list list-unstyled mb-0">
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('discount'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('orders_history'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('personal_info'); ?></a>
                            </li>
                            <li>
                               <a href="javascript:void(0);"><?php echo lang('shipping_info'); ?></a>
                            </li>
                        </ul>
                    </div>
                 </div>
                 <!-- <div class="col-12 col-md-3">
                    <div class="ftr_main_block">
                       <h4 class="ftr_title"><?php echo lang('follow_us'); ?></h4>
                        <ul class="social_main list-unstyled mb-0">
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            </li>
                             <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-google"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-youtube"></i></a>
                            </li>
                        </ul>
                    </div>
                 </div> -->
              </div>
            </div>
        </section>
        <section class="footer_btm text-center">
            <div class="container">
               <?php echo lang('copyright_web'); ?>
            </div>
        </section>
    </footer>

    <!-- Get Base URL --> 
   <script type="text/javascript">
       var base_url = "<?php echo base_url(); ?>";
       var api_url  = base_url + 'api/';
   </script> 

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js" ></script>
    <script src="<?php echo base_url(); ?>assets/js/popper.min.js" ></script>

    <?php if($language == 'he') { ?>
        <script src="<?php echo base_url(); ?>assets/js/rtl-bootstrap.min.js"></script>
    <?php } else { ?>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <?php } ?>
    
    <script src="<?php echo base_url(); ?>assets/js/fontawesome-all.min.js" ></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.zoom.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.bootstrap-touchspin.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/slick.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/script_custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/nprogress.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/sweetalert2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>

   <!--  Error & Success Messages -->
   <script type="text/javascript">
   $(document).ready(function(){
     <?php if($this->session->flashdata('error')){ ?>
       showToaster('error',"<?php echo lang('error'); ?>","<?php echo $this->session->flashdata('error') ?>")
     <?php } ?>
     <?php if($this->session->flashdata('success')){ ?>
       showToaster('success',"<?php echo lang('success'); ?>","<?php echo $this->session->flashdata('success') ?>")
     <?php } ?>
     <?php if($this->session->flashdata('order_thankyou')){ ?>
       showToaster('success',"<?php echo lang('success'); ?>","<?php echo $this->session->flashdata('order_thankyou') ?>")
     <?php } ?>
   });

   /* Manage JS Language Fields */
    var success = "<?php echo lang('success'); ?>";
    var error = "<?php echo lang('error'); ?>";
    var cancel_order = "<?php echo lang('cancel_order'); ?>";
    var cancel_order_sure = "<?php echo lang('cancel_order_sure'); ?>";
    var confirmButtonText = "<?php echo lang('yes'); ?>";
    var cancelButtonText = "<?php echo lang('no'); ?>";
   </script>
  </body>
</html>