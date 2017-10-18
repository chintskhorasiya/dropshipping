<script type="text/javascript">
function chagepass()
{
    $('#errmsg').html("");
    $('.server').html('');
    
    var email = $("#email");
    var newpass = $("#newpwd");
    var confpass = $("#confirmpwd1");
    if(username.val()=='')
    {
        $("#errmsg").attr("style", "display:block");
        $('#errmsg').html("<?php echo ENTER_EMAIL;?>");
        $("#email").focus();
        return false;
    }
    if(newpass.val()=='')
    {
        $("#errmsg").attr("style", "display:block");
        $('#errmsg').html("<?php echo ENTER_PASSWORD;?>");
        $("#newpwd").focus();
        return false;
    }
    else if(confpass.val()=='')
    {
        $("#errmsg").attr("style", "display:block");
        $('#errmsg').html("<?php echo ENTER_CONFPASS;?>");
        $("#confirmpwd").focus();
        return false;
    }
    else if(newpass.val()!=confpass.val())
    {
        $("#errmsg").attr("style", "display:block");
        $('#errmsg').html("<?php echo NEWCONFPASS;?>");
        $("#newpwd").focus();
        return false;
    }
    else
    {
        $('#errmsg').html("");
        return true;
    }
}
</script>
<?php
$sendurl = '';
if(isset($this->params['pass'][0]) && $this->params['pass'][0]!='succupdate')
{
    $sendurl = DEFAULT_URL."users/usergrid";
}
?>
<?php echo $this->Html->script(array('jgeneral')); ?>
<section class="hbox stretch">
    <?php echo $this->element('property_sidebar'); ?>
    <section id="content">
        <section class="vbox wrapper_form">
            <?php echo $this->element('property_header'); ?>
            <section class="scrollable wrapper">
                <section class="panel">
                    <header class="panel-heading">
                        <h4 class="m-t-none"><?php echo $this->data['User']['fname'];?> Profile</h4>
                    </header>
                    <div class="table-responsive">

                        <form name="frmchange_pwd" id="frmchange_pwd" method="post" action="" >
                             <div id="errmsg" class='error-message' style="display: none;"></div>
            <?php //echo "test ".$errorflag;
            //if(isset($conflict)){echo "<div class='error-message server'>".NEWCONFPASS."</div>";}
            //else
            if(!isset($errorflag) && isset($this->params['pass'][0]) && $this->params['pass'][0]=='succupdate'){echo "<div class='green-message server'>".SUC_CHANGE_PROFILE."</div>";}
            ?>
                            <table class="table table-striped b-t text-sm">                               
                                <thead>
                                    <tr>
                                        <th width="32%">Email</th>
                                        <th width="32%">Password</th>
                                        <th width="32%">Confirm Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                          
                 <?php echo ($this->Form->input('User.email', array('label'=>false,'div'=>false, 'id'=>'email' , 'class'=>'bg-focus form-control required')));?>
                <?php if(isset($enteremail) && $enteremail!=''){echo "<br><span class='error-message'>".ENTER_EMAIL."</span>";}?>
                <?php if(isset($validemail) && $validemail!=''){echo "<br><span class='error-message'>".ENTER_VALIDEMAIL."</span>";}?>
                
                                        
                                        
                                        </td>
                                        <td>
                                            
                                            <input type="password" name="data[User][newpwd]" id="newpwd" class="bg-focus form-control required" value="<?php if(isset($this->params['form']['newpwd']) && $this->params['form']['newpwd']!=''){echo trim($this->params['form']['newpwd']);}?>" onblur="return chagepass();" />
                <?php //echo ($this->Form->input('User.password', array('label'=>false,'div'=>false, 'id'=>'title' , 'class'=>'smalltext required','value'=>'')));?>
                <?php if(isset($newpass))echo "<br><span class='error-message server'>".ENTER_PASSWORD."</span>";?>
                                        </td>
                                        <td>
                                            
                                        <input type="password" name="data[User][confirmpwd]" id="confirmpwd1" class="bg-focus form-control required" value="<?php if(isset($this->params['form']['confirmpwd']) && $this->params['form']['confirmpwd']!=''){echo trim($this->params['form']['confirmpwd']);}?>" onblur="return chagepass();" />
                <?php if(isset($confpass))echo "<br><span class='error-message server'>".ENTER_CONFPASS."</span>";?>
                <?php if(isset($conflict))echo "<br><span class='error-message server'>".NEWCONFPASS."</span>";?>
                                        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <input type="submit" name="change_pwd" id="change_pwd" class="btn btn-info" value="Submit" title="Submit"  />
                                        </td>
                                    </tr>

                                </tbody>
                            </table>                 

                        </form>
                    </div>
                </section>
            </section>
        </section>
    </section>
</section>
<?php echo $this->Html->script(array('combodate/combodate', 'parsley/parsley.min', 'select2/select2.min', 'wysiwyg/jquery.hotkeys', 'wysiwyg/bootstrap-wysiwyg', 'wysiwyg/demo'), true); ?>