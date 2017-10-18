<?php
//FOR CKEDITOR
echo $this->Html->script('ckeditor/ckeditor');
echo $this->Html->script('ckfinder/ckfinder');
?>
<section class="hbox stretch">
    <?php echo $this->element('admin_sidebar'); ?>
    <section id="content">
        <section class="vbox wrapper_form">
            <?php echo $this->element('admin_header'); ?>
            <section class="scrollable wrapper">
                <div class="backlink">   
                    <?php echo $this->Html->link("Back", array('controller' => 'cmspages', 'action' => 'cmspagesgrid/'), false, false, false); ?>
                </div>
                <div class="tab-content">
                    <form class="form-horizontal apple" name="frmaddcms" id="frmaddcms"  method="post" enctype="multipart/form-data">
                        <div class="form-horizontal-div">
                            <div class="form-group m-t-lg1">
                                <label class="col-sm-2 control-label">Name<span class="red-star">*</span></label>
                                <div class="col-sm-4">                                                    
                                    <?php echo ($this->Form->text('Cmspage.name', array('id' => 'name', 'class' => 'bg-focus form-control', 'maxlength' => '100'))); ?>
                                    <?php if (isset($entername)) echo "<br><span id='errmsg' class='error-message server'>" . ENTER_NAME . "</span>"; ?>
                                </div>
                            </div>
<!--                            <div class="form-group">
                                <label class="col-sm-2 control-label">Short Description</label>
                                <div class="col-sm-4">
                                    <?php //echo $this->Form->textarea('Cmspage.short_description', array('id'=>'short_description','label'=>false,'div'=>false,'class' => 'bg-focus form-control','type'=>'textarea'));?>
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Description<span class="red-star">*</span></label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <?php echo $this->Form->textarea('Cmspage.description', array('id'=>'description','class'=>'ckeditor'));?>
                                    <script type="text/javascript">
                                        //alert(siteurl);
                                        var editor = CKEDITOR.replace('description');
                                        CKFinder.setupCKEditor(editor, { basePath : siteurl+'/app/webroot/js/ckfinder/'} );
                                    </script>
                                    <?php if (isset($enterdesc)) echo "<br><span id='errmsg' class='error-message server'>" . ENTER_DESC . "</span>"; ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Meta Title</label>
                                <div class="col-sm-4">
                                    <?php echo $this->Form->textarea('Cmspage.meta_title', array('id'=>'meta_title','label'=>false,'div'=>false,'class' => 'bg-focus form-control','type'=>'textarea'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Meta Keyword</label>
                                <div class="col-sm-4">
                                    <?php echo $this->Form->textarea('Cmspage.meta_keyword', array('id'=>'meta_keyword','label'=>false,'div'=>false,'class' => 'bg-focus form-control','type'=>'textarea'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Meta Description</label>
                                <div class="col-sm-4">
                                    <?php echo $this->Form->textarea('Cmspage.meta_desc', array('id'=>'meta_desc','label'=>false,'div'=>false,'class' => 'bg-focus form-control','type'=>'textarea'));?>
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