/**
 * Comments
 *
 * for CommentsController
 */
var Comments = {};

/**
 * functions to execute when document is ready
 *
 * only for CommentsController
 *
 * @return void
 */
Comments.documentReady = function() {
    Comments.search();
}

/**
 * Submits form for searching Pages
 *
 * @return void
 */
Comments.search = function() {

    $('#AdminSearchForm').submit(function() {
        var q='';
		
        //query string
        if($('#CommentQ').val() != '') {
            q=$('#CommentQ').val();
        }
        var loadUrl = Hurad.basePath + 'admin/comments/index';
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
    if (Hurad.params.controller == 'comments') {
        Comments.documentReady();
    }
});
