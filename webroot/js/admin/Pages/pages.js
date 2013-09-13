/**
 * Pages
 *
 * for PagesController
 */
var Pages = {};

/**
 * functions to execute when document is ready
 *
 * only for PagesController
 *
 * @return void
 */
Pages.documentReady = function () {
    Pages.search();
    if (Hurad.params.action == 'admin_add', 'admin_edit') {
        Pages.widget();
    }
}

/**
 * Submits form for searching Pages
 *
 * @return void
 */
Pages.search = function () {

    $('#AdminSearchForm').submit(function () {
        var q = '';

        //query string
        if ($('#PageQ').val() != '') {
            q = $('#PageQ').val();
        }
        var loadUrl = Hurad.basePath + 'admin/pages/index';
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
Pages.widget = function () {
    $(function () {
        $(".column").sortable({
            connectWith: ".column"
        });
        $(".portlet").find(".portlet-header")
            .prepend("<span class='ui-icon ui-icon-minusthick'></span>")
            .end()
            .find(".portlet-content");
        $(".portlet-header .ui-icon").click(function () {
            $(this).toggleClass("ui-icon-minusthick").toggleClass("ui-icon-plusthick");
            $(this).parents(".portlet:first").find(".portlet-content").toggle();
        });
        //$(".column").disableSelection();
    });
}


/**
 * document ready
 *
 * @return void
 */
$(document).ready(function () {
    if (Hurad.params.controller == 'pages') {
        Pages.documentReady();
    }
});
