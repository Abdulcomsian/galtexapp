<?php 
$color_code = $this->session->all_userdata()['webuserdata']['client_configs']['theme_color'];
$company_logo = $this->session->all_userdata()['webuserdata']['client_configs']['company_logo'];
$language = $this->session->userdata('language');
?>

<!doctype html>
<html lang="<?php echo $language; ?>" class="lang_<?php echo $language; ?>" dir="<?php echo ($language == 'he') ? 'rtl' : 'ltr'; ?>">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png"/>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!-- Bootstrap CSS -->

      <?php if($language == 'he') { ?>
           <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/rtl-bootstrap.min.css">
       <?php } else { ?>
           <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
       <?php } ?>
       
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontawesome-all.min.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/slick.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.bootstrap-touchspin.min.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/nprogress.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/toastr.min.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert2.min.css">
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
      <title><?php echo SITE_NAME; ?> :: <?php echo @$title; ?></title>
      <style type="text/css">
         /** theme color update start**/
         .hdr_top_bar,
         .btn_common,
         .btn_common:hover,
         .hover_dash:before,
         .catlist_item li input[type=checkbox]:checked ~ label span,
         h2.head_common2:after,
         .quantity .btn-primary:hover,
         .cart_table th,
         .form-control.change-language{
             background: <?php echo $color_code; ?>;
         }
         .inner_banner_sec,
         .pagination_main .page-link.active,
         .profile_main .nav-tabs .nav-link.active,
         .custom-radio .custom-control-input:checked~.custom-control-label::before,
         .nav_right li .badge{
             background-color: <?php echo $color_code; ?>;
         }
         a, .hdr_main .navbar-nav .nav-link:hover,
         .get_opt,
         .hover_dash:hover,
         .catlist_item a:hover,
         .sort_by_list ul li a:hover,
         .pro_view_main li button:hover, 
         .pro_view_main li.active button,
         .breadcrumb-item a:hover,
         .pagination_main .page-link:hover,
         .custom_form h4, .checkout_sec .account_detail_main > h4{
             color: <?php echo $color_code; ?>;
         }
         .btn_common:hover,
         .catlist_item li input[type=checkbox]:checked ~ label span,
         .thumb_inner:hover,
         .custom_form .form-group .form-control:focus,
         .profile_main .nav-tabs .nav-link.active {
             border-color:<?php echo $color_code; ?>;
         }
         .btn_common{
             outline-color:<?php echo $color_code; ?>;
         }
         /** theme color update end**/
      </style>
   </head>
   <body>
      
      <header class="header_sec">
         <!-- <div class="hdr_top_bar">
            <div class="container">
               <div class="row align-items-center">
                  <div class="col-6">
                     <div class="hdr_left_block">
                        <ul>
                           <li>
                              <a href="javascript:void(0);"><i class="fas fa-text"></i><?php echo $this->session->userdata('webuserdata')['client_configs']['shop_title']; ?></a>
                           </li>
                           <li>
                              <a target="_blank" href="javascript:void(0);"><i class="fab fa-whatsapp"></i><?php echo $this->session->all_userdata()['webuserdata']['client_configs']['contact_number']; ?></a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-6 text-right">
                     <div class="hdrbudget" style="display:none;">
                        <?php echo lang('budget'); ?> <?php echo CURRENCY_SYMBOL; ?><?php echo $this->session->userdata('webuserdata')['employee_budget']; ?>
                     </div>
                  </div>
               </div>
            </div>
         </div> -->
         <div class="hdr_main">
            <nav class="navbar navbar-expand-lg">
               <div class="container">
                  <a href="<?php echo base_url(); ?>" class="companyLogo desktopHide">  <img src="<?php echo base_url(); ?>uploads/company/<?php echo $company_logo; ?>" alt="logo" style="height:60px;"></a>
                  <div class="logo_main">
                     <a href="<?php echo base_url(); ?>">  <img src="<?php echo base_url(); ?>uploads/company/<?php echo $company_logo; ?>" alt="logo" style="height:60px;"></a>
                  </div>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                     <img src="<?php echo base_url(); ?>assets/images/menu.png" alt="">
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                           <a class="nav-link" href="<?php echo base_url(); ?>"><?php echo lang('home'); ?></a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="javascript:void(0);"><?php echo lang('about'); ?></a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" href="javascript:void(0);"><?php echo lang('contact'); ?></a>
                        </li>
                     </ul>
                     <select class="form-control change-language col-sm-2">
                        <option value="en" <?php if($this->session->userdata('language') == 'en') echo "selected"; ?>>English (EN)</option>
                        <option value="he" <?php if($this->session->userdata('language') == 'he') echo "selected"; ?>>Hebrew (HE)</option>
                    </select>
                  </div>
                  <div class="mobile_toggle_area"></div>
                  <ul class="nav_right">
                     <li class="list-inline-item user_item mobileHide">
                        <a href="javascript:void(0);" class="userdd_open"><img src="<?php echo base_url(); ?>assets/images/icon_user.svg"></a>
                        <ul class="dropdown-hover">
                           <li>
                              <a href="<?php echo base_url(); ?>employees/profile">
                              <span><img src="<?php echo base_url(); ?>assets/images/icon_myaccount.svg" alt=""></span> <?php echo lang('my_account'); ?>
                              </a>
                           </li>
                           <li>
                              <a href="javascript:void(0);" onclick="showConfirmationBox('<?php echo lang('are_you_sure'); ?>','<?php echo lang('are_you_sure_logout'); ?>','<?php echo lang('yes'); ?>','<?php echo lang('no'); ?>','<?php echo base_url(); ?>home/logout/<?php echo $this->login_session_key; ?>')">
                              <span><img src="<?php echo base_url(); ?>assets/images/icon_logout.svg" alt=""></span> <?php echo lang('logout'); ?>
                              </a>
                           </li>
                        </ul>
                     </li>
                     <li class="list-inline-item desktopHide filterIconBtn">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                     </li>
                     <?php if(!empty($this->cart->contents())) { ?>
                        <li class="list-inline-item">
                           <a class="open-cart-sidebar" href="<?php echo base_url(); ?>employees/cart">
                           <img src="<?php echo base_url(); ?>assets/images/icon_cart.svg">
                           <span class="top-cart-info-count badge badge-pill"><?php echo count($this->cart->contents()); ?></span>
                           </a>
                        </li>
                     <?php } else { ?>
                        <li class="list-inline-item">
                           <a class="open-cart-sidebar" href="javascript:void(0)">
                           <img src="<?php echo base_url(); ?>assets/images/icon_cart.svg">
                           <span class="top-cart-info-count badge badge-pill">0</span>
                           </a>
                        </li>
                     <?php } ?>
                  </ul>
               </div>
               <div class="filterBox">
                  <div class="filterHeader">
                     <div class="closingBtn">
                        <button>
                           <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                     </div>
                  </div>
                  <div class="filterCategory">
                     <h4>Filter by categories</h4>
                     <p>Category</p>
                     <ul class="list-unstyled catlist_item">
                                <?php if($categories['data']['total_records']) { foreach($categories['data']['records'] as $category) { ?>
                                <li class="wow fadeInLeft" data-wow-delay="0.3s">
                                    <label for="category_<?php echo $category['category_guid']; ?>">
                                       <?php echo $category['category_name']; ?>
                                    </label>    
                                    <input type="checkbox" id="category_<?php echo $category['category_guid']; ?>" name="main_category[]" value="<?php echo $category['category_guid']; ?>" <?php if(in_array($category['category_guid'], $main_categories)) echo "checked"; ?> class="main_categories" />
                                    
                                </li>
                                <?php } } ?>
                            </ul>
                  </div>
                 
               </div>
               <div class="blurEffect">
               <div class="shoppingCart">
                     <div class="headerCart">
                        <img src="<?php echo base_url(); ?>uploads/company/<?php echo $this->session->all_userdata()['webuserdata']['client_configs']['company_logo']; ?>">
                        <button>
                           Close
                        </button>
                     </div>
                     <div class="cartList">
                        <h4>Shopping Cart</h4>
                        <ul>
                           <li>
                              <i class="fa fa-times" aria-hidden="true"></i>
                              <div class="itemCart">
                                 <div class="itemDetail">
                                    <h5>Name of Product</h5>
                                    <p>
                                       <span>30 ml</span>
                                       <span>x1</span>
                                    </p>
                                 </div>
                                 <img src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTN8fHByb2R1Y3RzfGVufDB8fDB8fA%3D%3D&w=1000&q=80" />
                              </div>
                           </li>
                           <li>
                              <i class="fa fa-times" aria-hidden="true"></i>
                              <div class="itemCart">
                                 <div class="itemDetail">
                                    <h5>Name of Product</h5>
                                    <p>
                                       <span>30 ml</span>
                                       <span>x1</span>
                                    </p>
                                 </div>
                                 <img src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTN8fHByb2R1Y3RzfGVufDB8fDB8fA%3D%3D&w=1000&q=80" />
                              </div>
                           </li>
                           <li>
                              <i class="fa fa-times" aria-hidden="true"></i>
                              <div class="itemCart">
                                 <div class="itemDetail">
                                    <h5>Name of Product</h5>
                                    <p>
                                       <span>30 ml</span>
                                       <span>x1</span>
                                    </p>
                                 </div>
                                 <img src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTN8fHByb2R1Y3RzfGVufDB8fDB8fA%3D%3D&w=1000&q=80" />
                              </div>
                           </li>
                           <li>
                              <i class="fa fa-times" aria-hidden="true"></i>
                              <div class="itemCart">
                                 <div class="itemDetail">
                                    <h5>Name of Product</h5>
                                    <p>
                                       <span>30 ml</span>
                                       <span>x1</span>
                                    </p>
                                 </div>
                                 <img src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTN8fHByb2R1Y3RzfGVufDB8fDB8fA%3D%3D&w=1000&q=80" />
                              </div>
                           </li>
                           <li>
                              <i class="fa fa-times" aria-hidden="true"></i>
                              <div class="itemCart">
                                 <div class="itemDetail">
                                    <h5>Name of Product</h5>
                                    <p>
                                       <span>30 ml</span>
                                       <span>x1</span>
                                    </p>
                                 </div>
                                 <img src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTN8fHByb2R1Y3RzfGVufDB8fDB8fA%3D%3D&w=1000&q=80" />
                              </div>
                           </li>
                           <li>
                              <i class="fa fa-times" aria-hidden="true"></i>
                              <div class="itemCart">
                                 <div class="itemDetail">
                                    <h5>Name of Product</h5>
                                    <p>
                                       <span>30 ml</span>
                                       <span>x1</span>
                                    </p>
                                 </div>
                                 <img src="https://images.unsplash.com/photo-1526947425960-945c6e72858f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTN8fHByb2R1Y3RzfGVufDB8fDB8fA%3D%3D&w=1000&q=80" />
                              </div>
                           </li>
                        </ul>
                     </div>
                     <div class="cartTotal">
                        <ul>
                           <li>95,595 ml</li>
                           <li>15 items</li>
                           <li>Total</li>
                        </ul>
                     </div>
                     <button class="continuePayment">
                     Continue to payment
                     </button>
                  </div>
                  </div>
            </nav>
         </div>
       
      </header>