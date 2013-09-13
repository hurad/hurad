$(function () {
    $(".meta-box-sortables").sortable({
        connectWith: ".meta-box-sortables",
        revertDuration: 50000,
        scope: 'scope',
        opacity: 0.50,
        handle: '.portlet-header'
    });

    $(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
        .find(".portlet-header")
        .addClass("ui-widget-header ui-corner-all")
        .prepend("<span class='ui-icon ui-icon-minusthick'></span>")
        .end()
        .find(".portlet-content");

    $(".portlet-header .ui-icon").click(function () {
        //            $(".portlet-header").css("border-radius", "5px");
        $(this).toggleClass("ui-icon-minusthick").toggleClass("ui-icon-plusthick");
        $(this).parents(".portlet:first").find(".portlet-content").toggle();
    });

});

function cApprove(id) {
    $('#comment-' + id).removeClass("unapproved", {
        duration: 10000
    }).addClass("approved", {
            duration: 10000
        });
    $('#comment-' + id + ' span.approve').css("display", "none", {
        duration: 10000
    });
    $('#comment-' + id + ' span.unapprove').css("display", "", {
        duration: 10000
    });
    $('#dashboard_right_now').load(location.href + " #dashboard_right_now .portlet-header, #dashboard_right_now .portlet-content");
}

function cUnapprove(id) {
    $('#comment-' + id).removeClass("approved", {
        duration: 10000
    }).addClass("unapproved", {
            duration: 10000
        });
    $('#comment-' + id + ' span.unapprove').css("display", "none", {
        duration: 10000
    });
    $('#comment-' + id + ' span.approve').css("display", "", {
        duration: 10000
    });
    $('#dashboard_right_now').load(location.href + " #dashboard_right_now .portlet-header, #dashboard_right_now .portlet-content");
}

function cSpam(id) {
    //Get comment author.
    var User = $("#comment-" + id + " a.url").text();

    //Create copy of #comment-id and change id and class attribute.
    var comment = $("#comment-" + id).clone().attr({
        id: "undo-" + id,
        class: ''
    }).addClass("undo unspam").animate({
            opacity: .7
        }, "slow");

    //Hide #comment-id and write comment variable.
    $("#comment-" + id).css("display", "none").before(comment);
    $("#undo-" + id + " div.dashboard-comment-wrap").html("").attr("class", "").addClass("spam-undo-inside");
    $("#undo-" + id + " img").appendTo("#undo-" + id + " .spam-undo-inside");

    //Insert text comment spam
    $("#undo-" + id + " .spam-undo-inside").append("Comment by <strong>" + User + "</strong> marked as spam.");

    //Insert undo link.
    $("#undo-" + id + " .spam-undo-inside").append(' <span class="undo unspam"><a href="' + Hurad.basePath + 'admin/#" class="">Undo</a></span>');

    $('#dashboard_right_now').load(location.href + " #dashboard_right_now .portlet-header, #dashboard_right_now .portlet-content");
    $("#undo-" + id + " span.unspam a").bind("click", function (event) {

        if ($("#comment-" + id).hasClass("approved")) {
            var url = Hurad.basePath + "admin\/comments\/action\/approved\/" + id;
        } else if ($("#comment-" + id).hasClass("unapproved")) {
            var url = Hurad.basePath + "admin\/comments\/action\/disapproved\/" + id;
        }

        $.ajax({
            success: function (data, textStatus) {
                $("#undo-" + id).remove();
                $("#comment-" + id).css("display", "");
                $('#dashboard_right_now').load(location.href + " #dashboard_right_now .portlet-header, #dashboard_right_now .portlet-content");
            },
            url: url
        });
        return false;
    });
}

function cTrash(id) {
    //Get comment author.
    var User = $("#comment-" + id + " a.url").text();

    //Create copy of #comment-id and change id and class attribute.
    var comment = $("#comment-" + id).clone().attr({
        id: "undo-" + id,
        class: ''
    }).addClass("undo untrash").animate({
            opacity: .7
        }, "slow");

    //Hide #comment-id and write comment variable.
    $("#comment-" + id).css("display", "none").before(comment);
    $("#undo-" + id + " div.dashboard-comment-wrap").html("").attr("class", "").addClass("trash-undo-inside");
    $("#undo-" + id + " img").appendTo("#undo-" + id + " .trash-undo-inside");

    //Insert text comment trash
    $("#undo-" + id + " .trash-undo-inside").append("Comment by <strong>" + User + "</strong> moved to the trash.");

    //Insert undo link.
    $("#undo-" + id + " .trash-undo-inside").append(' <span class="undo untrash"><a href="' + Hurad.basePath + 'admin/#" class="">Undo</a></span>');

    $('#dashboard_right_now').load(location.href + " #dashboard_right_now .portlet-header, #dashboard_right_now .portlet-content");
    $("#undo-" + id + " span.untrash a").bind("click", function (event) {

        if ($("#comment-" + id).hasClass("approved")) {
            var url = Hurad.basePath + "admin\/comments\/action\/approved\/" + id;
        } else if ($("#comment-" + id).hasClass("unapproved")) {
            var url = Hurad.basePath + "admin\/comments\/action\/disapproved\/" + id;
        }

        $.ajax({
            success: function (data, textStatus) {
                $("#undo-" + id).remove();
                $("#comment-" + id).css("display", "");
                $('#dashboard_right_now').load(location.href + " #dashboard_right_now .portlet-header, #dashboard_right_now .portlet-content");
            },
            url: url
        });
        return false;
    });
}