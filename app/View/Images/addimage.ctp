<section class="hbox stretch">
    <?php echo $this->element('admin_sidebar'); ?>
    <section id="content">
        <section class="vbox wrapper_form">
            <?php echo $this->element('admin_header'); ?>
            <section class="scrollable wrapper">
                <div class="backlink">   
                    <?php //if(isset($this->params['pass'][0]) && $this->params['pass'][0]!=''){$pid = $this->params['pass'][0];}?>
                    <?php echo $this->Html->link("Back", array('controller' => 'images', 'action' => 'image_grid/'.$this->params['pass'][0]), false, false, false); ?>
                </div>
                <div class="tab-content">
                    <form class="form-horizontal apple" name="frmaddsubcategory" id="frmaddsubcategory" method="post" enctype="multipart/form-data">
                        <div class="form-horizontal-div">
                            <div class="form-group m-t-lg1">
                                <label class="col-sm-2 control-label">Product Image</label>
                                <div class="col-sm-4">                                                    
                                    <input type="file" name="imagename" id="imagename">
                                    <?php if (isset($selectimage)) echo "<br><span id='errmsg' class='error-message server'>" . SELECT_IMAGE . "</span>"; ?>
                                    <?php if (isset($filecorrupt)) echo "<br><span id='errmsg' class='error-message server'>" . VALIDIMAGETYPE . "</span>"; ?>
                                    <?php if (isset($entervalidfile)) echo "<br><span id='errmsg' class='error-message server'>" . VALID_IMAGETYPE . "</span>"; ?>
                                    <?php if (isset($invalidsize)) echo "<br><span id='errmsg' class='error-message server'>" . INVALIDSIZEIMAGE . "</span>"; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-4">
                                    <input type="submit" name="btnaddimage" id="btnaddimage" class="btn btn-primary" value="Submit"/>
                                </div>
                            </div>              
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </section>
</section>