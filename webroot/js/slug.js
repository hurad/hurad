$(document).ready(function(){
    var settings = {
        hide: true
    };
    if (settings.hide) {
        $('input#PostSlug').after("<span class='postSlug'></span>");
        $('input#PostSlug').hide();
    }
    
    $("#PostTitle").keyup(function(){
        var Text = $.trim($(this).val()).replace(/^-+|-+$/g, '').replace(/-+/g, '-');
        Text = Text.toLowerCase().replace(/[\!\@\#\$\%\^\&\*\(\)\~\`\_\=\+\{\}\[\]\<\>\|\"\'\/\?\.\,\;\:]/g, '');
        var finishedslug = Text.replace(/\s+/g,'-');
        $('input#PostSlug').val(finishedslug);
        $('span.postSlug').text(finishedslug);    
    });
        
    //
    $("#perma_edit").click(function(){
        $("#perma_edit").hide();
        //$("#perma_ok").show();
        $("#perma_edit").after('<button id="perma_ok" class="add_button" type="button">OK</button>');
        $(".postSlug").fadeToggle("fast", "linear", function(){
            return false;
        });
        $('#perma_ok').click(function(){      
            $("input.postSlug").keyup(function(){ 
                var str = $.trim($(this).val()).replace(/^-+|-+$/g, '').replace(/-+/g, '-');
                str = str.toLowerCase().replace(/[\!\@\#\$\%\^\&\*\(\)\~\`\_\=\+\{\}\[\]\<\>\|\"\'\/\?\.\,\;\:]/g, '');
                var strstr = str.replace(/\s+/g,'-');
                $('span.postSlug').text(strstr);
            });
            //
            var strstr = $('span.postSlug').text();
            $('input#PostSlug').val(strstr);
            
            //
            $('input#PostSlug').hide();
            $('span.postSlug').show();
            $("#perma_ok").remove();
            $("#perma_edit").show();            
        })
            
    });
});

