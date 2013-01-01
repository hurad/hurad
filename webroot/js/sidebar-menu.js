$(document).ready(function()
    {
        $('li.top-menu').click(function() {
            
            $( this ).toggleClass( "active" ).toggleClass( "active2" );
            $( this ).parents( ".menu:first" ).find( ".sb" ).slideToggle('normal');

        });

        if(Hurad.params.action == "admin_index" || Hurad.params.action == "admin_filter"){
            $('a[href$="'+Hurad.params.controller+'"]').parent().addClass("current"); 
        }
        else if(Hurad.params.action == "admin_add"){
            $('a[href$="'+Hurad.params.controller+'/add"]').parent().addClass("current"); 
        }
        else if(Hurad.params.action == "admin_prefix"){
            $('a[href$="'+Hurad.params.pass+'"]').parent().addClass("current");
        }
        
        $('li.current').parents('li.sb').css("display", "list-item");
        $('li.current').parents('ul.menu').find( ".top-menu" ).addClass("active");
    });




    