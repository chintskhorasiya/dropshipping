<section class="hbox stretch">
    <?php echo $this->element('admin_sidebar'); ?>
    <section id="content">
        <section class="vbox wrapper_form">
            <?php echo $this->element('admin_header'); ?>
            <section class="scrollable wrapper">
                <div class="backlink">   
                    <?php echo $this->Html->link("Back", array('controller' => 'categories', 'action' => 'categorygrid/'), false, false, false); ?>
                </div>
                <div class="tab-content">
                    <form class="form-horizontal apple" name="frmaddcategory" id="frmaddcategory"  method="post" enctype="multipart/form-data">
                        <div class="form-horizontal-div">
                            <div class="form-group m-t-lg1">
                                <label class="col-sm-2 control-label">Select Category<span class="red-star">*</span></label>
                                <div class="col-sm-4">
                                    <?php echo $this->Form->input('Category.parent_id', array('id' => 'parent_id', 'type' => 'select', 'options' => array('' => 'Main Category',$parent_data ), 'class' => 'form-control', 'label' => false, 'div' => false)); ?>
                                </div>
                            </div>
                            <div class="form-group m-t-lg1">
                                <label class="col-sm-2 control-label">Name<span class="red-star">*</span></label>
                                <div class="col-sm-4">                                                    
                                    <?php echo ($this->Form->text('Category.name', array('id' => 'name', 'class' => 'bg-focus form-control', 'maxlength' => '100'))); ?>
                                    <?php if (isset($entertitle)) echo "<br><span id='errmsg' class='error-message server'>" . ENTER_NAME . "</span>"; ?>
                                    <?php if (isset($cate_exists)) echo "<br><span id='errmsg' class='error-message server'>" . CATEGORY_EXISTS . "</span>"; ?>
                                </div>
                            </div>
                            <div class="divsize" style="display: none;">
                                <div class="form-group m-t-lg1">
                                    <label class="col-sm-2 control-label">Size</label>
                                    <div class="col-sm-4">
                                        <div class="checkbox">
                                            <label class="checkbox-custom" style="font-weight:light;font-size:13px;">
                                            <input type="checkbox" id="size" class="same_above" name="data[Category][size]" value="yes" <?php echo (isset($this->data['Category']['size']) && $this->data['Category']['size']=='yes')?'checked':'' ?> /><i class="icon-unchecked"></i> </label>
                                            <b><?php echo SIZE_NOTE;?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-t-lg1">
                                    <label class="col-sm-2 control-label">Color</label>
                                    <div class="col-sm-4">
                                        <div class="checkbox">
                                            <label class="checkbox-custom" style="font-weight:light;font-size:13px;">
                                            <input type="checkbox" id="color" name="data[Category][color]" value="yes" <?php echo (isset($this->data['Category']['color']) && $this->data['Category']['color']=='yes')?'checked':'' ?> /><i class="icon-unchecked"></i> </label>
                                            <b><?php echo COLOR_NOTE;?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-t-lg1">
                                    <label class="col-sm-2 control-label">Patch</label>
                                    <div class="col-sm-4">
                                        <div class="checkbox">
                                            <label class="checkbox-custom" style="font-weight:light;font-size:13px;">
                                            <input type="checkbox" id="patch" name="data[Category][patch]" value="yes" <?php echo (isset($this->data['Category']['patch']) && $this->data['Category']['patch']=='yes')?'checked':'' ?> /><i class="icon-unchecked"></i> </label>
                                            <b><?php echo PATCH_NOTE;?></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-t-lg1">
                                <label class="col-sm-2 control-label">Image<span class="red-star">*</span></label>
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
<script type="text/javascript">
$('#parent_id').on('change', function() {
    
    if(this.value=='')
    {
        $('.divsize').hide();
        $('.divimage').hide();
    }
    else
    {
        $('.divsize').show();
        $('.divimage').show();
    }
    //alert( this.value );
});    
</script>