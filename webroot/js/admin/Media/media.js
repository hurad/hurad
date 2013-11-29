function sendUrl(funcNum, url) {
    window.opener.CKEDITOR.tools.callFunction(funcNum, url, '');
}
