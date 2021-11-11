<div class="header">
    <div class="logo logo-dark">
        <a href="<?=ADMIN_LINK;?>">
            <img src="<?php echo base_url('public/front/images/logo/'.$site_logo );?>" alt="Logo"  class="logo-inner">
            <img class="logo-fold" src="<?php echo base_url('public/front/images/logo/'.$site_logo );?>" alt="Logo">
        </a>
    </div>
    <div class="side-nav">
        <div class="side-nav-inner">
            <ul class="side-nav-menu">
                <!--<li class="nav-item desktop-toggle">
                    <a href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="far fa-envelope"></i>
                        </span>
                        <span class="title">Mailbox</span>
                    </a>
                </li>-->
                <li class="nav-item">
                    <a href="<?php echo ADMIN_LINK; ?>dashboard">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">Stats</span>
                    </a>
                </li>
                <?php 
                $user_data = $this->crud->get_row_by_id('tbl_users',' id = '.$vendorId.'  ');
                
                // echo "<pre>";
                // print_r($user_data); exit;
                
                $stores_data = "";
                if($user_data['roleId'] == 1){
                    $stores_data =  $this->crud->get_all_with_where('store','name','asc',array('status'=>'Y','isDelete'=>0));
                    $super = 1;
                }else{
                    if($user_data['store_id'] != ""){
                        $stores_data =  $this->crud->getFromSQL("SELECT * FROM `store` WHERE `status` = 'Y' AND `isDelete` = 0 AND FIND_IN_SET(id ,'".$user_data['store_id']."') ORDER BY `name` ASC");
                    }else{
                        $stores_data =  $this->crud->get_all_with_where('store','name','asc',array('status'=>'Y','isDelete'=>0,'id'=>""));
                    }
                    $super = 0;
                }
                ?>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="fas fa-gem"></i>
                        </span>
                        <span class="title">Inventory</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <!-- <a href="javascript:void(0);" data-toggle="modal" data-target=".add-product-modal" id="add_product_menu">Add Product</a> -->
                            <a href="javascript:void(0);" onclick="$('.add-product-modal').modal('show');" id="add_product_menu">Add Product</a>
                        </li>
                        <?php if($user_role_id == 1){ ?> 
                            <li>
                                <!-- <a href="javascript:void(0);" data-toggle="modal" data-target=".add-product-modal" id="add_product_menu">Add Product</a> -->
                                <a href="javascript:void(0);" onclick="$('.add-brand-modal').modal('show');" id="add_brand_menu">Add Brand</a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo ADMIN_LINK; ?>manage-product">View Products</a>
                        </li>
                        <?php if($super){ ?> 
                            <li>
                                <a href="<?php echo ADMIN_LINK; ?>manage-brand-restricted">Manage Brand</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="fab fa-first-order"></i>
                        </span>
                        <span class="title">Orders</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo ADMIN_LINK; ?>manage-amazon-order">Amazon Orders</a>
                        </li>
                        <li>
                            <a href="<?php echo ADMIN_LINK; ?>manage-amazon-asin">Sales By ASIN</a>
                        </li>
                        <?php if($user_role_id == 2 || $user_role_id == 1){ ?> 
                        <li>
                            <a href="<?php echo ADMIN_LINK; ?>manage-record">Manage Record</a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
                <!-- <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="fas fa-cog"></i>
                        </span>
                        <span class="title">Account Settings</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"> Integrations </a>
                        </li>
                    </ul>
                </li> -->
 
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="far fa-store"></i>
                        </span>
                        <?php
                        $active_store_id =  $this->session->userdata('store') ? $this->session->userdata('store') : "0";
                        
                        $active_store = $this->crud->get_row_by_id('store',' id = '.$active_store_id.'');
                        ?>
                        <span class="title">Store <?php echo !empty($active_store) ? "(".$active_store['name'].")" : "(All Store)"; ?></span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu" style="overflow: scroll;max-height: 500px;width: auto;overflow-x: hidden;">
                        <?php if($super){ ?> 
                            <li>
                                <a href="<?=base_url("admin/manage-store");?>"> Add Store</a>
                            </li> 
                            <!-- <li>-->
                            <!--    <a href="javascript:void(0);" class="change_store" data-id="<?php echo ADMIN_LINK; ?>manage-store/chnagestatus/all"> All Store</a>-->
                            <!--</li>-->
                        <?php } ?>
                               
                        <?php if($this->session->userdata('store')){ ?>
                             <?php if($user_role_id == 2 || $user_role_id == 1|| $user_role_id == 3){ ?> 
                            <li>
                                <a href="javascript:void(0);" class="change_store" data-id="<?php echo ADMIN_LINK; ?>manage-store/chnagestatus/all"> All Store</a>
                            </li>
                            <?php } ?>
                        <?php } ?>

                        <?php 
                        if(!empty($stores_data))
                        { 
                            $i=0; 
                            foreach($stores_data as $stores)
                            { ?>
                                <li>
                                    <a href="javascript:void(0);" class="change_store" data-id="<?php echo ADMIN_LINK; ?>manage-store/chnagestatus/<?= $stores->id ?>"> <?= $stores->name ?> </a>
                                </li>
                            <?php 
                            $i++; 
                            } 
                        } 
                        ?>
                    </ul>
                </li>
 
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="far fa-store"></i>
                        </span>
                        <span class="title">Report </span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?=base_url("admin/report/profit");?>"> Profit</a>
                        </li> 
                        <li>
                            <a href="<?=base_url("admin/report/revenue");?>"> Revenue</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="side-nav-mainbox">
        <div class="side-nav-inner">
            <ul class="side-nav-menu">
                <li class="nav-item desktop-toggle">
                    <a href="mailbox.html">
                        <span class="icon-holder">
                            <i class="far fa-home"></i>
                        </span>
                        <span class="title">Home</span>
                        
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="title">My Ticket</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="fal fa-at"></i>
                            <p>1</p>
                        </span>
                        <span class="title">Mentioned</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="far fa-envelope"></i>
                            <p>205</p>
                        </span>
                        <span class="title">New Tickets</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="fas fa-list-ul"></i>
                            <p>205</p>

                        </span>
                        <span class="title">To Do</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="anticon anticon-dashboard"></i>
                        </span>
                        <span class="title">Waiting</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="far fa-alarm-snooze"></i>
                        </span>
                        <span class="title">Snoozed</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="fal fa-check-square"></i>
                        </span>
                        <span class="title">Resolved</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="far fa-history"></i>
                        </span>
                        <span class="title">Recently Update</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0);">
                        <span class="icon-holder">
                           <i class="fas fa-pencil-alt"></i>
                        </span>
                        <span class="title">Create ticket</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="nav-wrap">
        <ul class="nav-left">
            <!-- <li class="desktop-toggle">
                <a href="javascript:void(0);">
                    <i class="anticon"></i>
                </a>
            </li> -->
            <li class="mobile-toggle">
                <a href="javascript:void(0);">
                    <i class="anticon"></i>
                </a>
            </li>
        </ul>
        <ul class="nav-right">
            <!-- <li>
                <a href="javascript:void(0);" data-toggle="modal" data-target="#search-drawer">
                    <i class="anticon anticon-search"></i>
                </a>
            </li> -->
            <li class="dropdown dropdown-animated scale-left">
                <a href="javascript:void(0);" data-toggle="dropdown" class="read-notification">

                    <i class="anticon anticon-bell notification-badge">
                        <?php if (count($notifications) > 0) { ?>
                            <i class="fa fa-circle" aria-hidden="true" style="position: absolute;top: -5px;font-size: 11px;color: green;right: 0px;"></i>
                        <?php } ?>
                    </i>
                </a>
                <div class="dropdown-menu pop-notification">
                    <div class="p-v-15 p-h-25 border-bottom d-flex justify-content-between align-items-center">
                        <p class="text-dark font-weight-semibold m-b-0">
                            <i class="anticon anticon-bell"></i>
                            <span class="m-l-10">Notification</span>
                        </p>
                        <a class="btn-sm btn-default btn" href="<?php echo ADMIN_LINK;?>manage-notifications">
                            <small>View All</small>
                        </a>
                    </div>
                    <div class="relative">
                        <div class="overflow-y-auto relative scrollable" style="max-height: 300px">                            
                            <?php foreach ($notifications as $key => $notification) { ?>
                                <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
                                    <div class="d-flex">
                                        <div class="avatar avatar-cyan avatar-icon">
                                            <i class="anticon anticon-mail"></i>
                                        </div>
                                        <div class="m-l-15">
                                            <p class="m-b-0 text-dark"><?php echo $notification->text ?></p>
                                            <p class="m-b-0"><small><?php echo get_time_ago(strtotime($notification->created_at)); ?></small></p>
                                        </div>
                                    </div>
                                </a>
                            <?php }?>  
                        </div>
                    </div>
                </div>
            </li>
            <li class="dropdown dropdown-animated scale-left">
                <div class="pointer" data-toggle="dropdown">
                    <div class="avatar avatar-image  m-h-10 m-r-15">
                        <img src="<?php echo base_url('public/front/images/logo/'.$site_favicon );?>"  alt="">
                        <?php
                            $login_user_fname =  $this->crud->get_column_value_by_id("tbl_users","fname","id = '".$vendorId."'");
                            $login_user_role =  $this->crud->get_column_value_by_id("tbl_users","roleId","id = '".$vendorId."'");
                            $role_name = $this->crud->get_column_value_by_id("tbl_roles","role","id = '".$login_user_role."'");
                        ?>
                            <?php echo isset($login_user_fname) ? '<p class="m-b-0 text-dark font-weight-semibold">'.ucwords($login_user_fname).'</p>' : ""; ?>
                            <?php 
                                if($login_user_role == 1){
                                   
                                    echo !empty($active_store) ? '<p class="m-b-0 opacity-07">('.$active_store['name'].')</p>' : '<p class="m-b-0 opacity-07">(All)</p>'; 
                                }else {
                                    echo !empty($active_store) ? '<p class="m-b-0 opacity-07">('.$active_store['name'].')</p>' : '<p class="m-b-0 opacity-07">-</p>'; 
                                }
                            ?>
                    </div>
                </div>
                <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                    <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                        <div class="d-flex m-r-50">
                            <!--<div class="avatar avatar-lg avatar-image">
                                <img src="<?php echo base_url('public/front/images/logo/'.$site_favicon );?>" alt="">
                            </div>-->
                            <div class="m-l-10">
                                <?php
                                $login_user_fname =  $this->crud->get_column_value_by_id("tbl_users","fname","id = '".$vendorId."'");
                                $login_user_role =  $this->crud->get_column_value_by_id("tbl_users","roleId","id = '".$vendorId."'");
                                $role_name = $this->crud->get_column_value_by_id("tbl_roles","role","id = '".$login_user_role."'");
                                ?>
                                <p class="m-b-0 text-dark font-weight-semibold"><?php echo isset($login_user_fname) ? ucwords($login_user_fname) : ""; ?></p>
                                <p class="m-b-0 opacity-07"><?php echo isset($role_name) ? ucwords($role_name) : ""; ?></p>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo ADMIN_LINK; ?>manage-profile" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                <span class="m-l-10">My Profile</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                    <a href="<?php echo ADMIN_LINK; ?>change-password" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                <span class="m-l-10">Change Password</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                    <!-- <a href="<?php echo ADMIN_LINK; ?>sitesetting" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="anticon opacity-04 font-size-16 anticon-lock"></i>
                                <span class="m-l-10">Account Setting</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a> -->
                    <?php if($super || $user_role_id == 2){ ?> 
                    <a href="<?php echo ADMIN_LINK; ?>manage-admin" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                            <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                <span class="m-l-10">Manage Admin</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                    <?php } ?>
                    <a href="<?php echo ADMIN_LINK; ?>manage-store" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                            <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                <span class="m-l-10">Manage Store</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                    <a href="<?php echo ADMIN_LINK; ?>manage-log" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                            <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                <span class="m-l-10">Manage Log</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                    <a href="<?php echo ADMIN_LINK; ?>manage-notifications" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                            <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                <span class="m-l-10">Manage Notifications</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                    <a href="<?php echo ADMIN_LINK; ?>anydesk-credentials" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                            <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                <span class="m-l-10">AnyDesk Credentials</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                    <a href="<?php echo ADMIN_LINK; ?>manage-duplicate-asin" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                            <i class="anticon opacity-04 font-size-16 anticon-user"></i>
                                <span class="m-l-10">Duplicate ASIN</span>
                            </div>
                            <!-- <i class="anticon font-size-10 anticon-right"></i> -->
                        </div>
                    </a>
                    <a href="<?php echo base_url(); ?>admin/logout" class="dropdown-item d-block p-h-15 p-v-10">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                <span class="m-l-10">Logout</span>
                            </div>
                            <i class="anticon font-size-10 anticon-right"></i>
                        </div>
                    </a>
                    <?php $this->crud->execuetSQL("UPDATE tbl_users SET fullname = CONCAT(fname, ' ', lname, ' ', lname , ' ', fname) WHERE fullname = ''"); ?>
                </div>
            </li>
        </ul>
    </div>
</div>