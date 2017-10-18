<section class="hbox stretch">
    <?php echo $this->element('admin_sidebar'); ?>
    <section id="content">
        <section class="vbox wrapper_form">
            <?php echo $this->element('admin_header');?>
            <section class="scrollable wrapper">
                <div class="tab-content">
                    <form class="form-group col-sm-12 apple" name="frmfooter" id="frmfooter"  method="post">
                        <?php
                        if (isset($this->params['pass'][0]) && $this->params['pass'][0]==SUCUPDATE) {
                            echo "<div class='green-message'>".RECORDUPDATE."</div>";
                        }
                        ?>
                        <div class="col-sm-12  m-t-lg1" style="margin-bottom: 5px;">&nbsp;</div>
                        
                        <div id="foocontent-box1">
                            <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">
                                <div class="col-sm-4">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-3 control-label font-bold">Footer 1</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="bg-focus form-control" name="data[Footer][name][0]" value="<?php echo (isset($footerdata[0]['FooterLink']['boxname']) && $footerdata[0]['FooterLink']['boxname']!='')?trim($footerdata[0]['FooterLink']['boxname']):''; ?>">
                                            <?php if (isset($error_array['box1'])) echo "<span class='error-message server'>" . $error_array['box1'] . "</span>"; ?>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                            <?php $box_data1 = (!empty($footerdata[0]['FooterLink']['pageinfo']))?json_decode($footerdata[0]['FooterLink']['pageinfo'],true):'';?>
                            <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">
                                <div class="col-sm-4">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-9">                                                    
                                            <input type="text" class="bg-focus form-control" name="data[FooterLink][box1][0][name]" value="<?php echo (isset($box_data1[0]['name']) && $box_data1[0]['name']!='')?$box_data1[0]['name']:''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-2 control-label">Link</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="bg-focus form-control" name="data[FooterLink][box1][0][link]" value="<?php echo (isset($box_data1[0]['link']) && $box_data1[0]['link']!='')?$box_data1[0]['link']:''; ?>">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                            <?php 
                            if(isset($box_data1) && count($box_data1)>0)
                            {
                                add_more_data($box_data1,'box1',count($box_data1));
                            }
                            ?>
                            
                        </div>
                        
                        <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">
                            <div class="col-sm-4">
                                <div class="form-group m-t-lg1">
                                    <label class="col-sm-3 control-label font-bold">&nbsp;</label>
                                    <div class="col-sm-9">                                                    
                                        <a class="btn btn-sm btn-white" id="plusimage" alt="Add New" onclick="add_more('box1')"> 
                                            <i class="icon-plus text"></i> 
                                            <span class="text">Add More</span>
                                        </a>
                                        <a class="btn btn-sm btn-white" id="minusimage" alt="Remove" onclick="removebox('box1')">
                                            <i class="icon-minus text"></i> 
                                            <span class="text">Remove</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        
                        <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">&nbsp;</div>
                        
                        <?php // For box 2 ?>
                        <div id="foocontent-box2">
                            <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">
                                <div class="col-sm-4">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-3 control-label font-bold">Footer 2</label>
                                        <div class="col-sm-9">                                                    
                                            <input type="text" class="bg-focus form-control" name="data[Footer][name][1]" value="<?php echo (isset($footerdata[1]['FooterLink']['boxname']) && $footerdata[1]['FooterLink']['boxname']!='')?trim($footerdata[1]['FooterLink']['boxname']):''; ?>">
                                            <?php if (isset($error_array['box2'])) echo "<span class='error-message server'>" . $error_array['box2'] . "</span>"; ?>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                            <?php $box_data2 = (!empty($footerdata[1]['FooterLink']['pageinfo']))?json_decode($footerdata[1]['FooterLink']['pageinfo'],true):'';?>
                            <div class="col-sm-12 m-t-lg1" style="margin-bottom: 10px;">
                                <div class="col-sm-4">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-9">                                                    
                                            <input type="text" class="bg-focus form-control" name="data[FooterLink][box2][0][name]" value="<?php echo (isset($box_data2[0]['name']) && $box_data2[0]['name']!='')?$box_data2[0]['name']:''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-2 control-label">Link</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="bg-focus form-control" name="data[FooterLink][box2][0][link]" value="<?php echo (isset($box_data2[0]['link']) && $box_data2[0]['link']!='')?$box_data2[0]['link']:''; ?>">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                            <?php 
                            if(isset($box_data2) && count($box_data2)>0)
                            {
                                add_more_data($box_data2,'box2',count($box_data2));
                            }
                            ?>
                            
                        </div>
                        
                        <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">
                            <div class="col-sm-4">
                                <div class="form-group m-t-lg1">
                                    <label class="col-sm-3 control-label font-bold">&nbsp;</label>
                                    <div class="col-sm-9">                                                    
                                        <a class="btn btn-sm btn-white" id="plusimage" onclick="add_more('box2')"> 
                                            <i class="icon-plus text"></i> 
                                            <span class="text">Add More</span>
                                        </a>
                                        <a class="btn btn-sm btn-white" id="minusimage" alt="Remove" onclick="removebox('box2')"> 
                                            <i class="icon-minus text"></i> 
                                            <span class="text">Remove</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        
                        <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">&nbsp;</div>
                        
                         <?php // For box 3 ?>
                        <div id="foocontent-box3">
                            <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">
                                <div class="col-sm-4">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-3 control-label font-bold">Footer 3</label>
                                        <div class="col-sm-9">                                                    
                                            <input type="text" class="bg-focus form-control" name="data[Footer][name][2]" value="<?php echo (isset($footerdata[2]['FooterLink']['boxname']) && $footerdata[2]['FooterLink']['boxname']!='')?trim($footerdata[2]['FooterLink']['boxname']):''; ?>">
                                            <?php if (isset($error_array['box3'])) echo "<span class='error-message server'>" . $error_array['box3'] . "</span>"; ?>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                            
                            <?php $box_data3 = (!empty($footerdata[2]['FooterLink']['pageinfo']))?json_decode($footerdata[2]['FooterLink']['pageinfo'],true):'';?>
                            <div class="col-sm-12 m-t-lg1" style="margin-bottom: 10px;">
                                <div class="col-sm-4">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-9">                                                    
                                            <input type="text" class="bg-focus form-control" name="data[FooterLink][box3][0][name]" value="<?php echo (isset($box_data3[0]['name']) && $box_data3[0]['name']!='')?$box_data3[0]['name']:''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-2 control-label">Link</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="bg-focus form-control" name="data[FooterLink][box3][0][link]" value="<?php echo (isset($box_data3[0]['link']) && $box_data3[0]['link']!='')?$box_data3[0]['link']:''; ?>">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                            <?php 
                            if(isset($box_data3) && count($box_data3)>0)
                            {
                                add_more_data($box_data3,'box3',count($box_data3));
                            }
                            ?>
                        </div>
                        
                        <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">
                            <div class="col-sm-6">
                                <div class="form-group m-t-lg1">
                                    <label class="col-sm-2 control-label font-bold">&nbsp;</label>
                                    <div class="col-sm-6">                                                    
                                        <a class="btn btn-sm btn-white" id="plusimage" alt="Add New" onclick="add_more('box3')"> 
                                            <i class="icon-plus text"></i> 
                                            <span class="text">Add More</span>
                                        </a>
                                        <a class="btn btn-sm btn-white" id="minusimage" alt="Remove" onclick="removebox('box3')"> 
                                            <i class="icon-minus text"></i> 
                                            <span class="text">Remove</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        
                        <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">&nbsp;</div>
                        
                         <?php // For box 4 ?>
                        <div id="foocontent-box4">
                            <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">
                                <div class="col-sm-4">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-3 control-label font-bold">Footer 4</label>
                                        <div class="col-sm-9">                                                    
                                            <input type="text" class="bg-focus form-control" name="data[Footer][name][3]" value="<?php echo (isset($footerdata[3]['FooterLink']['boxname']) && $footerdata[3]['FooterLink']['boxname']!='')?trim($footerdata[3]['FooterLink']['boxname']):''; ?>">
                                            <?php if (isset($error_array['box4'])) echo "<span class='error-message server'>" . $error_array['box4'] . "</span>"; ?>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                            <?php $box_data4 = (!empty($footerdata[3]['FooterLink']['pageinfo']))?json_decode($footerdata[3]['FooterLink']['pageinfo'],true):'';?>
                            <div class="col-sm-12 m-t-lg1" style="margin-bottom: 10px;">
                                <div class="col-sm-4">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-9">                                                    
                                            <input type="text" class="bg-focus form-control" name="data[FooterLink][box4][0][name]" value="<?php echo (isset($box_data4[0]['name']) && $box_data4[0]['name']!='')?$box_data4[0]['name']:''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-t-lg1">
                                        <label class="col-sm-2 control-label">Link</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="bg-focus form-control" name="data[FooterLink][box4][0][link]" value="<?php echo (isset($box_data4[0]['link']) && $box_data4[0]['link']!='')?$box_data4[0]['link']:''; ?>">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                             <?php 
                            if(isset($box_data4) && count($box_data4)>0)
                            {
                                add_more_data($box_data4,'box4',count($box_data4));
                            }
                            ?>
                        </div>
                        
                        <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">
                            <div class="col-sm-4">
                                <div class="form-group m-t-lg1">
                                    <label class="col-sm-3 control-label font-bold">&nbsp;</label>
                                    <div class="col-sm-9">                                                    
                                        <a class="btn btn-sm btn-white" id="plusimage" alt="Add New" onclick="add_more('box4')"> 
                                            <i class="icon-plus text"></i> 
                                            <span class="text">Add More</span>
                                        </a>
                                        <a class="btn btn-sm btn-white" id="minusimage" alt="Remove" onclick="removebox('box4')"> 
                                            <i class="icon-minus text"></i> 
                                            <span class="text">Remove</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        
                        <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">
                            <div class="col-sm-4">
                                <div class="form-group m-t-lg1">
                                    <label class="col-sm-3 control-label font-bold">&nbsp;</label>
                                    <div class="col-sm-9">                                                    
                                        <input type="submit" name="btnfooter" id="btnfooter" class="btn btn-primary"  value="Submit"/>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                        <div class="col-sm-12  m-t-lg1" style="margin-bottom: 10px;">&nbsp;</div>
                    </form>
                    <script type="text/javascript">
                        function removebox(boxtype)
                        {
                            var removecnt = $('#foocontent-'+boxtype+' .foot-box').length;
                            //alert(removecnt);
                            
                            $('#foocontent-'+boxtype+' .boxcnt'+removecnt).remove();
                        }
                        function add_more(boxtype)
                        {
                            //count of footer box
                            var counter = parseInt(($('#foocontent-'+boxtype+' .foot-box').length) + 1);
                            //alert(counter);
                            
                            var add_row =   '<div class="boxcnt'+counter+'">\
                                                <div class="col-sm-12 m-t-lg1 foot-box" style="margin-bottom: 10px;">\
                                                    <div class="col-sm-4">\
                                                        <div class="form-group m-t-lg1">\
                                                            <label class="col-sm-3 control-label">Name</label>\
                                                            <div class="col-sm-9">\
                                                                <input type="text" class="bg-focus form-control" name="data[FooterLink]['+boxtype+']['+counter+'][name]" value="">\
                                                            </div>\
                                                        </div>\
                                                    </div>\
                                                    <div class="col-sm-6">\
                                                        <div class="form-group m-t-lg1">\
                                                            <label class="col-sm-2 control-label">Link</label>\
                                                            <div class="col-sm-8">\
                                                                <input type="text" class="bg-focus form-control" name="data[FooterLink]['+boxtype+']['+counter+'][link]" value="">\
                                                            </div>\
                                                        </div>\
                                                    </div>\
                                                    <div style="clear:both;"></div>\
                                                </div>\
                                            </div>';
                            $('#foocontent-'+boxtype).append(add_row);
                        }
                    </script>
                </div>
            </section>
        </section>
    </section>
</section>
<?php
function add_more_data($box_foot_data,$boxid,$cnt)
{
    //echo 'Test '.$boxid.' '.$cnt;
    for($i=1;$i<$cnt;$i++)
    {?>
    <div class="boxcnt<?php echo $i;?>">
        <div class="col-sm-12 m-t-lg1 foot-box" style="margin-bottom: 10px;">
            <div class="col-sm-4">
                <div class="form-group m-t-lg1">
                    <label class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">                                                    
                        <input type="text" class="bg-focus form-control" name="data[FooterLink][<?php echo $boxid;?>][<?php echo $i;?>][name]" value="<?php echo (isset($box_foot_data[$i]['name']) && $box_foot_data[$i]['name']!='')?$box_foot_data[$i]['name']:''; ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group m-t-lg1">
                    <label class="col-sm-2 control-label">Link</label>
                    <div class="col-sm-8">
                        <input type="text" class="bg-focus form-control" name="data[FooterLink][<?php echo $boxid;?>][<?php echo $i;?>][link]" value="<?php echo (isset($box_foot_data[$i]['link']) && $box_foot_data[$i]['link']!='')?$box_foot_data[$i]['link']:''; ?>">
                    </div>

                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
    <?php     
    }
}
?>