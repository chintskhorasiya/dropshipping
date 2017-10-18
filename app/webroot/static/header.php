<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>

<!--header start-->

<header class="header fixed-top clearfix"> 
  
  <!--logo start-->
  
  <div class="brand">
    <div class="sidebar-toggle-box">
      <div class="fa fa-bars"></div>
    </div>
    <a href="<?=ADMINURL?>dashboard.php" class="logo" style="">Dropshipping Management Application</a> </div>
  
  <!--logo end-->
  
  <?php

/* $user_new_messages = get_user_unread_messages_count(); */

?>
  <div class="nav notify-row" id="top_menu">
  
  <!--  notification start -->
  
  <ul class="nav top-menu">
    
    <!-- settings start -->
    
    <?php   

              foreach($get_notification as $not_detail)

				{

					$notification_id 		= $not_detail['notification_id'];

					$notification_user 		= $not_detail['notification_user'];

					$notification_user_id	= $not_detail['notification_user_id'];

					$notification_type		= $not_detail['notification_type'];

					$notification_product_id	= $not_detail['notification_product_id'];

					$notification_read		= $not_detail['notification_read'];

				}

         		?>
    <?php 

                $get_task_not = get_task_not(1);

                $get_count = get_count_notification(1);

            ?>
    
    <!--<li class="dropdown">

                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                     <i class="fa fa-envelope-o"></i>

                        <span class="badge bg-success"><?=$get_count?></span>

                    </a>

                    

                      <ul class="dropdown-menu extended tasks-bar">

						<?php

                          foreach($get_task_not as $not_detail)

                            {

								$notification_id 		= $not_detail['notification_id'];

								$notification_user 		= $not_detail['notification_user'];

								$notification_user_id		= $not_detail['notification_user_id'];

								$notification_type		= $not_detail['notification_type'];

								$notification_product_id		= $not_detail['notification_product_id'];

								$notification_read		= $not_detail['notification_read'];

	                     ?>

                <?php

						$get_message_notif = get_message_notif($notification_product_id);

						foreach($get_message_notif as $not_detail)

						{

							$adminsupport_id 		= $not_detail['adminsupport_id'];

							$adminsupport_subject 		= $not_detail['adminsupport_subject'];

							$adminsupport_content 		= $not_detail['adminsupport_content'];

							$adminsupport_from 		= $not_detail['adminsupport_from'];

							$adminsupport_paent 		= $not_detail['adminsupport_parent'];

							$adminsupport_to 		= $not_detail['adminsupport_to'];

							$adminsupport_date 		= $not_detail['adminsupport_date'];

							$support_for 		= $not_detail['support_for'];

							if($support_for == 1)

							{				

								$get_reviewer_name = get_reviewer_name($adminsupport_from);

							}

							else

							{

								$get_reviewer_name = get_destrireviewer_name($adminsupport_from);

							}

					?>

                        <li>

                            <a href="#">

                                <div class="task-info clearfix">

                                    <div class="desc pull-left">

                                        <h5><?=$get_reviewer_name?></h5>

                                        <p><?=$adminsupport_content?></p>

                                    </div>

                                  <!-- <span class="notification-pie-chart pull-right" data-percent="45"> --> 
    
    <!--  <span class="percent"></span> --> 
    
    </span>
    </div>
    </a>
    </li>
    <?php

				}

				}

		 ?>
    <li class="external"> <a href="storesupport.php">See all Message</a> </li>
  </ul>
  </li>
  -->
  
  <?php $get_customer_count = get_count_notification(12);?>
  <li id="header_inbox_bar" class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="fa fa-flask"></i> <span class="badge bg-warning">
    <?=$get_customer_count?>
    </span> </a>
    <ul class="dropdown-menu extended inbox">
      <li>
        <p class="red">You have
          <?=$get_customer_count?>
          New Products</p>
      </li>
      <li> <a href="<?=ADMINURL?>products.php?newpnid=12&pid=1">See all New Products</a> </li>
    </ul>
  </li>
  <?php $get_customer_count = get_count_notification(14);?>
  <li id="header_inbox_bar" class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="fa fa-user"></i> <span class="badge bg-warning">
    <?=$get_customer_count?>
    </span> </a>
    <ul class="dropdown-menu extended inbox">
      <li>
        <p class="red">You have
          <?=$get_customer_count?>
          New Customers</p>
      </li>
      <li> <a href="<?=ADMINURL?>users.php?newunid=14">See all New Customers</a> </li>
    </ul>
  </li>
  <?php $get_merchant_count = get_count_notification(15);?>
  <li id="header_inbox_bar" class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="fa fa-user"></i> <span class="badge bg-warning">
    <?=$get_merchant_count?>
    </span> </a>
    <ul class="dropdown-menu extended inbox">
      <li>
        <p class="red">You have
          <?=$get_merchant_count?>
          New Merchants</p>
      </li>
      <li> <a href="<?=ADMINURL?>stores.php?newmnid=15">See all New Merchants</a> </li>
    </ul>
  </li>
  <?php $get_customer_count = get_count_notification(13);?>
  <li id="header_inbox_bar" class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="fa fa-user"></i> <span class="badge bg-warning">
    <?=$get_customer_count?>
    </span> </a>
    <ul class="dropdown-menu extended inbox">
      <li>
        <p class="red">You have
          <?=$get_customer_count?>
          New Distributers</p>
      </li>
      <li> <a href="<?=ADMINURL?>users.php">See all New Distributers</a> </li>
    </ul>
  </li>
  <?php $get_customer_count = get_count_notification(16);?>
  <li id="header_inbox_bar" class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <i class="fa fa-users"></i> <span class="badge bg-warning">
    <?=$get_customer_count?>
    </span> </a>
    <ul class="dropdown-menu extended inbox">
      <li>
        <p class="red">You have
          <?=$get_customer_count?>
          New B2B Customers</p>
      </li>
      <li> <a href="<?=ADMINURL?>users.php">See all B2B Customers</a> </li>
    </ul>
  </li>
  <?php /*?><?php

					$get_task_not = get_task_not(7);

					$get_count = get_count_notification(7);

				?> <?php */?>
  
  <!--<li class="dropdown">

                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                     <i class="fa fa-envelope-o"></i> 

                      <i class="fa fa-comments-o"></i>

                  <i class="fa fa-group"></i>

                       

                        <span class="badge bg-success"><?=$get_count?></span>

                    </a>

                    

                      <ul class="dropdown-menu extended tasks-bar">

			<?php

			  foreach($get_task_not as $not_detail)

				{

					

						$notification_id 		= $not_detail['notification_id'];

						$notification_user 		= $not_detail['notification_user'];

						$notification_user_id		= $not_detail['notification_user_id'];

						$notification_type		= $not_detail['notification_type'];

						$notification_product_id		= $not_detail['notification_product_id'];

						$notification_read		= $not_detail['notification_read'];

			

			 ?>

              

                <?php

						

						$get_destribute_notif = get_destribute_notif($notification_product_id);

						

						foreach($get_destribute_notif as $not_details)

						{

							pre($not_details);

							$user_id 		= $not_details['user_id'];

							$user_name 		= $not_details['user_name'];

							$user_full_name 		= $not_details['user_full_name'];

							

							$get_reviewer_name = get_reviewer_name($user_id); 

							

							

										

					?>

					   

                        <li>

                            <a href="#">

                                <div class="task-info clearfix">

                                    <div class="desc pull-left">

                                        <h5><?=$user_full_name?></h5>

                                        <p>Register For Dishtributer </p>

                                    </div>

                                   <span class="notification-pie-chart pull-right" data-percent="45"> 

                            <span class="percent"></span> 

                            </span>

                                </div>

                            </a>

                        </li>

                           <?php

				}

				}

		 ?>

                     

                        <li class="external">

                          <a href="distributor.php?user_id=<?=$user_id?>">See All New Registered Distributer </a>

                        </li>

                              

         

                    </ul>

                </li>-->
  
  <?php /*?><?php

					$get_task_not = get_customer_feedbck_notification();

					$get_count = get_count_feedbck();

					//pre($get_task_not);

					$total = $get_count['total'];

				?> <?php */?>
  <?php /*?><li class="dropdown">

                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                   <!--  <i class="fa fa-envelope-o"></i> -->

                    <!--  <i class="fa fa-comments-o"></i>-->

                  <i class="fa fa-group"></i>

                       

                        <span class="badge bg-success"><?=$total?></span>

                    </a>

                    

                      <ul class="dropdown-menu extended tasks-bar">

			<?php

			  foreach($get_task_not as $not_detail)

				{

					$f_id		=	$not_detail['f_id'];

					$f_name 	= $not_detail['f_name'];

					$f_subject = $not_detail['f_subject'];

					$f_message = $not_detail['f_message'];

			 ?>

                        <li>

                            <a href="customer-support.php?f_id=<?=$f_id?>">

                                <div class="task-info clearfix">

                                    <div class="desc pull-left">

                                        <h5><?=$f_name?></h5>

                                        <p><?=$f_subject?></p>

                                    </div>

                                  <!-- <span class="notification-pie-chart pull-right" data-percent="45"> -->

                          <!--  <span class="percent"></span> -->

                            </span>

                                </div>

                            </a>

                        </li>

                           <?php

				}

		 ?>

                     

                        <li class="external">

                          <a href="customer-support.php">See All Customer support </a>

                        </li>

                              

         

                    </ul>

                </li><?php */?>
  </ul>
  
  <!--  notification end -->
  
  </div>
  <div class="top-nav clearfix"> 
    
    <!--search & user info start-->
    
    <ul class="nav pull-right top-menu">
      
      <!-- user login dropdown start-->
      
      <?php

                	$user_detail 	= adminget_user_detail($_SESSION['ADMIN_ID']);

					$admin_image	= $user_detail['admin_image'];

				?>
      <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <img alt="" src="<?=IMAGEURL.$admin_image?>"> <span class="username">
        <?=$admin_name;?>
        </span> <b class="caret"></b> </a>
        <ul class="dropdown-menu extended logout">
          <li><a href="<?=ADMINURL?>editprofile.php"><i class=" fa fa-suitcase"></i>Profile</a></li>
          
          <!--<li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>-->
          
          <li><a href="logout.php"><i class="fa fa-key"></i> Log Out</a></li>
        </ul>
      </li>
    </ul>
    
    <!--search & user info end--> 
    
  </div>
</header>

<!--header end-->