/**
 * Basic sample plugin inserting dzcustomeviation elements into CKEditor editing area.
 * Updated to add context menu support and possibility to edit a previously added dzcustomeviation element.
 */

// Register the plugin with the editor.
// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.plugins.html
CKEDITOR.plugins.add( 'layout',
{
	// The plugin initialization logic goes inside this method.
	// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.pluginDefinition.html#init
	init: function( editor )
	{
		// Place the icon path in a variable to make it easier to refer to it later.
		// "this.path" refers to the directory where the plugin.js file resides.
		var iconPath = this.path + 'images/dzicon.png';

		// Define an editor command that inserts an dzcustomeviation. 
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#addCommand
		editor.addCommand( 'dzLayout',new CKEDITOR.dialogCommand( 'dzLayout' ) );
		
		// Create a toolbar button that executes the plugin command. 
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.ui.html#addButton
		editor.ui.addButton( 'DzLayoutButton',
		{
			// Toolbar button tooltip.
			label: 'Thêm layout',
			// Reference to the plugin command name.
			command: 'dzLayout',
			// Button's icon file path.
			icon: iconPath
		} );
		
		// Add context menu support.
	CKEDITOR.dialog.add( 'dzLayout', this.path + 'dialogs/dialog.js' );

	}
} );