$(document).ready(function()
{
//    $('li.top-menu').click(function() {
//
//        $(this).toggleClass("active");
//        $(this).next().slideToggle('300');
//
//    });

    if (Hurad.params.action == "admin_index" || Hurad.params.action == "admin_filter" || Hurad.params.action == "admin_listBycategory" || Hurad.params.action == "admin_listByauthor") {
        $('a[href$="' + Hurad.params.controller + '"]').parent().parent().parent().parent().addClass("in");//add .in class to div.accordion-body
        $('a[href$="' + Hurad.params.controller + '"]').parent().addClass("active");
    }
    else if (Hurad.params.action == "admin_add") {
        if (Hurad.params.controller == "linkcats" || Hurad.params.controller == "categories" || Hurad.params.controller == "tags") {
            $('a[href$="' + Hurad.params.controller + '"]').parent().addClass("current");
        }
        $('a[href$="' + Hurad.params.controller + '/add"]').parent().addClass("current");
    }
    else if (Hurad.params.action == "admin_prefix") {
        $('a[href$="' + Hurad.params.pass + '"]').parent().addClass("current");
    }
    else if (Hurad.params.action == "admin_dashboard") {
        $('a[href$="admin"]').parent().addClass("current");
    }

    $('li.current').parents('li.sb').css("display", "list-item");
    $('li.current').parents('ul.menu').find(".top-menu").addClass("active");
});