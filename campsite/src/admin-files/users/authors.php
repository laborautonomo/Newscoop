<?php
    require_once($GLOBALS['g_campsiteDir'].'/classes/Input.php');
    require_once($GLOBALS['g_campsiteDir'].'/classes/Image.php');
    require_once($GLOBALS['g_campsiteDir'].'/classes/ImageSearch.php');
    require_once($GLOBALS['g_campsiteDir'].'/classes/Log.php');
    // TODO: permissions
    if (!is_writable($Campsite['IMAGE_DIRECTORY'])) {
        camp_html_add_msg(getGS("Unable to add new image, target directory is not writable."));
        camp_html_add_msg(camp_get_error_message(CAMP_ERROR_WRITE_DIR, $Campsite['IMAGE_DIRECTORY']));
        camp_html_goto_page("/$ADMIN/users/authors.php");
        exit;
    }
    if (!$g_user->hasPermission('EditAuthors')) {
        camp_html_display_error(getGS("You do not have the right to change authors."));
        exit;
    }

    $id=Input::Get("id","int",-1);
    $del_id = Input::Get("del_id","int".-1);
    if ($del_id>-1)
    {
        $author = new Author($del_id);
        $author->delete();
        $logtext = getGS('Author id "$1" deleted.', $del_id);
        Log::Message($logtext, $g_user->getUserId(), 173);
        camp_html_add_msg(getGS("Author deleted."));
    }
    if ($id>-1)
    {
        $author = new Author();
        if ($id>0)
        {
            $author = new  Author($id);
        } else
        {
            $author->create();
        }
        $uploadFileSpecified = isset($_FILES['file'])
        && isset($_FILES['file']['name'])
        && !empty($_FILES['file']['name']);

        $author->setFirstName(Input::Get("first_name"));
        $author->setLastName(Input::Get("last_name"));
        $author->setBiography(Input::Get("biography"),Input::Get("lang","int",0), Input::Get("lang_first_name"), Input::Get("lang_last_name"));
        $author->setType(Input::Get("type"));
        $author->setSkype(Input::Get("skype"));
        $author->setJabber(Input::Get("jabber"));
        $author->setAim(Input::Get("aim"));
        $author->setEmail(Input::Get("email"));
        if ($uploadFileSpecified)
        {
            $attributes = array();
            $image = Image::OnImageUpload($_FILES['file'], $attributes);
            if (PEAR::isError($image)) {
                camp_html_add_msg($image->getMessage());
            }
            $author->setImage($image->getImageId());
        }
        $aliases = Input::Get("alias","array");
        $author->setAliases($aliases);

        $logtext = getGS('Author information has been changed for "$1"', $author->getName());
        Log::Message($logtext, $g_user->getUserId(), 172);
        camp_html_add_msg(getGS("Author saved."));
    }
    $author = new Author(1);
?>



<table border="0" cellspacing="0" cellpadding="0" width="100%" class="breadcrumbHolder"><tr><td class="breadcrumbTD"><span><span class="breadcrumb">Configure</span></span><span class="breadcrumb_separator">&nbsp;</span></td></tr><tr><td class="activeSection" ><span class='breadcrumb_intra_separator'><span class="breadcrumb_active">Manage Author</span></span><span>&nbsp;</span></td></tr></table>
<script type="text/javascript" src="javascript/campsite.js"></script>
<script type="text/javascript" src="javascript/fValidate/fValidate.config.js"></script>
<script type="text/javascript" src="javascript/fValidate/fValidate.core.js"></script>
<script type="text/javascript" src="javascript/fValidate/fValidate.lang-enUS.js"></script>
<script type="text/javascript" src="javascript/fValidate/fValidate.validators.js"></script>
<!--Content-->
<div class="floatBox">
    <div class="editBox">

<div class="formBlock formBlockSolo ">
              <input type="text" id="form_search" onchange="doSearch()" class="input_text" size="41" style="width:370px;"><a href="#" class="arrowButton"></a>
      </div>
        <div class="formBlock formBlockSolo">
