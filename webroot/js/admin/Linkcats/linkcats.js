/**
 * Linkcats
 *
 * for LinkcatsController
 */
var Linkcats = {};

/**
 * functions to execute when document is ready
 *
 * only for LinkcatsController
 *
 * @return void
 */
Linkcats.documentReady = function() {
    Linkcats.search();
}

/**
 * Submits form for searching Pages
 *
 * @return void
 */
Linkcats.search = function() {

    $('#AdminSearchForm').submit(function() {
        var q = '';

        //query string
        if ($('#LinkcatQ').val() != '') {
            q = $('#LinkcatQ').val();
        }
        var loadUrl = Hurad.basePath + 'admin/linkcats/index';
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
    if (Hurad.params.controller == 'linkcats') {
        Linkcats.documentReady();
    }
});
