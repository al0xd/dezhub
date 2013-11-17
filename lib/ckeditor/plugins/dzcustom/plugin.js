/**
 * Basic sample plugin inserting dzcustomeviation elements into CKEditor editing area.
 * Updated to add context menu support and possibility to edit a previously added dzcustomeviation element.
 */

// Register the plugin with the editor.
// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.plugins.html
CKEDITOR.plugins.add( 'dzcustom',
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
		editor.addCommand( 'dzDialog',new CKEDITOR.dialogCommand( 'dzDialog' ) );
		
		// Create a toolbar button that executes the plugin command. 
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.ui.html#addButton
		editor.ui.addButton( 'DezhubCustom',
		{
			// Toolbar button tooltip.
			label: 'Thêm các thẻ BBcode',
			// Reference to the plugin command name.
			command: 'dzDialog',
			// Button's icon file path.
			icon: iconPath
		} );
		
		// Add context menu support.
		if ( editor.contextMenu )
		{
			// Register a new context menu group.
			editor.addMenuGroup( 'myGroup' );
			// Register a new context menu item.
			editor.addMenuItem( 'dzcustomItem',
			{
				// Item label.
				label : 'Edit Dezcustom',
				// Item icon path using the variable defined above.
				icon : iconPath,
				// Reference to the plugin command name.
				command : 'dzDialog',
				// Context menu group that this entry belongs to.
				group : 'myGroup'
			});
			// Enable the context menu only for an <dzcustom> element.
			editor.contextMenu.addListener( function( element )
			{
				// Get to the closest <dzcustom> element that contains the selection.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.node.html#getAscendant
				if ( element )
					element = element.getAscendant( 'abbr', true );
				// Return a context menu object in an enabled, but not active state.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.html#.TRISTATE_OFF
				if ( element && !element.isReadOnly() && !element.data( 'cke-realelement' ) )
		 			return { dzcustomItem : CKEDITOR.TRISTATE_OFF };
				// Return nothing if the conditions are not met.
		 		return null;
			});
		}
	CKEDITOR.dialog.add( 'dzDialog', this.path + 'dialogs/dialog.js' );

	}
} );