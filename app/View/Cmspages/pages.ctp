<?php echo $this->element('sidebar'); ?>
<?php
/**/
if ($passlug == 'contact-us') {?>

    <div class="page-head">
        <div class="container">
            <div class="grid_3 grid_5 wow fadeInLeft animated" data-wow-delay=".5s">	 
                <ol class="breadcrumb">
                    <li><a href="<?php echo DEFAULT_URL; ?>">Home</a></li>
                    <li class="active">Contact Us</li>
                    <h1>Contact Us</h1>
                </ol>	 
            </div>
        </div>
    </div>
    <!-- //banner -->
    <!-- contact -->
    <div class="inner-page">
        <div class="container">
            <div class="login-grids">
                <div class="login">
                    <div class="contact-address">
                        <?php echo $cmsdata['Cmspage']['description'];?> 
						
					<div class="map wow fadeInDown animated" data-wow-delay=".5s">
                     
                     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1836.0419282584396!2d72.58995910993539!3d23.020693062195377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf3559da77e5fd449!2sBhagya+Gold+Ltd.!5e0!3m2!1sen!2s!4v1464435328656" frameborder="0" style="border:0"></iframe>
                    </div>	
                    </div>
                    <div class="login-right">
                        <h3>Contact Us</h3>
                        <form name="frmcontactus" id="frmcontactus" method="post">
                            <?php if(empty($errorarray) && isset($this->params['pass'][1]) && $this->params['pass'][1]=='sucsend'){echo '<div class="sign-up suc-message">'.SUC_SEND_CONTACT.'</div>';}?>
                            <div class="sign-up">
                                <h4>Name<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.fname', array('id' => 'fname', 'placeholder' => 'Name'))); ?>
                                <?php if (isset($errorarray['enter_fname'])) echo "<span class='error-message server'>" . $errorarray['enter_fname'] . "</span>"; ?>
                                <?php if (isset($errorarray['fname_not_numeric'])) echo "<span class='error-message server'>" . $errorarray['fname_not_numeric'] . "</span>"; ?>
                            </div>
                            
                            <div class="sign-in">
                                <h4>Email<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.email', array('id' => 'email', 'placeholder' => 'Email'))); ?>
                                <?php if (isset($errorarray['enter_email'])) echo "<span class='error-message'>" . $errorarray['enter_email'] . "</span>"; ?>
                                <?php if (isset($errorarray['valid_email'])) echo "<span class='error-message'>" . $errorarray['valid_email'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Mobile<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.mobile', array('id' => 'mobile', 'placeholder' => 'Mobile'))); ?>
                                <?php if (isset($errorarray['enter_mobile'])) echo "<br><span class='error-message server'>" . $errorarray['enter_mobile'] . "</span>"; ?>
                                <?php if (isset($errorarray['numeric_mobile'])) echo "<br><span class='error-message server'>" . $errorarray['numeric_mobile'] . "</span>"; ?>
                                <?php if (isset($errorarray['mobile_length'])) echo "<br><span class='error-message server'>" . $errorarray['mobile_length'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Message<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->textarea('User.message', array('id' => 'message', 'class' => 'bg-focus form-control','placeholder' => 'Message'))); ?>
                                <?php if (isset($errorarray['enter_message'])) echo "<span class='error-message server'>" . $errorarray['enter_message'] . "</span>"; ?>
                            </div>
                            <div class="sign-in padd15" >
                                <input type="submit" name="btncontact" id="btncontact" value="Submit" >
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            
            

        </div>
    </div>
    <?php
} 
else if ($passlug == 'career') {?>
    
    <div class="page-head">
        <div class="container">
            <div class="grid_3 grid_5 wow fadeInLeft animated" data-wow-delay=".5s">	 
                <ol class="breadcrumb">
                    <li><a href="<?php echo DEFAULT_URL; ?>">Home</a></li>
                    <li class="active">Career</li>
                    <h1>Career</h1>
                </ol>	 
            </div>
        </div>
    </div>
    <!-- //banner -->
    <div class="inner-page">
        <div class="container">
            <div class="login-grids">
                <div class="login">
                    <div class="login-bottom center-form">
                        <form name="frmcareer" id="frmcareer" method="post" enctype="multipart/form-data">
                            <?php if(empty($errorarray) && isset($this->params['pass'][1]) && $this->params['pass'][1]=='sucsend'){echo '<div class="sign-up suc-message">'.ALLPIED_JOB_SUCCESS.'</div>';}?>
                            
                            <div class="sign-up">
                                <h4>Job Title<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.job_title', array('id' => 'job_title', 'placeholder' => 'Job Title'))); ?>
                                <?php if (isset($errorarray['enter_job_title'])) echo "<span class='error-message server'>" . $errorarray['enter_job_title'] . "</span>"; ?>
                                <?php if (isset($errorarray['job_title_not_numeric'])) echo "<span class='error-message server'>" . $errorarray['job_title_not_numeric'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Name<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.fname', array('id' => 'fname', 'placeholder' => 'Name'))); ?>
                                <?php if (isset($errorarray['enter_fname'])) echo "<span class='error-message server'>" . $errorarray['enter_fname'] . "</span>"; ?>
                                <?php if (isset($errorarray['fname_not_numeric'])) echo "<span class='error-message server'>" . $errorarray['fname_not_numeric'] . "</span>"; ?>
                            </div>
                            
                            <div class="sign-in">
                                <h4>Email<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.email', array('id' => 'email', 'placeholder' => 'Email'))); ?>
                                <?php if (isset($errorarray['enter_email'])) echo "<span class='error-message'>" . $errorarray['enter_email'] . "</span>"; ?>
                                <?php if (isset($errorarray['valid_email'])) echo "<span class='error-message'>" . $errorarray['valid_email'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Mobile<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->text('User.mobile', array('id' => 'mobile', 'placeholder' => 'Mobile'))); ?>
                                <?php if (isset($errorarray['enter_mobile'])) echo "<br><span class='error-message server'>" . $errorarray['enter_mobile'] . "</span>"; ?>
                                <?php if (isset($errorarray['numeric_mobile'])) echo "<br><span class='error-message server'>" . $errorarray['numeric_mobile'] . "</span>"; ?>
                                <?php if (isset($errorarray['mobile_length'])) echo "<br><span class='error-message server'>" . $errorarray['mobile_length'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Message<span class="error-message">*</span> :</h4>
                                <?php echo ($this->Form->textarea('User.message', array('id' => 'message', 'class' => 'bg-focus form-control','placeholder' => 'Message'))); ?>
                                <?php if (isset($errorarray['enter_message'])) echo "<span class='error-message server'>" . $errorarray['enter_message'] . "</span>"; ?>
                            </div>
                            <div class="sign-up">
                                <h4>Upload Resume<span class="error-message">*</span> :</h4>
                                <input type="file" name="resume" id="resume" >
                                <?php if (isset($errorarray['select_resume'])) echo "<span class='error-message server'>" . $errorarray['select_resume'] . "</span>"; ?>
                                <?php if (isset($errorarray['filecorrupt'])) echo "<span class='error-message server'>" . $errorarray['filecorrupt'] . "</span>"; ?>
                                <?php if (isset($errorarray['validfile'])) echo "<span class='error-message server'>" . $errorarray['validfile'] . "</span>"; ?>
                                <?php if (isset($errorarray['enter_message'])) echo "<span class='error-message server'>" . $errorarray['enter_message'] . "</span>"; ?>
                            </div>
                            
                            <div class="sign-in padd15" >
                                <input type="submit" name="btncareer" id="btncareer" value="Submit" >
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
<?php
}
else {
    ?>
    <div class="page-head">
        <div class="container">
            <div class="grid_3 grid_5 wow fadeInLeft animated" data-wow-delay=".5s">	 
                <ol class="breadcrumb">
                    <li><a href="<?php echo DEFAULT_URL; ?>">Home</a></li>
                    <li class="active"><?php echo $cmsdata['Cmspage']['name']; ?></li>
                    <h1><?php echo $cmsdata['Cmspage']['name']; ?></h1>
                </ol>	 
            </div>

        </div>
    </div>
    <!-- //banner --> 
    <div class="inner-page">
        <div class="container">	
            <div class="content">
                <?php echo $cmsdata['Cmspage']['description']; ?>
            </div> 
            <div class="clearfix"></div>
        </div>
    </div>
    <?php
}


/* elseif ($passlug == 'inquiry-form') {
  ?>


  <div class="" style="width: 950px;float: left;margin-bottom: 2%;">
  <div class="content_contactus" style="margin-right: 20%;">
  <h3 class="label_title">Inquiry Form</h3>
  <?php if(isset($this->params['pass'][0]) && $this->params['pass'][0]==SENDEMAIL){ echo "<div class='success'>".SUCCESS_MSG."</div>";} ?>
  <form method="post" name="contactform" action="">
  <div style="width:500px;margin-top: 8px;">
  <div class="label"> Name <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.contact_name', array('label'=>false,'div'=>false, 'id'=>'contact_name' , 'class'=>' required')));?>
  <?php if(isset($enter_contact_name)){echo "<div class='error-conmessage'>".ENTER_CONTACTNAME."</div>";}?>
  </div>
  </div>
  <div class="label">
  Email Address <span class="redstar">*</span>
  </div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.contact_email_add', array('label'=>false,'div'=>false, 'id'=>'contact_email_add' , 'class'=>' required')));?>
  <?php if(isset($enter_email)){echo "<div class='error-conmessage'>".ENTER_CONTACTEMAIL."</div>";}?>
  <?php if(isset($enter_valid_email_add)){echo "<div class='error-conmessage'>".ENTER_VALIDEMAIL."</div>";}?>
  </div>

  <div class="label">Phone No <span class="redstar">*</span> </div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.contact_no', array('label'=>false,'div'=>false, 'id'=>'contact_no' , 'class'=>' required')));?>
  <?php if(isset($enter_contact_no)){echo "<div class='error-conmessage'>".ENTER_CONTACTPHONE."</div>";}?>
  </div>

  <div class="label">City </div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.city', array('label'=>false,'div'=>false, 'id'=>'contact_no' , 'class'=>' required')));?>

  </div>

  <div class="label">Pincode  </div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.pincode', array('label'=>false,'div'=>false, 'id'=>'contact_no' , 'class'=>' required')));?>

  </div>
  <div class="label">Product Quantity </div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.product_quantity', array('label'=>false,'div'=>false, 'id'=>'contact_no' , 'class'=>' required')));?>
  </div>
  <div class="label">Product Code </div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.product_code', array('label'=>false,'div'=>false, 'id'=>'contact_no' , 'class'=>' required')));?>
  </div>
  <div class="label">Message <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.contact_msg', array('label'=>false,'div'=>false, 'id'=>'contact_msg' , 'class'=>' required','type'=>'textarea')));?>
  <?php if(isset($enter_contact_msg)){echo "<div class='error-conmessage'>".ENTER_CONTACTMSG."</div>";}?>
  </div>
  <div class="label">      </div>
  <div class="label_field contact-submit">
  <input type="submit" value="Send Message" />
  </div>
  </form>
  </div>
  </div>


  <?php
  }
  elseif ($passlug == 'free-sample') {
  ?>

  <div class="" style="width: 950px;float: left;margin-bottom: 2%;">
  <div class="content_contactus" style="margin-right: 20%;">
  <h3 class="label_title">Free Sample</h3>
  <?php if(isset($this->params['pass'][1]) && $this->params['pass'][1]==SENDEMAIL){echo "<div class='success'>".SUCCESS_MSG."</div>";} ?>
  <form method="post" name="contactform" action="">

  <div style="width:500px;margin-top: 8px;font-weight: bold;">
  <h5>Product Specification </h5>
  <div class="label" style="font-weight: lighter;"> Size <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.size', array('label'=>false,'div'=>false, 'id'=>'size' , 'class'=>' required')));?>
  <?php if(isset($enter_size)){echo "<div class='error-conmessage'>".ENTER_PRODUCT_SIZE."</div>";}?>
  </div>
  </div>
  <div class="label">Material <span class="redstar">*</span>
  </div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.material', array('label'=>false,'div'=>false, 'id'=>'material' , 'class'=>' required')));?>
  <?php if(isset($enter_material)){echo "<div class='error-conmessage'>".ENTER_MATERIAL."</div>";}?>
  <?php //if(isset($enter_valid_email)){echo "<div class='error-conmessage'>".ENTER_VALIDEMAIL."</div>";}?>
  </div>

  <div class="label">Printing <span class="redstar">*</span> </div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.printing', array('label'=>false,'div'=>false, 'id'=>'printing' , 'class'=>' required')));?>
  <?php if(isset($enter_printing)){echo "<div class='error-conmessage'>".ENTER_PRINTING."</div>";}?>
  </div>

  <div class="label">Other Features <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.other_feature', array('label'=>false,'div'=>false, 'id'=>'other_feature' , 'class'=>' required')));?>
  <?php if(isset($enter_other_feature)){echo "<div class='error-conmessage'>".ENTER_OTHER_FEATURE."</div>";}?>
  </div>

  <div class="label">Sample QTY  <span class="redstar">*</span> </div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.sample_qty', array('label'=>false,'div'=>false, 'id'=>'sample_qty' , 'class'=>' required')));?>
  <?php if(isset($enter_sample_qty)){echo "<div class='error-conmessage'>".ENTER_SAMPLE_QTY."</div>";}?>

  </div>
  <div class="label">Order QTY <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.order_qty', array('label'=>false,'div'=>false, 'id'=>'order_qty' , 'class'=>' required')));?>
  <?php if(isset($enter_order_qty)){echo "<div class='error-conmessage'>".ENTER_ORDER_QTY."</div>";}?>
  </div>
  <div style="float: left;font-weight: bold; margin-left: 5px; margin-top: 8px;width: 500px;">
  <h5>Customer Information </h5></div>
  <div class="label">Express/Shipper Account Number <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.ac_no', array('label'=>false,'div'=>false, 'id'=>'ac_no' , 'class'=>' required')));?>
  <?php if(isset($enter_ac_no)){echo "<div class='error-conmessage'>".ENTER_ACCOUNT_NO."</div>";}?>
  </div>
  <div class="label">Express Name <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.exp_name', array('label'=>false,'div'=>false, 'id'=>'exp_name' , 'class'=>' required','type'=>'text')));?>
  <?php if(isset($enter_exp_name)){echo "<div class='error-conmessage'>".ENTER_EXPRESS_NAME."</div>";}?>
  </div>
  <div class="label">Customer Name <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.cust_name', array('label'=>false,'div'=>false, 'id'=>'cust_name' , 'class'=>' required','type'=>'text')));?>
  <?php if(isset($enter_cust_name)){echo "<div class='error-conmessage'>".ENTER_CUSTOMER_NAME."</div>";}?>
  </div>
  <div class="label">Company Name <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.cmp_name', array('label'=>false,'div'=>false, 'id'=>'cmp_name' , 'class'=>' required','type'=>'text')));?>
  <?php if(isset($enter_cmp_name)){echo "<div class='error-conmessage'>".ENTER_COMPANYNAME."</div>";}?>
  </div>
  <div class="label">Email Id <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.cmp_email', array('label'=>false,'div'=>false, 'id'=>'cmp_email' , 'class'=>' required','type'=>'text')));?>
  <?php if(isset($enter_email_id)){echo "<div class='error-conmessage'>".ENTER_EMAIL."</div>";}?>
  <?php //if(isset($enter_valid_email)){echo "<div class='error-conmessage'>".ENTER_VALIDEMAIL."</div>";}?>
  </div>
  <div class="label">Address <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.cmp_address', array('label'=>false,'div'=>false, 'id'=>'cmp_address' , 'class'=>' required','type'=>'textarea')));?>
  <?php if(isset($enter_cmp_address)){echo "<div class='error-conmessage'>".ENTER_ADDRESS."</div>";}?>
  </div>
  <div class="label">Postal Code <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.cmp_postalcode', array('label'=>false,'div'=>false, 'id'=>'cmp_postalcode' , 'class'=>' required','type'=>'text')));?>
  <?php if(isset($enter_cmp_postalcode)){echo "<div class='error-conmessage'>".ENTER_POSTALCODE."</div>";}?>
  </div>
  <div class="label">Contact Us  <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.cmp_contactus', array('label'=>false,'div'=>false, 'id'=>'cmp_contactus' , 'class'=>' required','type'=>'text')));?>
  <?php if(isset($enter_cmp_contactus)){echo "<div class='error-conmessage'>".ENTER_CONTACTPHONE."</div>";}?>
  </div>
  <div class="label">Country  <span class="redstar">*</span></div>
  <div class="label_field">
  <?php echo ($this->Form->input('User.cmp_country', array('label'=>false,'div'=>false, 'id'=>'cmp_country' , 'class'=>' required','type'=>'text')));?>
  <?php if(isset($enter_cmp_country)){echo "<div class='error-conmessage'>".ENTER_CONTRY."</div>";}?>
  </div>
  <div class="label">      </div>
  <div class="label_field contact-submit">
  <input type="submit" value="Submit" />
  </div>
  </form>
  </div>
  </div>

  <?php } */
?>
