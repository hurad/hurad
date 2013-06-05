/**
 * Posts
 *
 * for PostsController
 */
var Posts = {};

/**
 * functions to execute when document is ready
 *
 * only for PagesController
 *
 * @return void
 */
Posts.documentReady = function() {
    Posts.search();
}

/**
 * Submits form for searching Pages
 *
 * @return void
 */
Posts.search = function() {

    $('#AdminSearchForm').submit(function() {
        var q = '';

        //query string
        if ($('#PostQ').val() != '') {
            q = $('#PostQ').val();
        }
        var loadUrl = Hurad.basePath + 'admin/posts/index';
        if (q != '') {
            loadUrl += '/q:' + q;
        }

        window.location = loadUrl;
        return false;
    });
}

/**
 * Sortable widget in posts admin
 *
 * @return void
 */
Posts.widget = function() {
    $(function() {
        $(".column").sortable({
            connectWith: ".column",
            placeholder: "ui-sortable-placeholder",
            forcePlaceholderSize: true,
            start: function(e, ui) {
                ui.placeholder.height(ui.item.height());
            }
        });
        $(".portlet").find(".portlet-header")
                .prepend("<span class='ui-icon ui-icon-minusthick'></span>")
                .end()
                .find(".portlet-content");
        $(".portlet-header .ui-icon").click(function() {
            $(this).toggleClass("ui-icon-minusthick").toggleClass("ui-icon-plusthick");
            $(this).parents(".portlet:first").find(".portlet-content").toggle();
        });
        //$(".column").disableSelection();
    });
}

Posts.tag_autocomplete = function() {
    $(function() {
        function split(val) {
            return val.split(/,\s*/);
        }
        function extractLast(term) {
            return split(term).pop();
        }
        $("#PostTags")
                // don't navigate away from the field on tab when selecting an item
                .bind("keydown", function(event) {
            if (event.keyCode === $.ui.keyCode.TAB &&
                    $(this).data("autocomplete").menu.active) {
                event.preventDefault();
            }
        })
                .autocomplete({
            source: function(request, response) {
                $.getJSON(Hurad.basePath + "tags/index.json", {
                    term: extractLast(request.term)
                }, response);
            },
            search: function() {
                // custom minLength
                var term = extractLast(this.value);
                if (term.length < 2) {
                    return false;
                }
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function(event, ui) {
                var terms = split(this.value);
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push(ui.item.value);
                // add placeholder to get the comma-and-space at the end
                terms.push("");
                this.value = terms.join(", ");
                return false;
            }
        });
    });
}



/**
 * document ready
 *
 * @return void
 */
$(document).ready(function() {
    if (Hurad.params.controller == 'posts') {
        Posts.documentReady();
        if (Hurad.params.action == 'admin_add', 'admin_edit') {
            Posts.widget();
            Posts.tag_autocomplete();
        }
    }
});
