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
Pages.documentReady = function() {
    Pages.search();
}

/**
 * Submits form for searching Pages
 *
 * @return void
 */
Pages.search = function() {

    $('#AdminSearchForm').submit(function() {
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
 * document ready
 *
 * @return void
 */
$(document).ready(function() {
    if (Hurad.params.controller == 'pages') {
        Pages.documentReady();
    }
});
