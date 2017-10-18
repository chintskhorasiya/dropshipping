<section class="hbox stretch">
    <?php echo $this->element('admin_sidebar'); ?>
    <section id="content">
        <section class="vbox wrapper_form">
            <?php echo $this->element('admin_header'); ?>
            <section class="scrollable wrapper">
                <div class="backlink">
                    <?php echo $this->Html->link("Back", array('controller' => 'categories', 'action' => 'subcategorygrid/'.$this->params['pass'][0]), false, false, false); ?>
                </div>
                <div class="tab-content">
                    <form class="form-horizontal apple" name="frmaddsubcategory" id="frmaddsubcategory" method="post" enctype="multipart/form-data">
                        <div class="form-horizontal-div">
                            <div class="form-group m-t-lg1">
                                <label class="col-sm-2 control-label">Name<span class="red-star">*</span></label>
                                <div class="col-sm-4">                                                    
                                    <?php echo ($this->Form->text('SubCategory.name', array('id' => 'name', 'class' => 'bg-focus form-control', 'maxlength' => '100'))); ?>
                                    <?php if (isset($entertitle)) echo "<br><span id='errmsg' class='error-message server'>" . ENTER_NAME . "</span>"; ?>
                                    <?php if (isset($subcate_exists)) echo "<br><span id='errmsg' class='error-message server'>" . SUBCATEGORY_EXISTS . "</span>"; ?>
                                </div>
                            </div>
                            <div class="form-group m-t-lg1">
                                <label class="col-sm-2 control-label">Image</label>
                                <div class="col-sm-4">                                                    
                                    <input type="file" name="imagename" id="imagename">
                                    <?php if (isset($filecorrupt)) echo "<br><span id='errmsg' class='error-message server'>" . VALIDIMAGETYPE . "</span>"; ?>
                                    <?php if (isset($entervalidfile)) echo "<br><span id='errmsg' class='error-message server'>" . VALIDIMAGETYPE . "</span>"; ?>
                                    <?php if (isset($invalidsize)) echo "<br><span id='errmsg' class='error-message server'>" . INVALIDSIZEIMAGE . "</span>"; ?>
                                </div>
                            </div>
                            <input type="hidden" name="data[oldimage]" id="oldimage" value="<?php echo (isset($this->data['SubCategory']['imagename']) && $this->data['SubCategory']['imagename']!='')?$this->data['SubCategory']['imagename']:'';?>">
                            <?php if(isset($this->data['SubCategory']['imagename']) && $this->data['SubCategory']['imagename']!='' && is_file(UPLOAD_FOLDER.'subcategory/100x100/'.$this->data['SubCategory']['imagename'])) {?>
                            <div class="form-group m-t-lg1">
                                <label class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-4">
                                    <?php echo $this->html->image(DISPLAY_URL_IMAGE.'subcategory/100x100/'.$this->data['SubCategory']['imagename']);?>
                                </div>
                            </div>
                            <?php }?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">&nbsp;</label>
                                <div class="col-sm-4">
                                    <input type="submit" class="btn btn-primary"  value="Submit"/>
                                </div>
                            </div>              
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </section>
</section>