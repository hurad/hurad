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
        var q='';
		
        //query string
        if($('#PostQ').val() != '') {
            q=$('#PostQ').val();
        }
        var loadUrl = Hurad.basePath + 'admin/posts/index';
        if (q != '') {
            loadUrl +='/q:'+q;          
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
    if (Hurad.params.controller == 'posts') {
        Posts.documentReady();
    }
});
