$(document).ready(function()
    {
        $('li.top-menu').click(function() {
            
            $( this ).toggleClass( "active" ).toggleClass( "active2" );
            $( this ).parents( ".menu:first" ).find( ".sb" ).slideToggle('normal');

        });
    });




    