<?php echo $this->Html->script(array('jgeneral')); ?>
<section class="hbox stretch">
    <?php echo $this->element('admin_sidebar');?>
    <section id="content">
        <section class="vbox wrapper_form">
            <?php echo $this->element('admin_header'); ?>
            <section class="scrollable wrapper">
                <section class="panel">
                    <form method="post" action="" name="frmsearch" id="frmsearch">
                        <header class="panel-heading b-b bg-primary">
                            <div class="h4 m-t-none m-b-xs text-white">Category List</div>
                        </header>                    
                        <div class="row text-sm wrapper">
                            <div class="col-sm-4 m-b-xs">
                                <div class="input-group">                            
                                    <input name="searchtext" placeholder="Type Category Name here" class="input-sm form-control" type="text" <?php if (isset($this->params['form']['searchtext'])) { ?> value="<?php echo trim(stripslashes($this->params['form']['searchtext'])); ?>" <?php } else if (isset($this->params['named']['searchtext']) && $this->params['named']['searchtext'] != '') { ?> value="<?php echo trim(stripslashes($this->params['named']['searchtext'])); ?>" <?php } elseif(isset($this->data['searchtext'])) { ?> value="<?php echo trim(stripslashes($this->data['searchtext'])); ?>" <?php } ?> />                                        
                                    <span class="input-group-btn">                                        
                                        <input class="btn btn-sm btn-white" type="submit" value="Search" name="Search">
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-8 m-b-xs">
                                <div class="text-right">                            
                                    <a href="<?php echo DEFAULT_URL.'categories/categorygrid' ?>" class="btn btn-default btn-xs" name="Search">Show All</a>
                                    <a class="btn  btn-default btn-xs" href="<?php echo DEFAULT_URL . 'categories/addcategory' ?>">Add Category</a>
                                </div>
                            </div>
                        </div>        
                    </form>
                    <form name="frmadvertise" id="frmadvertise" action="" method="post">
                        <div class="table-responsive">
                            <table class="table table-striped b-t text-sm">
                                <?php
                                if (isset($this->params['pass'][0]) && $this->params['pass'][0] != '') {
                                    echo "<div class='green-message'>";
                                    switch ($this->params['pass'][0]) {
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
                                        case NOTDELETE:
                                            echo CATEGORY_NOT_DEL;
                                            break;                                       
                                    }
                                    echo "</div>";
                                }?>
                                <thead>
                                    <tr>
                                        <th width="1%"><input id="iId" type="checkbox" value="1" onclick="checkAll();" name="abc"/></th>
                                        <th>Name</th>
                                        <th width="15%" class="centertext">Parent Category</th>
                                        <th width="15%" class="centertext">Date</th>
<!--                                        <th width="15%" class="centertext">Add Sub Category</th>-->
                                        <th width="7%" class="centertext">Status</th>
                                        <th width="5%" class="centertext">Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $pass_sub_cat = '';
                                    if(isset($this->params['named']['parent']) && $this->params['named']['parent']!='')
                                    {
                                        $pass_sub_cat = 'parent:'.$this->params['named']['parent'].'/';
                                    }
                                    if (count($categorydata) > 0) 
                                    {
                                        $url = '';
                                        if (isset($this->passedArgs['page'])) {
                                            $url = '/page:' . $this->passedArgs['page'];
                                        }
                                        for ($i = 0; $i < count($categorydata); $i++) 
                                        {?>
                                            <tr>
                                                <td width="1%"><input type="checkbox" id="iId" name="checkbox[<?php echo $categorydata[$i]['Category']['id']; ?>]" onclick="Uncheck();"/></td>
                                                <td>
                                                    <?php 
                                                    if($categorydata[$i]['Category']['parent_id']==0)
                                                        echo $this->Html->link($categorydata[$i]['Category']['name'], array('controller' => 'categories', 'action' => 'categorygrid/parent:' . $categorydata[$i]['Category']['id'] . "/" . $url), false, false, false); 
                                                    else
                                                        echo $categorydata[$i]['Category']['name']; 
                                                    ?>
                                                    
                                                    <?php //echo ($categorydata[$i]['Category']['name']) ?>
                                                </td>
                                                <td class="centertext"><?php echo $main_cat_name;?></td>
                                                <td class="centertext"><?php echo $this->Time->format(GRID_DATE_FORMAT,$categorydata[$i]['Category']['modified_date']);?></td>
<!--                                                <td class="centertext"><?php //echo $this->Html->link("Add Sub Category", array('controller' => 'categories', 'action' => 'subcategorygrid/' . $categorydata[$i]['Category']['id'] . "/" . $url), false, false, false); ?></td>-->
                                                <td class="centertext"><?php echo $categorydata[$i]['Category']['status'];?></td>
                                                <td class="centertext"><?php echo $this->Html->link("Edit", array('controller' => 'categories', 'action' => 'editcategory/'.$pass_sub_cat.$categorydata[$i]['Category']['id']), false, false, false); ?></td>
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
                                                $options1 = array('url' => array('controller' => 'categories', 'action' => 'categorygrid/searchtext:' . trim($this->data['searchtext'])));
                                                $this->Paginator->options($options1);
                                            } else if (isset($this->params['named']['searchtext']) && trim($this->params['named']['searchtext']) != "") {
                                                $options1 = array('url' => array('controller' => 'categories', 'action' => 'categorygrid/searchtext:' . trim($this->params['named']['searchtext'])));
                                                $this->Paginator->options($options1);
                                            } else if (isset($this->params['form']['eventvalue']) && trim($this->params['form']['eventvalue']) != "") {
                                                $options1 = array('url' => array('controller' => 'categories', 'action' => 'categorygrid/eventvalue:' . trim($this->params['form']['eventvalue'])));
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