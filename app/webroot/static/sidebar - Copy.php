<!--sidebar start-->

<aside>
  <nav>
    <div id="sidebar" class="nav-collapse">
      <div class="leftside-navigation"> 
        
        <!-- sidebar menu start-->
        
        <ul class="sidebar-menu" id="nav">
          <a id="active" class="active" href="<?=ADMINURL?>dashboard.php">
          <li class="desh"> <i class="fa fa-dashboard"></i> <span>Dashboard</span> </li>
          </a>
          
           
          <li class="sub-menu"> <a href="#"> <i class="fa fa-tags"></i> <span>Stores</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>store-setting.php"><i class="fa fa-eye"></i>Store Setting</a></li>			  <li><a href="<?=ADMINURL?>store-stats.php"><i class="fa fa-eye"></i>Store Stats</a></li>
              <li><a href="<?=ADMINURL?>store-add.php"><i class="fa fa-plus-circle"></i>Add Store</a></li>
            </ul>
          </li>
          
		  <li class="sub-menu"> <a href="#"> <i class="fa fa-tags"></i> <span>Add Source</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>amazon-us.php"><i class="fa fa-eye"></i>Amazon US</a></li>
			  <li><a href="<?=ADMINURL?>amazon-uk.php"><i class="fa fa-eye"></i>Amazon UK</a></li> 
            </ul>
          </li>
		  
		  <li class="sub-menu"> <a href="#"> <i class="fa fa-tags"></i> <span>Create Listings</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>create-listing.php"><i class="fa fa-eye"></i>Create Listings</a></li>
			  <li><a href="<?=ADMINURL?>listing-requests.php"><i class="fa fa-eye"></i>Listing Requests</a></li> 
            </ul>
          </li>
		  
		  <li class="sub-menu"> <a href="#"> <i class="fa fa-tags"></i> <span>Listing Settings</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>edit-lister-template.php"><i class="fa fa-eye"></i>Listing Template</a></li>
			  <li><a href="<?=ADMINURL?>manage-listing-blacklists.php"><i class="fa fa-eye"></i>Manage Listing Blacklists</a></li>
            </ul>
          </li>
		  		  <?php if(accessPermission('1,6')){ ?>          <li class="sub-menu"> <a href="<?=ADMINURL?>orders.php"> <i class="fa fa-tags"></i> <span>Orders</span> </a>            <ul class="sub">              <li><a href="<?=ADMINURL?>cod-orders.php"><i class="fa fa-eye"></i>COD Orders</a></li>              <li><a href="<?=ADMINURL?>online-orders.php"><i class="fa fa-eye"></i>Online Payment Orders</a></li>              <li><a href="<?=ADMINURL?>orders.php"><i class="fa fa-eye"></i>Order Status</a></li>              <li><a href="<?=ADMINURL?>orders.php"><i class="fa fa-eye"></i>Order Payment Fail</a></li>              <li><a href="<?=ADMINURL?>orders.php"><i class="fa fa-eye"></i>Order Fail</a></li>              <li><a href="<?=ADMINURL?>cancelled-orders.php"><i class="fa fa-plus-circle"></i>Orders Cancelled</a></li>            </ul>          </li>          <?php } ?>
          <?php if(accessPermission('1')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-file-o"></i> <span>Pages</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>pages.php"><i class="fa fa-eye"></i>View Page</a></li>
              <li><a href="<?=ADMINURL?>page-add.php"><i class="fa fa-plus-circle"></i>Add Page</a></li>
            </ul>
          </li>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-sitemap"></i> <span>Country</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>countries.php"><i class="fa fa-eye"></i>View Country</a></li>
              <li><a href="<?=ADMINURL?>states.php"><i class="fa fa-eye"></i>View State</a></li>
              <li><a href="<?=ADMINURL?>cities.php"><i class="fa fa-eye"></i>View City</a></li>
              <li><a href="<?=ADMINURL?>country-add.php"><i class="fa fa-plus-circle"></i>Add Country</a></li>
              <li><a href="<?=ADMINURL?>state-add.php"><i class="fa fa-plus-circle"></i>Add State</a></li>
              <li><a href="<?=ADMINURL?>city-add.php"><i class="fa fa-plus-circle"></i>Add City</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if(accessPermission('1,2,3')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-sitemap"></i> <span>Brand Manager</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>brands.php"><i class="fa fa-eye"></i>View Brand</a></li>
              <li><a href="<?=ADMINURL?>brand-add.php"><i class="fa fa-plus-circle"></i>Add Brand</a></li>
            </ul>
          </li>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-tasks"></i> <span>Category</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>categories.php"><i class="fa fa-eye"></i>View Category</a></li>
              <li><a href="<?=ADMINURL?>category-add.php"><i class="fa fa-plus-circle"></i>Add Category</a></li>
            </ul>
          </li>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-flask"></i> <span>Products</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>products.php"><i class="fa fa-eye"></i>View Products</a></li>
              <li><a href="<?=ADMINURL?>product-add.php"><i class="fa fa-plus-circle"></i>Add Products</a></li>
              <li><a href="<?=ADMINURL?>bulkupload.php"><i class="fa fa-cloud-upload"></i>Bulk Uploads</a></li>
              <li><a href="<?=ADMINURL?>inquiries.php"><i class="fa fa-comments-o"></i>Product Inquiries</a></li>
              <li><a href="<?=ADMINURL?>reviews.php"><i class="fa fa-star-o"></i>Product Reviews</a></li>
            </ul>
          </li>
          <li class="sub-menu"> <a href="<?=ADMINURL?>variations.php"> <i class="fa fa-th-large"></i> <span>Variatiions</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>variation.php"><i class="fa fa-eye"></i>View Variation</a></li>
              <li><a href="<?=ADMINURL?>variation-add.php"><i class="fa fa-plus-circle"></i>Add Variation</a></li>
              <li><a href="<?=ADMINURL?>variation-values-add.php"><i class="fa fa-plus-circle"></i>Add Variation Value</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if(accessPermission('1')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-group"></i> <span>Customers</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>users.php"><i class="fa fa-eye"></i>View Customers</a></li>
              <li><a href="<?=ADMINURL?>user-add.php"><i class="fa fa-plus-circle"></i>Add Customers</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if(accessPermission('1')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-user"></i> <span>User Roles</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>pk-users.php"><i class="fa fa-eye"></i>View User Roles</a></li>
              <li><a href="<?=ADMINURL?>pk-user-add.php"><i class="fa fa-plus-circle"></i>Add User Roles</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if(accessPermission('1,5')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-tags"></i> <span>B2B Stores</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>b2bstore.php"><i class="fa fa-eye"></i>View B2B Stores</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if(accessPermission('1,6')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-truck"></i> <span>Delivery Day Options</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>delivery.php"><i class="fa fa-eye"></i>Delivery</a></li>
              <li><a href="<?=ADMINURL?>delivery-add.php"><i class="fa fa-plus-circle"></i>Add Delivery</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if(accessPermission('1,2')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-gears"></i> <span>Settings</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>settings.php"><i class="fa fa-unlock-alt"></i>Change Password</a></li>
              <li><a href="<?=ADMINURL?>sel-front-category.php"><i class="fa fa-tasks"></i>Front Product Boxs</a></li>
              <li><a href="<?=ADMINURL?>sel-front-sidebar-category.php"><i class="fa fa-tasks"></i>Front Sidebar Category</a></li>
              <li><a href="<?=ADMINURL?>set-front-menu-category.php"><i class="fa fa-tasks"></i>Front Menu Category</a></li>
              <li><a href="<?=ADMINURL?>latest_offer.php"><i class="fa fa-tasks"></i>Front Latest Offer Section</a></li>
              <li><a href="<?=ADMINURL?>advertise.php"><i class="fa fa-tasks"></i>Add Advertisement</a></li>
              <li><a href="<?=ADMINURL?>slider-add.php"><i class="fa fa-tasks"></i>Add Slider</a></li>
              <li><a href="<?=ADMINURL?>footer-settings.php"><i class="fa fa-tasks"></i>Footer Menu</a></li>
              <li><a href="<?=ADMINURL?>advanced-settings.php"><i class="fa fa-tasks"></i>Advanced Setting</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if(accessPermission('1,7')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-credit-card"></i> <span>Coupons</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>coupons.php"><i class="fa fa-eye"></i>Coupons</a></li>
              <li><a href="<?=ADMINURL?>coupon-add.php"><i class="fa fa-plus-circle"></i>Add Coupon</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if(accessPermission('1,7')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-file-text-o"></i> <span>E Gifts</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>eGift.php"><i class="fa fa-eye"></i>View E-Gifts</a></li>
              <li><a href="<?=ADMINURL?>eGift_add.php"><i class="fa fa-plus-circle"></i>Add E-Gift</a></li>
            </ul>
          </li>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-file-text-o"></i> <span>E Wallets</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>eWallet.php"><i class="fa fa-eye"></i>View E-Wallet</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if(accessPermission('1,4')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-file-text-o"></i> <span>Transaction</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>transaction_success.php"><i class="fa fa-eye"></i>Successful Transaction</a></li>
              <li><a href="<?=ADMINURL?>transaction_failed.php"><i class="fa fa-plus-circle"></i>Failed Transaction</a></li>
            </ul>
          </li>
          <?php }?>
          <?php if(accessPermission('1')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-truck"></i> <span>Shipping</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>shipping.php"><i class="fa fa-eye"></i>View Shipping</a></li>
              <li><a href="<?=ADMINURL?>shipping-add.php"><i class="fa fa-plus-circle"></i>Add Shipping</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if(accessPermission('1')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-file-text-o"></i> <span>FAQs</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>faq-cat.php"><i class="fa fa-eye"></i>View FAQ Category</a></li>
              <li><a href="<?=ADMINURL?>faqcat-add.php"><i class="fa fa-plus-circle"></i>Add FAQ Category</a></li>
              <li><a href="<?=ADMINURL?>faq.php"><i class="fa fa-eye"></i>View FAQ</a></li>
              <li><a href="<?=ADMINURL?>faq-add.php"><i class="fa fa-plus-circle"></i>Add FAQ</a></li>
            </ul>
          </li>
          <?php } ?>
          <?php if(accessPermission('1')){ ?>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-file-text-o"></i> <span>Distributor</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>distributor_company.php"><i class="fa fa-eye"></i>Company List</a></li>
              <li><a href="<?=ADMINURL?>create_dis_company.php"><i class="fa fa-eye"></i>Create Company</a></li>
              <li><a href="<?=ADMINURL?>distributor_list.php"><i class="fa fa-eye"></i>Distributor List</a></li>
              <li><a href="<?=ADMINURL?>distributorpins.php"><i class="fa fa-eye"></i>Pin List</a></li>
              <li><a href="<?=ADMINURL?>distributor-pin.php"><i class="fa fa-plus-circle"></i>Generate PIN</a></li>
              <li><a href="<?=ADMINURL?>support.php?id=2"><i class="fa fa-eye"></i>Distributor Support</a></li>
              <li><a href="<?=ADMINURL?>distributor_payout.php"><i class="fa fa-plus-circle"></i>Distributor Payment</a></li>
              <li><a href="<?=ADMINURL?>dist_payoutpage.php"><i class="fa fa-eye"></i>Distributor Payout Detail</a></li>
            </ul>
          </li>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-file-text-o"></i> <span>Customer support category</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>support-cat.php"><i class="fa fa-eye"></i>Customer support category</a></li>
              <li><a href="<?=ADMINURL?>support-cat-add.php"><i class="fa fa-plus-circle"></i>Add Customer support category</a></li>
            </ul>
          </li>
          <li class="sub-menu"> <a href="#"> <i class="fa fa-file-text-o"></i> <span>Reports</span> </a>
            <ul class="sub">
              <li><a href="<?=ADMINURL?>reports.php?topselling=1"><i class="fa fa-eye"></i>Top Selling Products</a></li>
              <li><a href="<?=ADMINURL?>reports.php?topseller=2"><i class="fa fa-eye"></i>Top Seller</a></li>
              <li><a href="<?=ADMINURL?>reports.php?totalselltoday=3"><i class="fa fa-plus-circle"></i>Total Sale today</a></li>
              <li><a href="<?=ADMINURL?>reports.php?vendor_sale=4"><i class="fa fa-plus-circle"></i>Vendor Sale Report</a></li>
              <li><a href="<?=ADMINURL?>reports.php?payment_gateway=5"><i class="fa fa-plus-circle"></i>Total Payment gatewaywise</a></li>
              <li><a href="<?=ADMINURL?>reports.php?dist_earning=6"><i class="fa fa-plus-circle"></i>Total Distributor Earning</a></li>
              <li><a href="<?=ADMINURL?>reports.php?egift_voucher=7"><i class="fa fa-plus-circle"></i>E-gift Voucher</a></li>
              <li><a href="<?=ADMINURL?>reports.php?coupon=8"><i class="fa fa-plus-circle"></i>Coupon Reports</a></li>
              <li><a href="<?=ADMINURL?>reports.php?turnover=9"><i class="fa fa-plus-circle"></i>Turnover Reports</a></li>
              <li><a href="<?=ADMINURL?>reports.php?merchant_payout=10"><i class="fa fa-plus-circle"></i>Merchant Payout Reports</a></li>
              <li><a href="<?=ADMINURL?>reports.php?tc_earned_by_merchant=11"><i class="fa fa-plus-circle"></i>Total Commission Earned from Merchants</a></li>
              <li><a href="<?=ADMINURL?>reports.php?tc_earned_by_dis=12"><i class="fa fa-plus-circle"></i>Total Commission Distributed to Distributor</a></li>
              <li><a href="<?=ADMINURL?>reports.php?b2b_sale=13"><i class="fa fa-plus-circle"></i>B2B Sales Reports</a></li>
              <li><a href="<?=ADMINURL?>reports.php?shipping=14"><i class="fa fa-plus-circle"></i>Shipping Reports</a></li>
            </ul>
          </li>
          <?php } ?>
        </ul>
      </div>
      
      <!-- sidebar menu end--> 
      
    </div>
  </nav>
</aside>

<!--sidebar end-->