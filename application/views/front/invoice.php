<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="format-detection" content="telephone=no, date=no, address=no, email=no, url=no">
  <meta name="x-apple-disable-message-reformatting">
  <title><?php echo $details['company_name']; ?> :: <?php echo lang('invoice'); ?></title>
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  
 
 <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
  @import url('https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap');
  /*
  font-family: 'Poppins', sans-serif;
  Regular 400
  Medium 500
  Semi-bold 600
  Bold 700

  font-family: 'Libre Baskerville', serif;
  Regular 400, Regular 400 italic, Bold 700
*/
@media print {
  tr {page-break-inside:auto;}
}
</style>

</head>
<body style="margin:0;padding:0;word-spacing:normal;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; background-color: #fcfcff; font-family: 'Poppins', sans-serif; ">
  <div role="article" aria-roledescription="email" lang="en" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#fff;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-family: 'Poppins', sans-serif; margin-left: auto; margin-right: auto; ">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="padding-top: 00px;  padding-bottom: 0px; margin-left: auto; margin-right: auto; border: 2px solid <?php echo $details['theme_color']; ?>; font-size: 14px; width: 50%;">
      <tr>
        <td style="padding: 0px 0px 40px;">
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr style="background-color:<?php echo $details['theme_color']; ?>; ">
              <td style="padding-bottom: 0px; vertical-align: middle; padding: 10px 40px;">
                <a href="javascript:void(0);" style="display: inline-block; margin-top:0px; margin-bottom: 0px; text-decoration: none; color: #000;">
                  <img src="<?php echo base_url().'uploads/company/'.$details['company_logo']; ?>" width="130px">
                </a>
              </td>
              <td style="vertical-align: middle; text-align: right; padding: 10px 40px;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-family: 'Poppins', sans-serif;">
                <p style="margin-top: 0; margin-bottom: 0;font-size: 14px; color: #fff;"><?php echo lang('hello'); ?> <?php echo $details['employee_name']; ?>!</p>
                <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;color: #fff;"><?php echo lang('order_no'); ?> <?php echo "OID-".$details['order_id']; ?> <?php echo lang('completed_successfully'); ?></p>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="padding-top: 20px;">&nbsp;</td>
            </tr>
            
            <tr>
              <td colspan="2" style="vertical-align: bottom; padding: 20px 40px; text-align: right;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-family: 'Poppins', sans-serif;">
                <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;"><?php echo lang('congratulation_gift'); ?> <?php echo $details['company_name']; ?> <?php echo lang('by_galtex'); ?> !</p><br/>
                <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;"><b><?php echo lang('check_below_order_sum'); ?></b></p>
                <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;color:<?php echo $details['theme_color']; ?>">[<?php echo $details['order_id']; ?>, <?php echo convertDateTime($details['order_datetime']); ?>]</p>
              </td>
            </tr>
            <!-- <tr>
              <td colspan="2" style="padding-top: 20px;">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #ccc;">
                  <tr style="background-color: #4aa4ef; ">
                    <th style="background-color: #4aa4ef;color: #fff; text-align: center; padding: 7px 10px;font-size: 14px;">Card type</th>
                    <th style="background-color: #4aa4ef;color: #fff; text-align: center; padding: 7px 10px;font-size: 14px;">Payments</th>
                    <th style="background-color: #4aa4ef;color: #fff; text-align: center; padding: 7px 10px;font-size: 14px;">Last 4 digits of credit</th>
                    <th style="background-color: #4aa4ef;color: #fff; text-align: center; padding: 7px 10px;font-size: 14px;">Order ID</th>
                    <th style="background-color: #4aa4ef;color: #fff; text-align: center; padding: 7px 10px;font-size: 14px;">Payment Method</th>
                  </tr>
                  <tr>
                    <td style="text-align: center; padding: 7px 10px; border-right: 1px solid #ccc;font-size: 14px;">Visa</td>
                    <td style="text-align: center; padding: 7px 10px; border-right: 1px solid #ccc;font-size: 14px;">1</td>
                    <td style="text-align: center; padding: 7px 10px; border-right: 1px solid #ccc;font-size: 14px;">046098</td>
                    <td style="text-align: center; padding: 7px 10px; border-right: 1px solid #ccc;font-size: 14px;">114038</td>
                    <td style="text-align: center; padding: 7px 10px;font-size: 14px;">Razorpay</td>
                  </tr>
                </table>
              </td>
            </tr> -->
            <tr>
              <td colspan="2" style="padding: 20px 40px;">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #ccc;">
                  <tr style="background-color: <?php echo $details['theme_color']; ?>; ">
                    <th style="background-color: <?php echo $details['theme_color']; ?>;color: #fff; text-align: center; padding: 7px 10px;"><?php echo lang('price'); ?></th>
                    <th style="background-color: <?php echo $details['theme_color']; ?>;color: #fff; text-align: center; padding: 7px 10px;"><?php echo lang('quantity'); ?></th>
                    
                    <th style="background-color: <?php echo $details['theme_color']; ?>;color: #fff; text-align: center; padding: 7px 10px;"><?php echo lang('product'); ?></th>
                  </tr>
                  <?php $i = 1; foreach($details['cart_data'] as $rowid => $cart) { ?>
                  <tr>
                    <?php $price = showCartPrice($i++,$rowid); ?>
                    <td style="text-align: center; padding: 7px 10px; border-right: 1px solid #ccc; border-top: 1px solid #ccc;"><?php echo (empty($price)) ? '-'  : (CURRENCY_SYMBOL.$price);  ?></td>
                    <td style="text-align: center; padding: 7px 10px; border-right: 1px solid #ccc; border-top: 1px solid #ccc;"><?php echo $cart['qty']; ?></td>
                    
                    <td style="text-align: center; padding: 7px 10px; border-right: 1px solid #ccc; border-top: 1px solid #ccc;"><?php echo $cart['name']; ?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td colspan="3" style="text-align: center; padding: 7px 10px; border-top: 1px solid #ccc;"><?php echo lang('total'); ?> <?php echo CURRENCY_SYMBOL.(array_sum(array_column($details['cart_data'],'subtotal')) - $this->session->userdata('webuserdata')['employee_budget']); ?></td>
                  </tr>
                </table>
                <!-- <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                  <tr>
                    <td style="text-align: left; padding: 5px 0px;"><b>Sales tax 17%  :</b> 40</td>
                  </tr>
                  <tr>
                    <td style="text-align: left; padding: 5px 0px;"><b>Final Price  :</b> 300</td>
                  </tr>
                </table> -->
              </td>
            </tr>
            <tr>
              <td colspan="2" style="vertical-align: bottom; padding: 20px 40px; text-align: right;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;font-family: 'Poppins', sans-serif;">
                <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;"><b><?php echo lang('delivery_details'); ?></b></p>
                <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;"><?php echo $details['employee_name'];  ?></p>
                <?php if($details['address_mode'] == 'Pickup') { ?>
                  <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;"><?php echo $details['pickup_address']; ?></p>
                <?php } else { ?>
                  <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;"><?php echo $details['city'].", ".$details['street_house']; ?></p>
                  <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;"><?php echo $details['apartment']; ?></p>
                  <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;"><?php echo $details['postal_code']; ?></p>
                <?php } ?>
                <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;"><?php echo $details['employee_email']; ?></p>
                <p style="margin-top: 0; margin-bottom: 0;font-size: 14px;"><?php echo $details['phone_number']; ?></p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
