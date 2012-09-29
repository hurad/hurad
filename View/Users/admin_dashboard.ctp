<?php
App::uses('Formatting', 'Lib');
$formatting = new Formatting();
?>
<!--<script type="text/javascript">
    //<![CDATA[
    $(document).ready(function () {
        
        $("#link-1619952504").bind("click", function (event) {
            alert('Hello')
//            $.ajax({
//                dataType:"html", 
//                success:function (data, textStatus) {
//                    $("#the-comment-list").html(data);
//                }, 
//                url:"\/hurad\/admin\/comments\/approve\/37"
//            });
            //return false;
        });
    });
    //]]>
</script>-->
<style>

    #the-comment-list .comment-item:first-child {
        border-top: medium none;
    }
    #the-comment-list .unapproved {
        background-color: #FFFFE0;
    }
    #the-comment-list .comment-item, #the-comment-list #replyrow {
        margin: 0;
    }
    #the-comment-list .comment-item:hover .row-actions {
        visibility: visible !important;
    }
    #the-comment-list .comment-item {
        border-top: 1px solid;
        padding: 1em 15px;
    }
    #the-comment-list .comment-item .avatar {
        float: left;
        margin: 0 10px 5px 0;
    }
    .dashboard-comment-wrap {
        overflow: hidden;
        word-wrap: break-word;
    }
    #the-comment-list .comment-item h4 {
        color: #999999;
        font-weight: normal;
        line-height: 1.4;
        margin-top: -0.2em;
    }
    #the-comment-list .comment-item h4 cite {
        font-style: normal;
        font-weight: normal;
    }
    #dashboard-widgets a {
        text-decoration: none;
    }
    #dashboard_recent_comments .comment-meta .approve {
        font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
        font-size: 10px;
        font-style: italic;
    }
    .unapproved .approve, .spam .approve, .trash .approve {
        display: inline;
    }
    #the-comment-list .comment-item blockquote, #the-comment-list .comment-item blockquote p {
        display: inline;
        margin: 0;
        padding: 0;
    }
    #the-comment-list .comment-item p.row-actions {
        font-size: 10px;
        margin: 3px 0 0;
        padding: 0;
    }
    .row-actions {
        padding: 2px 0 0;
        visibility: hidden;
    }
    #the-comment-list .comment-item, #dashboard-widgets #dashboard_quick_press form p.submit {
        border-color: #DFDFDF;
    }

    .postbox p, .postbox ul, .postbox ol, .postbox blockquote, #wp-version-message {
        font-size: 11px;
    }

    .textright {
        text-align: right;
    }
    p {
        margin: 1em 0;
    }
    p, li, dl, dd, dt {
        line-height: 140%;
    }




    #dashboard-widgets h4 {
        font-family: Georgia,"Times New Roman","Bitstream Charter",Times,serif;
        font-size: 13px;
        margin: 0 0 0.2em;
        padding: 0;
    }





    #dashboard_right_now .table_content {
        border-top: 1px solid #ECECEC;
        float: left;
        width: 45%;
    }
    #dashboard_right_now .table {
        margin: 0 -9px;
        padding: 0 10px;
        position: relative;
    }
    #dashboard_right_now p.sub, #dashboard_right_now .table, #dashboard_right_now .versions {
        margin: -9px;
    }
    #dashboard_right_now p.sub {
        color: #777777;
        font-family: Georgia,"Times New Roman","Bitstream Charter",Times,serif;
        font-size: 13px;
        font-style: italic;
        left: 15px;
        padding: 2px 6px 15px;
        position: absolute;
        top: -17px;
    }
    #dashboard_right_now table tr.first td {
        border-top: medium none;
    }
    #dashboard_right_now td.b {
        font-family: Georgia,"Times New Roman","Bitstream Charter",Times,serif;
        font-size: 14px;
        padding-right: 6px;
        text-align: right;
        width: 1%;
    }
    #dashboard_right_now table td {
        padding: 3px 0;
        white-space: nowrap;
    }
    #dashboard_right_now td.b a {
        font-size: 18px;
    }

    #dashboard_right_now .t {
        color: #777777;
        font-size: 12px;
        padding-right: 12px;
        padding-top: 6px;
    }
    #dashboard_right_now .table_discussion {
        border-top: 1px solid #ECECEC;
        float: right;
        width: 45%;
    }
    #dashboard_right_now .approved {
        color: green;
    }
    #dashboard_right_now .waiting {
        color: #E66F00;
    }
    #dashboard_right_now .spam {
        color: red;
    }
    #dashboard_right_now .versions {
        clear: left;
        padding: 6px 10px 12px;
    }
    #dashboard_right_now a.button {
        clear: right;
        float: right;
        position: relative;
        top: -5px;
    }
    div.inside {
        margin: 10px;
        position: relative;
    }   
    #dashboard_right_now .inside {
        font-size: 12px;
        padding-top: 30px;
    }





    .portlet{
        background-color: #FFFFFF;
        border-color: #DFDFDF;
        border-radius: 6px 6px 6px 6px;
        border-style: solid;
        border-width: 1px;
        margin-bottom: 20px;
        min-width: 255px;
        /* position: relative;*/
        width: 99.5%;
    }
    .portlet-header{
        background: -moz-linear-gradient(center bottom , #DFDFDF, #EDEDED) repeat scroll 0 0 transparent;
        border-radius: 5px 5px 0 0;
        height: 22px;
        padding: 5px 8px 0 10px;
        text-shadow: 0 1px 0 #FFFFFF;
        cursor: move;
    }

    .portlet-header-toggle{
        border-radius: 5px 5px 5px 5px !important;
    }



    #dashboard-widgets .meta-box-sortables {
        margin: 0 5px;
    }
    .postbox-container .meta-box-sortables {
        min-height: 300px;
    }


    .column { 
        width: 49%; 
        float: left; 
        /* padding-bottom: 100px;*/
        padding-right: 0.5%;
    }
    .portlet-header .ui-icon { float: right; }
    /*    .portlet-content { padding: 0.4em; }*/

    .ui-sortable-placeholder {
        border-style: dashed;
        border-width: 1px;
        border-radius: 0px;
        margin-bottom: 20px;
        background-color: #F5F5F5;
        border-color: #BBBBBB;
        visibility: visible !important;
        /* height: 50px !important; */
    }
    .ui-sortable-placeholder * { 
        visibility: hidden; 
    }

    .ui-sortable .portlet h3 {
        color: #464646;
        margin: 0;
        font-size: 12px;
    }
    .ui-icon{
        background-image: url('../img/222222_256x240_icons_icons.png');
        height: 16px;
        width: 16px;
        background-repeat: no-repeat;
        display: block;
        overflow: hidden;
        text-indent: -99999px;
        cursor: pointer;
    }
    .portlet-header .ui-icon {
        float: right;
    }
    .ui-icon-minusthick {
        background-position: -64px -128px;
    }
    .ui-icon-plusthick {
        background-position: -32px -128px;
    }
