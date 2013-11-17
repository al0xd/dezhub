/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	 config.language = 'vi';
	 config.allowedContent = true;
//	config.protectedSource.push( /<i[\s\S]*?\>\<\/i\>/g ); //allows i empty tag
//	config.protectedSource.push( /<abbr[\s\S]*?\>\*?<\/abbr\>/g ); //allows div empty tag	
//	config.protectedSource.push( /<div[\s\S]*?\>.*<\/div\>/g ); //allows beginning <span> tag	
	// config.uiColor = '#AADC6E';
	config.basicEntities = false;
	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;
};
