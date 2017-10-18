   <div class="product_banner">
            <div class="about_intro">
                <div style="width:350px;">
                    <img src="<?php echo IMAGE_URL.'text.png'?>" alt="text"/>
                    <p><?php echo $banner['Banner']['description'];?></p></div>
            </div>
        </div>
        <div style="background:#f9f9f9;">
            <div class="products">
                Home  <img src="<?php echo IMAGE_URL.'arrow_aboutus.png'?>" alt="arrow_aboutus"/> Domestic Products
            </div>
        </div>
        <div class="responsive">

            <div class="main_content">
                <div class="h4"><B>SUCHI PRODUCTS</B> <div class="line"></div></div>
                <?php
                                if (isset($categories_desc) && count($categories_desc) > 0) {
                                    for ($i = 0; $i < count($categories_desc); $i++) {
                                        ?>  
                <div class="three_boxes">
                    <div class="div">
                        <div class="span_text"><a href="<?php echo DEFAULT_URL.'products/subproduct/'.$categories_desc[$i]['Category']['id']?>"><?php echo $categories_desc[$i]['Category']['title'];?></a>
                        </div>
                    </div>
                    <a href="<?php echo DEFAULT_URL.'products/subproduct/'.$categories_desc[$i]['Category']['id']?>"><img src="<?php echo DEFAULT_URL . "img/uploads/categories/" . $categories_desc[$i]['Category']['image']; ?>" alt="KHAKHARA" class="img_indent"/></a>
                </div>
 <?php }
                                }
                                ?> 

            </div>
        </div>