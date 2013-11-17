		
		// Add a dialog window definition containing all UI elements and listeners.
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.html#.add
		CKEDITOR.dialog.add( 'dzLayout', function ( editor )
		{
			return {
				// Basic properties of the dialog window: title, minimum size.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.dialogDefinition.html
				title : 'Cấu hình thẻ',
				minWidth : 400,
				minHeight : 200,
				// Dialog window contents.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.definition.content.html
				contents :
				[
					{
						// Definition of the Basic Settings dialog window tab (page) with its id, label and contents.
						// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.contentDefinition.html
						id : 'tab1',
						label : 'Cấu hình đơn giản',
						elements :
						[
							{
								type : 'select',
								id : 'style',
								label : 'BBcode types',
								items : 
								[
									[ 'Headings','headings' ],
									[ 'List', 'list' ],
									[ 'Table', 'table' ],
									[ 'Blockquotes', 'blockquotes' ],
									[ 'Misc', 'misc' ],
									[ 'Layouts', 'layouts' ],
									[ 'Buttons', 'buttons' ],
									[ 'PricingTables', 'pricingTables' ],
									[ 'Accordions', 'accordions' ],
									[ 'Tabs', 'tabs' ],
								]
								
							},							
						]
					}
				],
				// This method is invoked once a dialog window is loaded. 
				onShow : function()
				{},				
				// This method is invoked once a user closes the dialog window, accepting the changes.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.dialogDefinition.html#onOk
				onOk : function()
				{
					// A dialog window object.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.html 
				//	var sel = editor.getSelection();
				//	dzcustom = this.element;
					// If we are not editing an existing dzcustomeviation element, insert a new one.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#insertElement
				//	if ( this.insertMode )
				var dialog = CKEDITOR.dialog.getCurrent();
					var tUrl = dialog.getValueOf('tab1', 'style');
					//console.log(tUrl);
						editor.insertHtml( "{"+tUrl+"}{/"+tUrl+"}" );
				//	
					// Populate the element with values entered by the user (invoke commit functions).
				//	this.commitContent( "{}" );
				}
			};
		} );
