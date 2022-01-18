<aside id="sidebar">
    <!--| MAIN MENU |-->
    <ul class="side-menu"> 
        <li class="<?php if(isset($module) && $module == 'dashboard') echo 'active' ;?>">
            <a href="<?php echo base_url(); ?>admin/dashboard">
                <i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i>
                <span><?php echo lang('dashboard'); ?></span> 
            </a>
        </li>
        <?php if($this->user_type_id == 1){ ?>
            <li class="<?php if(isset($module) && $module == 'clients') echo 'active' ;?>">
                <a href="<?php echo base_url(); ?>admin/clients/list">
                    <i class="zmdi zmdi-account zmdi-hc-fw"></i>
                    <span><?php echo lang('manage'); ?> <?php echo lang('clients'); ?></span>
                </a>
            </li>
        <?php } ?>
        <li class="<?php if(isset($module) && $module == 'employees') echo 'active' ;?>">
            <a href="<?php echo base_url(); ?>admin/employees/list">
                <i class="zmdi zmdi-accounts zmdi-hc-fw"></i>
                <span><?php echo lang('manage'); ?> <?php echo lang('employees'); ?></span>
            </a>
        </li>
        <?php if($this->user_type_id == 2){ ?>
            <li class="<?php if(isset($module) && $module == 'shop') echo 'active' ;?>">
                <a href="<?php echo base_url(); ?>admin/shop/view">
                    <i class="zmdi zmdi-shopping-cart zmdi-hc-fw"></i>
                    <span><?php echo lang('manage'); ?> <?php echo lang('shop'); ?></span>
                </a>
            </li>
        <?php } ?>
        <?php if($this->user_type_id == 1){ ?>
            <li class="<?php if(isset($module) && $module == 'categories') echo 'active' ;?>">
                <a href="<?php echo base_url(); ?>admin/categories/list">
                    <i class="zmdi zmdi-view-comfy zmdi-hc-fw"></i>
                    <span><?php echo lang('manage'); ?> <?php echo lang('categories'); ?></span>
                </a>
            </li>
            <li class="<?php if(isset($module) && $module == 'products') echo 'active' ;?>">
                <a href="<?php echo base_url(); ?>admin/products/list">
                    <i class="zmdi zmdi-view-web zmdi-hc-fw"></i>
                    <span><?php echo lang('manage'); ?> <?php echo lang('products'); ?></span>
                </a>
            </li>
            <li class="<?php if(isset($module) && $module == 'orders') echo 'active' ;?>">
                <a href="<?php echo base_url(); ?>admin/orders/list">
                    <i class="zmdi zmdi-view-web zmdi-hc-fw"></i>
                    <span><?php echo lang('manage'); ?> <?php echo lang('orders'); ?></span>
                </a>
            </li>
            <li class="<?php if(isset($module) && $module == 'languages') echo 'active' ;?>">
                <a href="<?php echo base_url(); ?>admin/languages?lang=<?php echo DEFAULT_LANGUAGE_CODE; ?>">
                    <i class="zmdi glyphicon glyphicon-file"></i>
                    <span><?php echo lang('manage'); ?> <?php echo lang('language_file'); ?></span>
                </a>
            </li>
        <?php } ?>
        <li>
            <a href="javascript:void(0);" onclick="showConfirmationBox('<?php echo lang('are_you_sure'); ?>','<?php echo lang('are_you_sure_logout'); ?>','<?php echo lang('yes'); ?>','<?php echo lang('no'); ?>','<?php echo base_url(); ?>admin/dashboard/logout/<?php echo $this->login_session_key; ?>')">
                <i class="glyphicon glyphicon-log-out" style="margin-left:10px;margin-right:10px;"></i>
                <span><?php echo lang('logout'); ?></span>
            </a>
        </li>
    </ul>
</aside>