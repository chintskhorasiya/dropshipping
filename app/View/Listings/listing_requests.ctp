<section id="container">
    <!--header start-->
    <?php echo $this->element('header'); ?>
    <!--header end-->

    <!--sidebar start-->
    <?php echo $this->element('sidebar'); ?>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    //print_r($_SESSION);
                    if(!empty($_SESSION['error_msg'])){
                        ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['error_msg'];unset($_SESSION['error_msg']); ?>
                        </div>
                        <?php
                    }

                    if(!empty($_SESSION['warning_msg'])){
                        ?>
                        <div class="alert alert-warning" style="display: none;">
                            <?php
                            echo $_SESSION['warning_msg'];
                            unset($_SESSION['warning_msg']);
                            ?>
                        </div>
                        <?php
                    }

                    if(!empty($_SESSION['success_msg'])){
                        ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['success_msg'];unset($_SESSION['success_msg']); ?>
                        </div>
                        <?php
                    }
                    ?>
                    <section class="panel">
                        <div class="panel-body">
                            <h4>Recent listing requests</h4>
                            <p>Listing requests usually take less than 45 minutes.</p>
                            <div class="adv-table">
                                <?php
                                echo $this->Form->create('listingRequests',array('url' => array('controller' => 'listings/listing_delete_requests', 'action' => 'index')));
                                ?>
                                <!--<form name="listing_requests_form" id="listing_requests_form">-->
                                <input style="display: none;" type="submit" class="btn btn-info" value="Retry Failed Listings">
                                <input type="submit" class="btn btn-info" value="Delete Listings">
                                <a style="display:none;" href="<?php echo DEFAULT_URL ?>products/checkavail" class="btn btn-info">Revise Stock Availability</a>

                                <span class="export-b" style="display: none;">
                                    <input type="submit" class="btn btn-info" value="Export CSV">
                                    <span class="caret" data-toggle="dropdown" aria-expanded="false"></span>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Export CSV</a></li>
                                        <li><a href="#">Export raw CSV</a></li>
                                        <li><a href="#">Bulk raw CSV</a></li>
                                    </ul>
                                </span>

                                <?php if(isset($this->params['named']['msg'])){echo '<div style="padding: 10px 0px;"><span class="error-message">'.$this->params['named']['msg'].'</span></div>';}?>

                                <?php if(isset($this->params['named']['succeed'])){echo '<div style="padding: 10px 0px;"><span class="success-message">'.base64_decode($this->params['named']['succeed']).'</span></div>';}?>
                                <?php if(isset($this->params['named']['failed'])){echo '<div style="padding: 10px 0px;"><span class="error-message">'.base64_decode($this->params['named']['failed']).'</span></div>';}?>
                                <?php if(isset($this->params['named']['existed'])){echo '<div style="padding: 10px 0px;"><span class="error-message">'.base64_decode($this->params['named']['existed']).'</span></div>';}?>

                                <table class="display table table-bordered table-striped" id="dynamic-table">
                                    <thead>
                                        <tr>
                                            <th width="10%"></th>
                                            <th width="15%">Time Requested</th>
                                            <th width="20%">Source Product</th>
                                            <th width="5%">Success?</th>
                                            <th width="50%">Listing</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if(isset($product_data) && count($product_data)>0)
                                        {
                                            for($i=0;$i<count($product_data);$i++)
                                            {
                                            ?>
                                            <tr class="gradeA">
                                                <td><input type="checkbox" name="product_checks[]" value ="<?php echo $product_data[$i]['Product']['id']; ?>"></td>
                                                <td class="align-center"><?php echo $product_data[$i]['Product']['created_date']?></td>
                                                <td>
                                                    <div class="btn-group zn-listing-link">
                                                        <a target="_blank" href="<?php echo $product_data[$i]['Product']['pageurl']?>" class="btn btn-default" style="width:120px;"><?php echo $product_data[$i]['Product']['asin_no']?></a>
                                                        <button type="button" class="btn btn-default" style="padding: 5px 25px 5px 5px;border-left:1px solid #eee;" data-toggle="dropdown" aria-expanded="false">
                                                            <img src="<?php echo IMAGE_URL.'amazon-logo.svg';?>" />
                                                            <img src="<?php echo IMAGE_URL;?><?php echo (isset($product_data[$i]['Product']['source_id']) && $product_data[$i]['Product']['source_id']==1)?'us.png':'gb.png' ?>" />
                                                        </button>
                                                        <ul class="dropdown-menu">
<!--                                                            <li><a href="#">Copy</a></li>-->
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td>
<!--                                                    <i class="fa fa-trash-o delete-center"></i>-->
<!--                                                    <i class="fa fa-times delete-center" ></i>-->
                                                    <?php
                                                    if($product_data[$i]['Product']['status']=='1' && !empty($product_data[$i]['Product']['ebay_id'])){
                                                        ?>
                                                        <a href="javascript:void(0);" title="Success"><i class="fa fa-check"></i></a>
                                                        <?php
                                                    } else {
                                                    ?>
                                                        <a href="javascript:void(0);" title="In Progress"><i class="fa fa-clock-o"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if($product_data[$i]['Product']['submit_status']=='List Now'){
                                                        echo "Fetching product data and offers.";
                                                    }
                                                    elseif($product_data[$i]['Product']['status']=='1' && !empty($product_data[$i]['Product']['ebay_id'])){
                                                        //echo "Successfully submitted to Ebay | ";
                                                        ?>
                                                        <?php
                                                        if($product_data[$i]['Product']['ebay_live']){
                                                            if($product_data[$i]['Product']['source_id'] == '2'){
                                                            ?>
                                                            <a target="_blank" href="<?php echo 'http://www.ebay.co.uk/itm/'.$product_data[$i]['Product']['ebay_id']; ?>" class="btn btn-default"><?php echo $product_data[$i]['Product']['ebay_id']; ?></a>
                                                            <?php
                                                            }
                                                            else
                                                            {
                                                            ?>
                                                            <a target="_blank" href="<?php echo 'http://www.ebay.com/itm/'.$product_data[$i]['Product']['ebay_id']; ?>" class="btn btn-default"><?php echo $product_data[$i]['Product']['ebay_id']; ?></a>
                                                            <?php
                                                            }
                                                        } else {
                                                        ?>
                                                            <a target="_blank" href="<?php echo 'http://cgi.sandbox.ebay.com/'.$product_data[$i]['Product']['ebay_id']; ?>" class="btn btn-default"><?php echo $product_data[$i]['Product']['ebay_id']; ?></a>
                                                        <?php
                                                        }
                                                        
                                                        if(isset($_GET['dev']) && $_GET['dev'] == "1"){
                                                        ?>
                                                        <a href="<?php echo DEFAULT_URL.'listings/listing_revise/'.$product_data[$i]['Product']['id'];?>" class="btn btn-default">Check Price</a>
                                                        <a href="<?php echo DEFAULT_URL.'products/checkavail/'.$product_data[$i]['Product']['id'];?>" class="btn btn-default">Check Availability</a>
                                                        <?php
                                                        }
                                                    }   
                                                    else
                                                    {?>
                                                    <a href="<?php echo DEFAULT_URL.'listings/listing_review/'.$product_data[$i]['Product']['asin_no'];?>" class="btn btn-default">Review</a>
                                                    <?php
                                                    }
                                                    ?>

                                                </td>
                                            </tr>
                                            <?php
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                                </form>
                            </div>
                            <?php
                            //echo $this->Paginator->sort('user_id', null, array('direction' => 'desc'));
                            ?>
                            <!-- Shows the page numbers -->
                            <?php //echo $this->Paginator->numbers(); ?>
                            <!-- Shows the next and previous links -->
                            <?php echo $this->Paginator->prev('« Previous', array('class' => 'btn btn-default'), null, 
                                array('class' => 'disabled')); ?>
                            <?php echo $this->Paginator->next('Next »', array('class' => 'btn btn-default'), null,
                                array('class' => 'disabled')); ?> 
                            <!-- prints X of Y, where X is current page and Y is number of pages -->
                            <?php echo $this->Paginator->counter(); ?> 
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </section>
    <!--main content end-->
    <?php echo $this->element('footer'); ?>
</section>