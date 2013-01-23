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