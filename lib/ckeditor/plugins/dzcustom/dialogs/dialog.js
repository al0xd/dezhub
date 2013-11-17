		
		// Add a dialog window definition containing all UI elements and listeners.
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.html#.add
		CKEDITOR.dialog.add( 'dzDialog', function ( editor )
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
								],
								onChange : function( api ) {
										// get current dialog
									///	var dialog = CKEDITOR.dialog.getCurrent();
										// get the info tab in the dialog
									///	dialog.selectPage('tab1');
										// get the txtUrl element (found id using devtools plugin)
									//	var tUrl = dialog.getContentElement('tab1', 'style2');
										// set this input box to by variable
									//	tUrl.setValue([["Row","1111"],['a',2]]);
								},
							
								setup : function( element )
								{
									this.setValue( element.getAttribute( "data-type" ) );
								},
								// Function to be run when the commitContent method of the parent dialog window is called.
								// Set the element's title attribute to the value of this field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#setAttribute
								commit : function( element )
								{
									element.setAttribute( "data-type", this.getValue() );
								}
							},							
							
							{
								// Dialog window UI element: a text input field for the dzcustomeviation text.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.ui.dialog.textInput.html
								type : 'textarea',
								id : 'dzcustom',
								// Text that labels the field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.ui.dialog.labeledElement.html#constructor
								label : 'Nội dung',
								// Validation checking whether the field is not empty.
								validate : CKEDITOR.dialog.validate.notEmpty( "Không được để trống nội dung này." ),
								// Function to be run when the setupContent method of the parent dialog window is called.
								// It can be used to initialize the value of the field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#setValue
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#getText
								setup : function( element )
								{
									this.setValue( element.getText() );
								},
								// Function to be run when the commitContent method of the parent dialog window is called.
								// Set the element's text content to the value of this field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#setText
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#getValue
								commit : function( element )
								{
									element.setText( this.getValue() );
								}
							},
							{
								// Another text input field for the explanation text with a label and validation.
								type : 'text',
								id : 'title',
								label : 'Tiêu đề',
								validate : CKEDITOR.dialog.validate.notEmpty( "Tiêu đề không được để trống." ),
								// Function to be run when the setupContent method of the parent dialog window is called.
								// It can be used to initialize the value of the field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#getAttribute
								setup : function( element )
								{
									this.setValue( element.getAttribute( "title" ) );
								},
								// Function to be run when the commitContent method of the parent dialog window is called.
								// Set the element's title attribute to the value of this field.
								// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#setAttribute
								commit : function( element )
								{
									element.setAttribute( "title", this.getValue() );
								}
							}	 
						]
					},
					{
						// Definition of the Advanced Settings dialog window tab with its id, label, and contents.
						id : 'tab2',
						label : 'Cấu hình chuyên sâu',
						elements :
						[
							{
								// Yet another text input field for the dzcustomeviation ID.
								// No validation added since this field is optional.
								type : 'text',
								id : 'id',
								label : 'Id',
								// Function to be run when the setupContent method of the parent dialog window is called.
								// It can be used to initialize the value of the field. 
								setup : function( element )
								{
									this.setValue( element.getAttribute( "id" ) );
								},
								// Function to be run when the commitContent method of the parent dialog window is called.
								commit : function ( element )
								{
									var id = this.getValue();
									// If the field is non-empty, use its value to set the element's id attribute.
									if ( id )
										element.setAttribute( 'id', id );
									// If on editing the value was removed by the user, the id attribute needs to be removed.
									// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#removeAttribute
									else if ( !this.insertMode )
										element.removeAttribute( 'id' );
								}
							},
							{
								// Yet another text input field for the dzcustomeviation ID.
								// No validation added since this field is optional.
								type : 'text',
								id : 'class',
								label : 'Class',
								// Function to be run when the setupContent method of the parent dialog window is called.
								// It can be used to initialize the value of the field. 
								setup : function( element )
								{
									this.setValue( element.getAttribute( "class" ) );
								},
								// Function to be run when the commitContent method of the parent dialog window is called.
								commit : function ( element )
								{
									var _class = this.getValue();
									// If the field is non-empty, use its value to set the element's id attribute.
									if ( _class )
										element.setAttribute( 'class', _class );
									// If on editing the value was removed by the user, the id attribute needs to be removed.
									// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#removeAttribute
									else if ( !this.insertMode )
										element.removeAttribute( 'class' );
								}
							},
							{
							
								// Yet another text input field for the dzcustomeviation ID.
								// No validation added since this field is optional.
								type : 'textarea',
								id : 'style',
								label : 'Style',
								// Function to be run when the setupContent method of the parent dialog window is called.
								// It can be used to initialize the value of the field. 
								setup : function( element )
								{
									this.setValue( element.getAttribute( "style" ) );
								},
								// Function to be run when the commitContent method of the parent dialog window is called.
								commit : function ( element )
								{
									var _style = this.getValue();
									// If the field is non-empty, use its value to set the element's id attribute.
									if ( _style )
										element.setAttribute( 'style', _style );
									// If on editing the value was removed by the user, the id attribute needs to be removed.
									// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.element.html#removeAttribute
									else if ( !this.insertMode )
										element.removeAttribute( '_style' );
								}
							
							}
						]
					}
				],
				// This method is invoked once a dialog window is loaded. 
				onShow : function()
				{
					// Get the element selected in the editor.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#getSelection
					var sel = editor.getSelection(),
					// Assigning the element in which the selection starts to a variable.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.selection.html#getStartElement
						element = sel.getStartElement();
					
					// Get the <dzcustom> element closest to the selection.
					if ( element )
						element = element.getAscendant( 'abbr', true );
					
					// Create a new <dzcustom> element if it does not exist.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dom.document.html#createElement
					// For a new <dzcustom> element set the insertMode flag to true.
					if ( !element || element.getName() != 'abbr' || element.data( 'cke-realelement' ) )
					{
						element = editor.document.createElement("abbr");
						this.insertMode = true;
					}
					// If an <dzcustom> element already exists, set the insertMode flag to false.
					else
						this.insertMode = false;
					
					// Store the reference to the <dzcustom> element in a variable.
					this.element = element;
					
					// Invoke the setup functions of the element.
					this.setupContent( this.element );
				},				
				// This method is invoked once a user closes the dialog window, accepting the changes.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.dialogDefinition.html#onOk
				onOk : function()
				{
					// A dialog window object.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.dialog.html 
					var sel = editor.getSelection();
					dzcustom = this.element;
					// If we are not editing an existing dzcustomeviation element, insert a new one.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#insertElement
					if ( this.insertMode )
						editor.insertElement( dzcustom );
					
					// Populate the element with values entered by the user (invoke commit functions).
					this.commitContent( dzcustom );
				}
			};
		} );
