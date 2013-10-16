/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{	config.language = 'eg';
	config.toolbar = 'MyToolbar';
 
	config.toolbar_MyToolbar =
	[
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'paragraph', items : [ 'Outdent','Indent',
		'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name: 'links', items : [ 'Link','Unlink' ] },
		{ name: 'insert', items : [ 'Image','HorizontalRule','Smiley','SpecialChar' ] },
		'/',
		{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] }
	];
	
	
	
};

	CKEDITOR.stylesSet.add( 'my_styles',
[
    // Block-level styles: ;
    { name : 'Textarea scroll', element : 'textarea', styles : { 'overflow' : 'hidden' } },
 	{ name : 'Textarea scroll2', element : 'textarea', styles : { 'resize' : 'none' } }
	

]);
	config.stylesSet = 'my_styles';