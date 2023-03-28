<!doctype html>
<?php $language = $this->session->userdata('language'); ?>
<html lang="<?php echo $language; ?>" class="lang_<?php echo $language; ?>" dir="<?php echo ($language == 'he') ? 'rtl' : 'ltr'; ?>">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->

    <?php if($language == 'he') { ?>
        <link rel="stylesheet" href="assets/css/rtl-bootstrap.min.css">
    <?php } else { ?>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <?php } ?>
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/nprogress.css">
    <link rel="stylesheet" href="assets/css/toastr.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title><?php echo SITE_NAME; ?> :: <?php echo $title; ?></title>
  </head>
  <body>
    
    <header class="header_sec">
        <!-- <div class="hdr_top_bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="hdr_left_block">
                            <ul>
                              <li>
                                <a href="mailto:<?php echo CONTACT_EMAIL; ?>"><i class="fas fa-envelope"></i><?php echo CONTACT_EMAIL; ?></a>
                              </li>
                              <li>
                                <a target="_blank" href="javascript:void(0);"><i class="fab fa-whatsapp"></i><?php echo CONTACT_PHONE; ?></a>
                              </li>
                              
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="hdr_main">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">

                <div class="logo_main">
                  <a href="<?php echo base_url(); ?>">  <img src="assets/images/headerLogo.png" alt="logo" width="38"></a>
                </div>
                            
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <img src="assets/images/menu.png" alt="">
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="mobileHeader">
                      <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6">
                          <button>
                          <i class="fa fa-times" aria-hidden="true"></i>

                          </button>
                        </div>
                      </div>
                    </div>
                    <ul class="navbar-nav ml-auto">               
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>"><?php echo lang('home'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>">Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>">Personal Area</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>">Contact Us</a>
                        </li>
                    </ul>
                    <select class="form-control change-language col-sm-2">
                        <option value="en" <?php if($this->session->userdata('language') == 'en') echo "selected"; ?>>English (EN)</option>
                        <option value="he" <?php if($this->session->userdata('language') == 'he') echo "selected"; ?>>Hebrew (HE)</option>
                    </select> 
                    <div class="socialMedia">
                      <p>Visit us on Social Media</p>
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
                  <div class="mobile_toggle_area"></div>
              </div>
            </nav>
        </div>
    </header>

    <main class="main_content">
      <div class="global-container">
        <div class="mainHeader">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                  <h3>Login</h3>
                  <img src="assets/images/headerLogo.png" alt="">
              </div>
            </div>
          </div>
        </div>
        <div class="card login-form">
          <!-- <div class="row">
            <div class="login-rigth-image col-md-6" style="background-image: url(assets/images/login-right.jpg);">&nbsp;</div> -->
          <div class="col-md-12">
          <div class="card-body">
            <!-- <h3 class="card-title text-center wow fadeInDown" data-wow-delay="0.2s"><?php echo lang('login'); ?></h3> -->
            <div class="card-text">
              <form method="post" id="login-form">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="login_type" checked="" id="inlineRadio1" value="OTP">
                  <label class="form-check-label" for="inlineRadio1"><?php echo lang('otp_message'); ?></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="login_type" id="inlineRadio2" value="Phone">
                  <label class="form-check-label" for="inlineRadio2"><?php echo lang('phone_call'); ?></label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="login_type" id="inlineRadio3" value="Password">
                  <label class="form-check-label" for="inlineRadio3"><?php echo lang('password'); ?></label>
                </div>
                <div class="form-group mobile_number wow fadeInLeft" data-wow-delay="0.4s">
                  <label for="phoneNumber"><?php echo lang('mobile_number'); ?></label>
                  <input type="text" class="form-control" placeholder="<?php echo lang('mobile_number'); ?>" required="" id="phoneNumber" name="phone_number" value="<?php if(isset($_COOKIE["phone_number"])) { echo $_COOKIE["phone_number"]; } ?>">
                  <!-- <span class="get_opt"><?php echo lang('get_otp'); ?></span> -->
                <p style="color:red; margin-top:5px;" class="m-t-10"><?php echo lang('enter_mobile_no_972'); ?></p>
                </div>
                <div class="form-group opt_group ">
                  <label for="phoneOtp"><?php echo lang('enter_otp'); ?></label>
                  <input type="text" class="form-control prevent-copy-paste validate-no" id="phoneOtp" name="otp" placeholder="<?php echo lang('enter_otp'); ?>" maxlength="6">
                </div>
                <div class="form-group password-section" style="display:none;">
                  <label for="password"><?php echo lang('password'); ?></label>
                  <input type="password" class="form-control prevent-copy-paste" id="password" name="password" placeholder="<?php echo lang('password'); ?>">
                </div>
                <div class="form-check wow fadeInLeft" ata-wow-delay="0.6s">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="is_remember" value="yes" <?php if(isset($_COOKIE["phone_number"])) { echo 'checked'; } ?>>
                    <?php echo lang('remember_me'); ?>
                  </label>
                </div>
                <button type="button" class="btn_common btn btn-primary btn-block wow fadeInUp get_otp_phone_call" data-wow-delay="0.8s"><?php echo lang('receive_otp_message'); ?></button>

                <button type="submit" class="btn_common btn btn-primary btn-block wow fadeInUp login-btn hidden" data-wow-delay="0.8s"><?php echo lang('login'); ?></button>
                <div class="forgot_pass">
                  <a class="hover_dash" href="javascript" data-toggle="modal" data-target="#havingTroubleModal"><?php echo lang('having_trobule'); ?></a>
                </div>
              </form>
            </div>
          </div>
        </div>
        
      </div>
     </div>
     </div>

    </main>

    <!-- Modal Need Help -->
    <div class="modal fade" id="havingTroubleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo lang('need_help'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <form method="post" id="help-form">
                <div class="form-group mobile_number">
                  <label for="textArea"><?php echo lang('text_us'); ?></label>
                  <textarea class="form-control" required="" name="message" style="height:100px;" placeholder="<?php echo lang('type_here'); ?>"></textarea>
                </div>
                <center><button type="submit" class="btn_common btn btn-primary btn-block send-btn" style="width:100px;"><?php echo lang('send'); ?></button></center>
              </form>
              <br/>
              <br/>
              <center><h6 class="modal-title" id="exampleModalLabel"><?php echo lang('call_us'); ?></h6></center>
              <a class="btn_common btn btn-primary btn-block" href="tel:050-8424113">050-8424113</a>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer_sec">
        <section class="footer_top">
            <div class="container">
              <div class="row">
                 <div class="col-6">
                    <div class="ftr_main_block">
                       <div class="ftr_logo">
                         <img src="assets/images/logo_white.png">
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
<!--                            <li class="list-inline-item">-->
<!--                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-google"></i></a>-->
<!--                            </li>-->
<!--                            <li class="list-inline-item">-->
<!--                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-instagram"></i></a>-->
<!--                            </li>-->
<!--                            <li class="list-inline-item">-->
<!--                                <a href="javascript:void(0);" target="_blank"><i class="fab fa-youtube"></i></a>-->
<!--                            </li>-->
                        </ul>
                    </div>
                 </div>
