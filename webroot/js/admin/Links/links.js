/**
 * Links
 *
 * for LinksController
 */
var Links = {};

/**
 * functions to execute when document is ready
 *
 * only for LinkcatsController
 *
 * @return void
 */
Links.documentReady = function() {
    Links.search();
}

/**
 * Submits form for searching Pages
 *
 * @return void
 */
Links.search = function() {

    $('#AdminSearchForm').submit(function() {
        var q = '';

        //query string
        if ($('#LinkQ').val() != '') {
            q = $('#LinkQ').val();
        }
        var loadUrl = Hurad.basePath + 'admin/links/index';
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
    if (Hurad.params.controller == 'links') {
        Links.documentReady();
    }
});
