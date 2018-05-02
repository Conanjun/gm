/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	/*config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph'] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		'/',
		'/',
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Templates,Print,Copy,Cut,NewPage,Save,PasteText,Paste,Replace,Find,SelectAll,Scayt,
	Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Superscript,Subscript,CopyFormatting,
	CreateDiv,Language,BidiRtl,BidiLtr,Anchor,Flash,Form,HorizontalRule,Smiley,PageBreak,Iframe,ShowBlocks,About,
	Format,Styles,Outdent,Indent,PasteFromWord,SpecialChar';*/
	
	config.toolbar = 'Full';
	 
	config.toolbar_Full =
	[
	   
	    { name: 'clipboard', items : ['Undo','Redo' ] },
		{ name: 'styles', items : [ 'Font','FontSize' ] },
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike'] },
		 { name: 'colors', items : [ 'TextColor','BGColor' ] },
	    { name: 'editing', items : [  ] },
	    { name: 'forms', items : [ ] },
	    
	    { name: 'paragraph', items : [ 'NumberedList','BulletedList','Blockquote',
	    '-','JustifyLeft','JustifyCenter','JustifyRight','Table'] },
	    { name: 'links', items : [ 'Link','Unlink'] },
	    { name: 'insert', items : ['Image','addpic'] },
	    
	   
		 { name: 'document', items : ['Source','Maximize'] }
	];
	
	config.extraPlugins = 'confighelper,addpic';
	config.removeDialogTabs = 'image:advanced;link:advanced';  
    config.filebrowserBrowseUrl = '/Admin/jsnew/ckfinder/ckfinder.html';  
    config.filebrowserImageBrowseUrl = '/Admin/jsnew/ckfinder/ckfinder.html?type=Images';  
    config.filebrowserFlashBrowseUrl = '/Admin/jsnew/ckfinder/ckfinder.html?type=Flash';  
    config.filebrowserUploadUrl = '/Admin/jsnew/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';  
    config.filebrowserImageUploadUrl = '/Admin/jsnew/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';  
    config.filebrowserFlashUploadUrl = '/Admin/jsnew/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
    config.removePlugins = 'elementspath';
};