</style>
<script>
    $(function() {
        $( ".meta-box-sortables" ).sortable({
            connectWith: ".meta-box-sortables",
            revertDuration:50000,
            scope:'scope',
            opacity: 0.50,
            handle: '.portlet-header'
        });

        $( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
        .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
        .end()
        .find( ".portlet-content" );

        $( ".portlet-header .ui-icon" ).click(function() {
            //            $(".portlet-header").css("border-radius", "5px");
            $( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
            $( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
        });

        //$( '.portlet-content' ).disableSelection();
    });


</script>
<h2>Dashboard</h2>

<div id="dashboard-widgets-wrap">

    <div id="dashboard-widgets" class="metabox-holder">

        <div class="column column-1">
            <div id="normal-sortables" class="meta-box-sortables">
                <div id="dashboard_recent_comments" class="portlet">
                    <div class="portlet-header">
                        <h3>Recent Comment</h3>
                    </div>
                    <div class="portlet-content">
                        <?php $this->Dashboard->dashboard_recent_comments(); ?>
                        <p class="textright" style="padding: 0 15px;">
                            <?php echo $this->Html->link(__('View all'), '/admin/comments', array('class' => 'add_button')); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="column column-2">
            <div id="normal-sortables" class="meta-box-sortables">
                <div  id="dashboard_right_now" class="portlet">
                    <div class="portlet-header">
                        <h3>Right Now</h3>
                    </div>
                    <div class="portlet-content">
                        <div class="inside">
                            <?php $this->Dashboard->dashboard_right_now(); ?>
                            <div class="versions">
                                <br class="clear">
                                <span id="wp-version-message">You are using <span style="font-weight: bold;">Hurad 1.0.0</span></span>
                                <br class="clear">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

