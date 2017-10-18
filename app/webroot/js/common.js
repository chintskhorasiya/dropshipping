


function pass_ajax_call()
{
    $.ajax({
        type: 'POST',
        url: passurl,
        data: 'string_id=' + string_id + '&type=' + passtype,
        success: function(data, textStatus, xhr)
        {
            $('#change_version_data').html(data);
            $('#ajaxloader').hide();
        }
    });
}

//End for version
function dump(arr, level)
{
    var dumped_text = "";
    if (!level)
        level = 0;

    //The padding given at the beginning of the line.
    var level_padding = "";
    for (var j = 0; j < level + 1; j++)
        level_padding += "    ";

    if (typeof(arr) == 'object') { //Array/Hashes/Objects
        for (var item in arr) {
            var value = arr[item];

            if (typeof(value) == 'object') { //If it is an array,
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += dump(value, level + 1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
            }
        }
    } else { //Strings/Chars/Numbers etc.
        dumped_text = "===>" + arr + "<===(" + typeof(arr) + ")";
    }
    return dumped_text;
}

function htmlEntities1(str) {
    //return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    return String(str).replace(/&amp;/g, 'amp;').replace(/&lt;/g, 'lt;').replace(/&gt;/g, 'gt;').replace(/&quot;/g, 'quot;').replace(/&nbsp;/g, 'nbsp;');
}

function submitnote()
{
    var check_desc = htmlEntities1($('#editor').html());
    var check_desc1 = remove_br_space(stripHTML(check_desc));
    //alert(check_desc);

    if ($.trim(check_desc1) != '')
    {
        $('#ajaxloader1').show();
        $.ajax({
            type: 'POST',
            url: site_url + 'events/uploadfiles',
            data: $('#frmaddnote').serialize() + '&description=' + check_desc,
            success: function(data, textStatus, xhr)
            {
                $('#ajaxloader1').hide();
                if (data == '')
                {
                    $('#error_description').show();
                    $('#error_description').html('Please enter description');
                }
                else
                {
                    $("#display_notes1").after(data);
                    var lastnote = $('#note_modified_date').html();
                    $("#lastnotes_" + $('#hidden_eventid').val()).html(lastnote);
                    $('#recnot_found').remove();
                }
                removeval();
            }
        });
    }
    else
    {
        $('#error_description').show();
        $('#error_description').html('Please enter description');
    }
}

function remove_br_space(docDescription)
{
    var docDesc = docDescription.replace(/[&]nbsp[;]/gi, "");
    var docDesc1 = docDesc.replace(/[<]br[^>]*[>]/gi, "");  // removes all <br>        
    return docDesc1;
}

function stripHTML(text) {
    var regex = /(<([^>]+)>)(&nbsp;)*/g;
    return text.replace(regex, "");
}

function removeval()
{
    $('#error_description').hide();
    $('#description').val('');
    $('#filename').val('');
    $('#progress').hide();
    $('#lblupload').hide();
    $('#files').html('');
    $('#editor').html('')
}

function check_url(eventid, pid)
{
    var currentURL = window.location.pathname;
    var urlarray = currentURL.split('/');

    //alert(urlarray[2]+'/'+urlarray[3]);

    var refreshflag = 0;
    if (urlarray[2] == 'events' && urlarray[3] == 'event_grid') {
        refreshflag = 1;
    }
    if (urlarray[2] == 'homes' && urlarray[3] == 'dashboard') {
        refreshflag = 1;
    }

    if (refreshflag == 0)
    {
        document.location.href = site_url + 'events/event_grid/?action=redirect&eventid=' + eventid + '&pid=' + pid;
    }
}

function dash_side_display_note(eventid, pid)
{
    check_url(eventid, pid);
    dash_ajax_event_grid(eventid, pid);
}

function side_display_note(eventid, pid)
{
    check_url(eventid, pid);
    ajax_event_grid(eventid, pid);
}

function display_sidebar(eventid, pid)
{
    $displayflag = 0;

    if ($("#side-bar-content").hasClass("show") == true)
    {
        if ($('#hidden_eventid').val() != eventid)
        {
            $("#side-bar-content").removeClass("show");
            $displayflag = 1;
        }
    }
    else
    {
        $displayflag = 1;
        $("#side-bar-content").addClass("show");
    }

    if ($displayflag == 1)
    {
        $('#eventclass-' + eventid).removeClass('bg-danger');
        $('#eventclass-' + eventid).addClass('bg-success');
        $('#eventclass-' + eventid).html(0);
        $('#ajaxloader').show();

        $.ajax({
            type: 'POST',
            url: site_url + 'events/display_notes',
            data: "eventid=" + eventid + '&pid=' + pid,
            success: function(data, textStatus, xhr)
            {
                $('#hidden_eventid').val(eventid);

                $("#side-bar-content").addClass("show");
                $('#side-bar-content').html(data);

                //For count unread comment
                count_comment();

                //For replace sidebar
                sidebar();

                $('#ajaxloader').hide();

            }
        });
    }
    /* */
}

function dash_display_sidebar(eventid, pid)
{

    $displayflag = 0;

    if ($("#side-bar-content").hasClass("show") == true)
    {
        if ($('#hidden_eventid').val() != eventid)
        {
            $("#side-bar-content").removeClass("show");
            $displayflag = 1;
        }
    }
    else
    {
        $displayflag = 1;
        $("#side-bar-content").addClass("show");
    }

    if ($displayflag == 1)
    {
        $('#eventclass-' + eventid).removeClass('bg-danger');
        $('#eventclass-' + eventid).addClass('bg-success');
        $('#eventclass-' + eventid).html(0);
        $('#ajaxloader').show();

        $.ajax({
            type: 'POST',
            url: site_url + 'events/display_notes',
            data: "eventid=" + eventid + '&pid=' + pid,
            success: function(data, textStatus, xhr)
            {
                $('#hidden_eventid').val(eventid);

                $("#side-bar-content").addClass("show");
                $('#side-bar-content').html(data);

                //For count unread comment
                count_comment();

                //For replace sidebar
                dash_sidebar();

                $('#ajaxloader').hide();

            }
        });
    }
    /* */
    /* */
}

function ajax_event_grid(eventid, pid)
{
    $('td').removeAttr('style');
    $.ajax({
        type: 'POST',
        url: site_url + 'events/ajax_event_grid',
        data: "eventid=" + eventid + '&pid=' + pid,
        success: function(data, textStatus, xhr)
        {
            $('#ajaxloader').hide();
            $('#event_grid').html(data);
            $('#rowid-' + eventid + ' td').css('background', '#e8ffd3');

            display_sidebar(eventid, pid);

        }
    });
}

function dash_ajax_event_grid(eventid, pid)
{
    //alert('dash_ajax_event_grid');
    $('td').removeAttr('style');
    $.ajax({
        type: 'POST',
        url: site_url + 'homes/dash_ajax_event_grid',
        data: "eventid=" + eventid + '&pid=' + pid,
        success: function(data, textStatus, xhr)
        {
            //alert('test');
            $('#ajaxloader').hide();

            $('#dash_eventdata').html('');
            $('#dash_eventdata').html(data);
            $('#rowid-' + eventid + ' td').css('background', '#e8ffd3');

            dash_display_sidebar(eventid, pid);
        }
    });
}

function dash_display_note(eventid, pid)
{
    //alert($('#hidden_eventid').val()+' == '+eventid);
    //alert($( "#side-bar-content" ).hasClass("show"));
    //alert($('#hidden_eventid').val()+' != '+eventid);

    $('td').removeAttr('style');
    var displayflag = 0;

    if ($("#side-bar-content").hasClass("show") == true)
    {
        if ($('#hidden_eventid').val() != eventid)
        {
            $("#side-bar-content").removeClass("show");
            displayflag = 1;
        }
        else
        {
            $("#side-bar-content").removeClass("show");
        }
    }
    else
    {
        displayflag = 1;
        //$( "#side-bar-content" ).addClass("show");
    }

    if (displayflag == 1)
    {
        $('#eventclass-' + eventid).removeClass('bg-danger');
        $('#eventclass-' + eventid).addClass('bg-success');
        $('#eventclass-' + eventid).html(0);
        $('#ajaxloader').show();

        $.ajax({
            type: 'POST',
            url: site_url + 'events/display_notes',
            data: "eventid=" + eventid + '&pid=' + pid,
            success: function(data, textStatus, xhr)
            {
                $('#hidden_eventid').val(eventid);

                $('#side-bar-content').addClass('show');
                $('#side-bar-content').html(data);

                //For count unread comment
                count_comment();

                //For replace sidebar
                dash_sidebar();

                $('#ajaxloader').hide();
            }
        });
        $('#rowid-' + eventid + ' td').css('background', '#e8ffd3');
    }
    /* */
}

function display_note(eventid, pid)
{
    //alert($('#hidden_eventid').val()+' == '+eventid);
    //alert($( "#side-bar-content" ).hasClass("show"));
    //alert($('#hidden_eventid').val()+' != '+eventid);
    //$("#side-bar-content" ).removeClass("show");

    $('td').removeAttr('style');
    $('#side-bar-content').html('');
    $('.list-group-item').removeClass('active');

    if ($("#side-bar-content").hasClass("show") == true)
    {
        if ($('#hidden_eventid').val() != eventid)
        {
            $("#side-bar-content").removeClass("show");
            event_notes(eventid, pid);
        }
        else
        {
            //alert('else');
            $("#side-bar-content").removeClass("show");
        }
    }
    else
    {
        //$("#side-bar-content" ).addClass("show");
        event_notes(eventid, pid);
    }
}

function event_notes(eventid, pid)
{
    $('#eventclass-' + eventid).removeClass('bg-danger');
    $('#eventclass-' + eventid).addClass('bg-success');
    $('#eventclass-' + eventid).html(0);
    $('#ajaxloader').show();

    $.ajax({
        type: 'POST',
        url: site_url + 'events/display_notes',
        data: "eventid=" + eventid + '&pid=' + pid,
        success: function(data, textStatus, xhr)
        {
            $('#hidden_eventid').val(eventid);

            $('#side-bar-content').html(data);
            $('#side-bar-content').addClass('show');

            //For count unread comment
            count_comment();

            //For replace sidebar
            sidebar();

            $('#ajaxloader').hide();
        }
    });
    $('#rowid-' + eventid + ' td').css('background', '#e8ffd3');
}

function count_comment()
{
    $.ajax({
        type: 'POST',
        url: site_url + 'events/count_notes',
        success: function(data1, textStatus, xhr)
        {
            if (data1 == 0)
            {
                $('#total_note').removeClass('bg-danger');
                $('#total_note').addClass('bg-success');
            }
            $('#total_note').html(data1);
        }
    });
}

function read_comment(noteid, cnt_comment)
{
    $.ajax({
        type: 'POST',
        url: site_url + 'events/ajax_unreadnote',
        data: 'noteid=' + noteid,
        success: function(data, textStatus, xhr)
        {
            if (data != 0)
            {
                $('#total_note').removeClass('bg-success');
                $('#total_note').addClass('bg-danger');
            }
            $('.nav-msg').addClass('open');
            $('#total_note').html(data);
            $('#noteread-' + noteid).addClass('notification_color');
            $('#mark_read-' + noteid).hide();
        }
    });
}

function allread()
{
    $('.nav-msg').addClass('open');
    $.ajax({
        type: 'POST',
        url: site_url + 'events/ajax_readnote',
        success: function(data, textStatus, xhr)
        {
            $('#total_note').removeClass('bg-danger');
            $('#total_note').addClass('bg-success');
            $('#total_note').html('0');

            $('.list-group-item').removeClass('notification_color');
            $('.mark_read').show();
        }
    });
}

function dash_sidebar()
{
    //For refresh sidebar
    $.ajax({
        type: 'POST',
        url: site_url + 'events/dash_ajax_property_sidebar',
        success: function(data, textStatus, xhr)
        {
            $('#property_sidebar').html(data);
        }
    });
}

function sidebar()
{
    //for refresh sidebar
    $.ajax({
        type: 'POST',
        url: site_url + 'events/ajax_property_sidebar',
        //data:'page='+page,
        success: function(data, textStatus, xhr)
        {
            $('#property_sidebar').html(data);
        }
    });

}

function displaysearch()
{
    if ($('#advance_serach').css('display') == 'block')
    {
        $('#advance_serach').hide("slow");
    }
    else
    {
        $('#advance_serach').show("slow");
    }
}

function search()
{
    $('#ajaxloader').show();
    var passurl = site_url + "homes/ajax_dash_event_grid";
    var passdata = '';

    var fdate = $('#fromdate').val();
    var tdate = $('#todate').val();
    var select_event = $('#select_event').val();

    if (fdate != '' && tdate != '') {
        passdata = passdata + 'fromdate=' + fdate + '&todate=' + tdate;
    }
    else if (fdate != '') {
        passdata = passdata + 'fromdate=' + fdate;
    }
    if (select_event != '') {
        passdata = passdata + '&event_type=' + select_event;
    }

    $.ajax({
        type: 'POST',
        url: passurl,
        data: passdata,
        success: function(data, textStatus, xhr)
        {
            console.log(data);
            $('#ajaxloader').hide();
            $('#dash_eventdata').html(data);
        }
    });
}

function changedata(comboname, comboval)
{
    var formUrl = '';
    $('#ajaxloader').show();

    //for remove value
    var fdate = $('#fromdate').val('');
    var tdate = $('#todate').val('');
    var select_event = $('#select_event').val('');

    if (comboname == 'property')
        formUrl = site_url + '/homes/ajax_dash_event_grid/property:' + comboval.value;

    $.ajax({
        type: 'POST',
        url: formUrl,
        success: function(data, textStatus, xhr)
        {
            $('#ajaxloader').hide();
            $('#dash_eventdata').html(data);
        }
    });
}

function close_notes()
{
    $('#side-bar-content').html('');
    $('#side-bar-content').removeClass('show');
    $('td').removeAttr('style');
}

function notes_divide(notes_type)
{
    //alert(notes_type);
    if (notes_type == 'internal_notes')
    {
        $('#notes_type').val('internal');
        $('#editor').css('background', '#e8ffd3');
        $('#ext_rpl').removeClass('arrow-down');
        $('#external_reply').removeClass('colortab');
        $('#int_rpl').addClass('arrow-down1');
        $('#internal_notes').addClass('back_int');
    }
    else
    {
        $('#internal_notes').removeClass('back_int');
        $('#notes_type').val('external');
        $('#editor').removeAttr('style');
        $('#int_rpl').removeClass('arrow-down1');
        $('#ext_rpl').addClass('arrow-down');
        $('#external_reply').addClass('colortab');

    }
}

function session_checking()
{
    $.post(site_url + 'events/check_session', function(data) {
        if (data == "-1")
        {
            window.location.href = site_url + 'users/index';
        }
    });
}

function setmacro_data(macroid)
{
    $('#editor').html('');
    $('#ajaxloader1').show();
    $.ajax({
        type: "Post",
        url: site_url + 'events/ajax_set_macro_data/' + macroid,
        success: function(data) {
            $('#editor').html(data);
            $('#ajaxloader1').hide();
        }
    });
}