<div class="scrollHolder">
              <div id="pane2" class="scroll-pane">
                <ul>
                  <li>
                    <input type="checkbox" name="all_authors" id="all_authors" class="input_checkbox"  checked="checked" onclick="typeFilter(0)" />
                    <label for="all_authors">All Author Types</label>
                  </li>
                  <li>
                    <input type="checkbox" name="One" id="author_one" class="input_checkbox" onclick="typeFilter(1)"/>
                    <label for="One">Author</label>
                  </li>
                  <li>
                    <input type="checkbox" name="Two" id="author_two" class="input_checkbox"  onclick="typeFilter(2)"/>
                    <label for="Two">Photographer</label>
                  </li>
                  <li>
                    <input type="checkbox" name="Three" id="author_three" class="input_checkbox" onclick="typeFilter(3)"/>
                    <label for="Three">Editor</label>
                  </li>

                </ul>
              </div>
            </div>
        </div>
        <div class="formBlock formBlockSolo lastBlock">
<a href="#" class="addButtonText marginBttmSmall" onclick="getRow(0)">Add new Author</a>
<div id="gridtable" style="float:left" class="box_table"></div>



      </div>
    </div>
</div>






<div id="leftcolumn" class="box_table" style="float:left">
<div id="detailtable" class="box_table" >Loading Data...</div>
</div>
<script type="text/javascript" charset="utf-8">
    var oTable;
    $(document).ready(function() {
        $.get('authors_ajax/grid.php',function (data){
            $("#gridtable").html(data);
            oTable=$('#grid').dataTable( {
                "bLengthChange": false,
                "bFilter": true,
                "sPaginationType": "full_numbers"} );
            $("#grid_filter").html('');
        });
        getRow(0);
    } );

    function addAlias(){
        $("#aliases").append('<input type="text" class="input_text" name="alias[]">');
    }

    function getRow(id){
        $.get('authors_ajax/detail.php?id=' + id, function(data)
        {
            $("#detailtable").html(data);
           $(function() {
		$("ul.tabs").tabs("> .pane");
            });
        }
        );
        
    }

    function changeBio(id){
        $.getJSON('authors_ajax/detail.php?id=' + id + '&getBio=1&language=' + $("#lang").val(), function(data) {
            alert(data);
            $("#bioArea").html(data.biography);
            $("#lang_first_name").val(data.first_name);
            $("#lang_last_name").val(data.last_name);
          });
    }

    function changeTranslation(id){
            $.getJSON('authors_ajax/detail.php?id=' + id + '&getBio=1&language=' + $("#lang_trans").val(), function(data)
            {
                $("#bioArea").html(data.biography);
            }
        )
    }

    function doSearch(){
        oTable.fnFilter( $("#form_search").val(),0 );
    }

    function typeFilter(id)
    {
        if (id==0 && $("#all_authors").attr('checked')){
            $("#author_one").removeAttr('checked');
            $("#author_two").removeAttr('checked');
            $("#author_three").removeAttr('checked');
            oTable.fnFilter( '',1 );
            return;
        }
        var str="";
        var multiple=false;
        if (id==1 || $("#author_one").attr('checked') ){
            $("#all_authors").removeAttr('checked');
            str = "Author";
            multiple=true;
        }
        if (id==2 || $("#author_two").attr('checked') ){
            $("#all_authors").removeAttr('checked');
            var addString="|";
            if (!multiple) {addString="";}
            str = str + addString +  "Photographer";
            multiple=true;
        }
        if (id==3 || $("#author_three").attr('checked') ){
            $("#all_authors").removeAttr('checked');
            var addString="|";
            if (!multiple) addString="";
            str = str + addString + "Editor";
            multiple=true;
        }
        if (!$("#all_authors").attr('checked') && !$("#author_one").attr('checked') && !$("#author_two").attr('checked') && !$("#author_three").attr('checked')){
            $("#all_authors").attr('checked','checked')
            str='';
        }
        oTable.fnFilter(str,1 ,true,true);
    }

</script>

<?php camp_html_copyright_notice(); ?>