<!--                 <div class="col-4">-->
<!--                    <div class="ftr_main_block">-->
<!--                       <h4 class="ftr_title">Menu</h4>-->
<!--                        <ul class="menu_list list-unstyled mb-0">-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">Category</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">Another Category</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">Someother Category</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">Privacy Policy</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">New Category</a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                 </div>-->
<!--                 <div class="col-4">-->
<!--                    <div class="ftr_main_block">-->
<!--                       <h4 class="ftr_title">--><?php //echo lang('services'); ?><!--</h4>-->
<!--                        <ul class="menu_list list-unstyled mb-0">-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">--><?php //echo lang('help_contactus'); ?><!--</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">--><?php //echo lang('secure_payment'); ?><!--</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">--><?php //echo lang('return_refund'); ?><!--</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">--><?php //echo lang('terms_conditions'); ?><!--</a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                 </div>-->
<!--                 <div class="col-4">-->
<!--                    <div class="ftr_main_block">-->
<!--                       <h4 class="ftr_title">--><?php //echo lang('my_account'); ?><!--</h4>-->
<!--                        <ul class="menu_list list-unstyled mb-0">-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">--><?php //echo lang('discount'); ?><!--</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">--><?php //echo lang('orders_history'); ?><!--</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">--><?php //echo lang('personal_info'); ?><!--</a>-->
<!--                            </li>-->
<!--                            <li>-->
<!--                               <a href="javascript:void(0);">--><?php //echo lang('shipping_info'); ?><!--</a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                 </div>-->



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

    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
        var api_url  = base_url + "api/";
    </script>  

    <!-- Optional JavaScript -->
    <script src="assets/js/jquery.min.js" ></script>
    <script src="assets/js/popper.min.js" ></script>
    <?php if($language == 'he') { ?>
        <script src="assets/js/rtl-bootstrap.min.js"></script>
    <?php } else { ?>
        <script src="assets/js/bootstrap.min.js"></script>
    <?php } ?>
    <script src="assets/js/fontawesome-all.min.js" ></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/script_custom.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/nprogress.js"></script>
    <script src="assets/js/toastr.min.js"></script>
    <script src="assets/js/custom/login.js"></script>

    <!--  Error & Success Messages -->
    <script type="text/javascript">
    $(document).ready(function(){
      <?php if($this->session->flashdata('error')){ ?>
        let errorMsg = "<?php echo $this->session->flashdata('error') ?>";
        showToaster('error',"<?php echo lang('error'); ?>",errorMsg)
      <?php } ?>
      <?php if($this->session->flashdata('success')){ ?>
        let successMsg = "<?php echo $this->session->flashdata('success') ?>";
        showToaster('success',"<?php echo lang('success'); ?>",successMsg)
      <?php } ?>
      <?php if($this->session->flashdata('logout')){ ?>
        localStorage.removeItem('login_session_key');
        localStorage.removeItem('user_guid');
        showToaster('success',"<?php echo lang('success'); ?>","<?php echo lang('logged_out'); ?>")
      <?php } ?>
    });

   /* Manage JS Language Fields */
   var success = "<?php echo lang('success'); ?>";
   var error = "<?php echo lang('error'); ?>";
   var loading = "<?php echo lang('loading'); ?>";
   var login = "<?php echo lang('login'); ?>";
   var get_otp = "<?php echo lang('get_otp'); ?>";
   var get_phone_call = "<?php echo lang('get_phone_call'); ?>";
   var send = "<?php echo lang('send'); ?>";
   var receive_otp_message = "<?php echo lang('receive_otp_message'); ?>";
   var receive_phone_call = "<?php echo lang('receive_phone_call'); ?>";
  </script>
  </body>
</html>