<?php echo $this->Html->script(array('jgeneral')); ?>
<section class="hbox stretch">
    <?php echo $this->element('admin_sidebar');?>
    <section id="content">
        <section class="vbox wrapper_form">
            <?php echo $this->element('admin_header'); ?>
            <?php if(isset($this->params['pass'][0])){ $catid = $this->params['pass'][0];}?>
            <section class="scrollable wrapper">
                <section class="panel">
                    <form method="post" action="" name="frmsearch" id="frmsearch">
                        <header class="panel-heading b-b bg-primary">
                            <div class="h4 m-t-none m-b-xs text-white">Sub Category of <?php echo ucfirst($cat_name);?> </div>
                        </header>                    
                        <div class="row text-sm wrapper">
                            <div class="col-sm-4 m-b-xs">
                                <div class="input-group">                            
                                    <input name="searchtext" placeholder="Type Sub Category Name here" class="input-sm form-control" type="text" <?php if (isset($this->params['form']['searchtext'])) { ?> value="<?php echo trim(stripslashes($this->params['form']['searchtext'])); ?>" <?php } else if (isset($this->params['named']['searchtext']) && $this->params['named']['searchtext'] != '') { ?> value="<?php echo trim(stripslashes($this->params['named']['searchtext'])); ?>" <?php } elseif(isset($this->data['searchtext'])) { ?> value="<?php echo trim(stripslashes($this->data['searchtext'])); ?>" <?php } ?> />                                        
                                    <span class="input-group-btn">                                        
                                        <input class="btn btn-sm btn-white" type="submit" value="Search" name="Search">
                                    </span>
                                </div>
                            </div>
                            
                            <div class="col-sm-8 m-b-xs">
                                <div class="text-right">
                                    <a class="btn  btn-default btn-xs" href="<?php echo DEFAULT_URL . 'categories/categorygrid' ?>">Back</a>
                                    <a href="<?php echo DEFAULT_URL.'categories/subcategorygrid/'.$catid ?>" class="btn btn-default btn-xs" name="Search">Show All</a>
                                    <a class="btn  btn-default btn-xs" href="<?php echo DEFAULT_URL . 'categories/addsubcategory/'.$catid ?>">Add Sub Category</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form name="frmadvertise" id="frmadvertise" action="" method="post">
                        <div class="table-responsive">
                            <table class="table table-striped b-t text-sm">
                                <?php
                                if (isset($this->params['pass'][1]) && $this->params['pass'][1] != '') {
                                    echo "<div class='green-message'>";
                                    switch ($this->params['pass'][1]) {
                                        case SUCADD:
                                            echo RECORDADD;
                                            break;
                                        case SUCUPDATE:
                                            echo RECORDUPDATE;
                                            break;
                                        case SUCDELETE:
                                            echo RECORDDELETE;
                                            break;
                                        case SUCACTIVE:
                                            echo RECORDACTIVE;
                                            break;
                                        case SUCINACTIVE:
                                            echo RECORDINACTIVE;
                                            break;                                       
                                    }
                                    echo "</div>";
                                }?>
                                <thead>
                                    <tr>
                                        <th width="1%"><input id="iId" type="checkbox" value="1" onclick="checkAll();" name="abc"/></th>
                                        <th>Name</th>
                                        <th width="15%" class="centertext">Image</th>
                                        <th width="15%" class="centertext">Date</th>
                                        <th width="7%" class="centertext">Status</th>
                                        <th width="5%" class="centertext">Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($subcatdata) > 0) 
                                    {
                                        $url = '';
                                        if (isset($this->passedArgs['page'])) {
                                            $url = '/page:' . $this->passedArgs['page'];
                                        }
                                        for ($i = 0; $i < count($subcatdata); $i++) 
                                        {?>
                                            <tr>
                                                <td width="1%"><input type="checkbox" id="iId" name="checkbox[<?php echo $subcatdata[$i]['SubCategory']['id']; ?>]" onclick="Uncheck();"/></td>
                                                <td><?php echo $subcatdata[$i]['SubCategory']['name'] ?></td>
                                                <td class="centertext">
                                                    <?php 
                                                    if(is_file(UPLOAD_FOLDER.'subcategory/100x100/'.$subcatdata[$i]['SubCategory']['imagename'])){
                                                        echo $this->html->image(DISPLAY_URL_IMAGE.'subcategory/100x100/'.$subcatdata[$i]['SubCategory']['imagename']);
                                                    }
                                                    ?>
                                                </td>
                                                <td class="centertext"><?php echo $this->Time->format(GRID_DATE_FORMAT,$subcatdata[$i]['SubCategory']['modified_date']);?></td>
                                                <td class="centertext"><?php echo $subcatdata[$i]['SubCategory']['status'];?></td>
                                                <td class="centertext"><?php echo $this->Html->link("Edit", array('controller' => 'categories', 'action' => 'editsubcategory/'.$catid.'/'.$subcatdata[$i]['SubCategory']['id'] . "/" . $url), false, false, false); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else 
                                    {?>
                                    <tr>
                                        <td colspan="8">
                                            <div class="error-message fontbold">
                                                <?php echo RECORD_NOTFOUND; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    }?>
                                </tbody>
                            </table>
                            <footer class="panel-footer"> 
                                <div class="row"> 
                                    <div class="col-sm-4 text-center-xs"> 
                                        <select id="eventvalue" name="eventvalue" class="input-sm form-control input-s-sm inline" style="width:auto;">
                                            <option value="all">ShowAll</option>
                                            <option value="active" <?php
                                            if (isset($this->params['form']['eventvalue']) && $this->params['form']['eventvalue'] == "Active") {
                                                echo "selected='selected'";
                                            }
                                            ?>>Active</option>
                                            <option value="inactive" <?php
                                            if (isset($this->params['form']['eventvalue']) && $this->params['form']['eventvalue'] == "Inactive") {
                                                echo "selected='selected'";
                                            }
                                            ?> >Inactive</option>
                                            <option value="delete" <?php
                                            if (isset($this->params['form']['eventvalue']) && $this->params['form']['eventvalue'] == "delete") {
                                                echo "selected='selected'";
                                            }
                                            ?>>Delete</option>
                                        </select>
                                        <input type="hidden" name="action" id="action">
                                        <input type="button" class="btn btn-sm btn-info" value="Apply" onclick="return checkevent();" />
                                    </div>                                     
                                    <div class="col-sm-8 text-right text-center-xs">
                                        <ul class="pagination pagination-sm" style="border: 0px solid red;float: right;">
                                            <?php
                                            if ($this->Paginator->hasPage(2)){
                                            /* */
                                            if (isset($this->data['searchtext']) && trim($this->data['searchtext']) != "") {
                                                $options1 = array('url' => array('controller' => 'categories', 'action' => 'subcategorygrid/'.$catid.'/searchtext:' . trim($this->data['searchtext'])));
                                                $this->Paginator->options($options1);
                                            } else if (isset($this->params['named']['searchtext']) && trim($this->params['named']['searchtext']) != "") {
                                                $options1 = array('url' => array('controller' => 'categories', 'action' => 'subcategorygrid/'.$catid.'/searchtext:' . trim($this->params['named']['searchtext'])));
                                                $this->Paginator->options($options1);
                                            } else if (isset($this->params['form']['eventvalue']) && trim($this->params['form']['eventvalue']) != "") {
                                                $options1 = array('url' => array('controller' => 'categories', 'action' => 'subcategorygrid/'.$catid.'/eventvalue:' . trim($this->params['form']['eventvalue'])));
                                                $this->Paginator->options($options1);
                                            }
                                            ?>
                                            <?php
                                            echo $this->Paginator->first(__('<< First', true),array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
                                            //echo $this->Paginator->prev('<< ' . __(PREVIOUS), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
                                            echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
                                            //echo $this->Paginator->next(__(NEXT) . ' >>', array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
                                            echo $this->Paginator->last(__('Last >>', true),array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
                                            }?>
                                        </ul>
                                    </div>
                                </div>
                            </footer>                        
                        </div>
                    </form>
                </section>
            </section>
        </section>
    </section>
</section>