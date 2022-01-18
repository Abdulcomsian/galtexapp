<main class="main_content">
       <section class="inner_banner_sec">
          <div class="innerbanner_cap text-center">
             <div class="container">
                <div class="watermark_text">
                   <h1 class="head_1"><?php echo lang('checkout'); ?></h1>
                   <p class="watermark wow zoomIn" data-wow-delay="0.4s"><?php echo lang('checkout'); ?></p>
                </div>
             </div>
          </div>
       </section>
       <section class="checkout_sec">
          <div class="container">
              
                <div class="pb-5 text-center">
                  <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida</p> -->
                </div>
                <?php 
                  $total_amount = (array_sum(array_column($cart,'subtotal')) - $this->session->userdata('webuserdata')['employee_budget']);
                  $credits_minus = 0;
                ?>
                <div class="row">
                  <div class="col-md-4 order-md-2 mb-4">
                    <div class="account_detail_main wow zoomIn">
                      <h4 class="d-flex justify-content-between align-items-center mb-4">
                        <?php echo lang('your_cart'); ?>
                        <span class="badge badge-secondary badge-pill"><?php echo count($cart); ?></span>
                      </h4>
                      <ul class="list-group mb-3">
                        <?php $i = 1; foreach($cart as $rowid => $value) { ?>
                          <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                              <h6 class="my-0"><?php echo $value['name']; ?></h6>
                              <small class="text-muted"><?php echo $value['qty']; ?> <?php echo lang('quantity'); ?></small>
                            </div>
                            <span class="text-muted"><?php echo CURRENCY_SYMBOL.showCartPrice($i++,$rowid); ?></span>
                          </li>
                        <?php } ?>
                        <li class="list-group-item d-flex justify-content-between">
                          <span><?php echo lang('total_amount'); ?></span>
                          <strong class="price text-success"><?php echo CURRENCY_SYMBOL.$total_amount; ?></strong>
                        </li>
                        <?php if($user_details['total_credits'] > 0 && $total_amount > 0) { 
                            $credits_minus = ($user_details['total_credits'] > $total_amount) ? $total_amount : $user_details['total_credits'];
                          ?>
                          <li class="list-group-item d-flex justify-content-between">
                            <span><?php echo lang('credits_balance'); ?></span>
                            <strong class="price text-danger">(-) <?php echo CURRENCY_SYMBOL.$credits_minus; ?></strong>
                          </li>
                          <li class="list-group-item d-flex justify-content-between">
                            <span><?php echo lang('payable_amount'); ?></span>
                            <strong class="price text-success"><?php echo CURRENCY_SYMBOL.($total_amount - $credits_minus); ?></strong>
                          </li>
                         <?php } ?>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-8 order-md-1">
                    <form class="custom_form needs-validation" id="billing-form" method="post">
                      <div class="account_detail_main wow zoomIn">
                        <h4><?php echo lang('billing_address'); ?></h4>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group focus_label">
                              <label for="firstName"><?php echo lang('first_name'); ?></label>
                              <input type="text" class="form-control" id="firstName" readonly="" name="first_name" value="<?php echo $details['first_name']; ?>" required>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group focus_label">
                              <label for="lastName"><?php echo lang('last_name'); ?></label>
                              <input type="text" class="form-control" id="lastName" readonly="" name="last_name" value="<?php echo $details['last_name']; ?>" required>
                            </div>
                          </div>
                          <?php if($client_details['delivery_method'] != 'Both') { ?>
                            <input type="hidden" name="address_mode" value="<?php echo $client_details['delivery_method']; ?>">
                          <?php } else { ?>
                            <div class="col-md-6">
                              <div class="form-group focus_label">
                                <label for="delivery_address"><?php echo lang('choose_door_to_door_pickup'); ?></label>
                                <select class="form-control" id="delivery_address" name="address_mode">
                                    <option value=""><?php echo lang('choose_door_to_door_pickup') ?></option>
                                    <option value="Door to Door"><?php echo lang('door_to_door') ?></option>
                                    <option value="Pickup"><?php echo lang('pickup') ?></option>
                                </select>
                              </div>
                            </div>
                          <?php } ?>
                          <?php if($client_details['delivery_method'] == 'Door to Door' || $client_details['delivery_method'] == 'Both') { ?>
                            <div class="col-md-6 delivery-address-section" style="<?php if($client_details['delivery_method'] == 'Both') {  echo "display:none"; } ?>">
                              <div class="form-group focus_label">
                                <label for="city"><?php echo lang('city'); ?></label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="<?php echo lang('city'); ?>">
                              </div>
                              <div class="form-group focus_label">
                                <label for="apartment"><?php echo lang('apartment'); ?></label>
                                <input type="text" class="form-control" id="apartment" name="apartment"  placeholder="<?php echo lang('apartment'); ?>">
                              </div>
                              <div class="form-group focus_label">
                                <label for="street_house"><?php echo lang('street_house'); ?></label>
                                <input type="text" class="form-control" id="street_house" name="street_house" placeholder="<?php echo lang('street_house'); ?>">
                              </div>
                              <div class="form-group focus_label">
                                <label for="postal_code"><?php echo lang('postal_code'); ?></label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="<?php echo lang('postal_code'); ?>">
                              </div>
                            </div>
                          <?php } if($client_details['delivery_method'] == 'Pickup' || $client_details['delivery_method'] == 'Both') { ?>
                            <div class="col-md-6 pickup-address-section" style="<?php if($client_details['delivery_method'] == 'Both') {  echo "display:none"; } ?>">
                              <div class="form-group focus_label">
                                <label for="delivery_address"><?php echo lang('pickup_address'); ?></label>
                                <select class="form-control" name="pickup_address">
                                    <option value=""><?php echo lang('pickup_address') ?></option>
                                    <?php if(!empty($client_details['client_addresses'])) { foreach($client_details['client_addresses'] as $address) { ?>
                                        <option value="<?php echo $address; ?>"><?php echo $address; ?></option>
                                    <?php } } ?>
                                </select>
                              </div>
                            </div>
                          <?php } ?>
                        </div>
                      </div>

                      <?php if(($total_amount - $credits_minus) > 0) { ?>
                        
                        <!-- <div class="account_detail_main wow zoomIn">
                          <h4><?php echo lang('payment'); ?></h4>
                          <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                              <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
                              <label class="custom-control-label" for="credit"><?php echo lang('credit_card'); ?></label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cc-name"></label>
                                <input type="text" class="form-control" id="cc-name" name="cc_name" placeholder="<?php echo lang('card_name'); ?>" required>
                                <small class="text-muted"><?php echo lang('full_name_on_card'); ?></small>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="cc-number"></label>
                                <input type="text" class="form-control" id="cc-number" name="cc_number" placeholder="<?php echo lang('card_no'); ?>" required>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="cc-expiration"></label>
                                <input type="text" class="form-control" id="cc-expiration" name="cc_expiration" placeholder="<?php echo lang('mm_yy'); ?>" required>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="cc-cvv"></label>
                                <input type="text" class="form-control" id="cc-cvv" name="cc_cvv" placeholder="<?php echo lang('cvv'); ?>" required>
                              </div>
                            </div>
                          </div>
                        </div> -->
                      <?php } ?>
                      <button class="btn btn_common mb-5 wow zoomInRight checkout-btn" type="submit"><?php echo lang('continue_to_checkout'); ?></button>
                    </form>
                  </div>
                </div>

                
          </div>
      </section>
    </main>