<?php
$this->Html->css(array('admin/Users/dashboard'), null, array('inline' => FALSE));
App::uses('Formatting', 'Lib');
$formatting = new Formatting();
?>

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

