/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.fullPage = false;
	config.extraPlugins = 'docprops';
	config.language = 'en';
	config.contentsLangDirection = 'ltr';
	config.resize_dir = 'vertical';
	config.height = '380px';
	config.protectedSource.push( /<\?[\s\S]*?\?>/g );   // PHP code
	config.protectedSource.push( /<%[\s\S]*?%>/g );   // ASP code
	config.protectedSource.push( /(]+>[\s|\S]*?<\/asp:[^\>]+>)|(]+\/>)/gi );   // ASP.Net code
	config.uiColor = '#D7D7D7';
	//config.dialog_backgroundCoverColor = 'rgb(255, 254, 253)';
	//config.dialog_backgroundCoverOpacity = [1.0, 0.0];
	//config.fontSize_defaultLabel = '15px';
	config.toolbar_Full =
[
    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },
	{ name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	{ name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
    '/',
    { name: 'styles',      items : [ 'Format' ] },
    { name: 'colors',      items : [ 'TextColor' ] },
	{ name: 'editing',     items : [ 'SpellChecker' ] },
    { name: 'clipboard',   items : [ 'Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
    { name: 'insert',      items : [ 'Image','Flash','SpecialChar','Smiley','PageBreak' ] },	
    { name: 'tools',       items : [ 'Maximize','Source','-','About' ] }
];
	// config.uiColor = '#AADC6E';
};
