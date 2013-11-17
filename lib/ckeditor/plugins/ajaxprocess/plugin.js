/*
* Ajax Process by dinhhungvn
*
* Plugin name:      AjaxProcess
* Menu button name: AjaxProcess
*
* icon
* http://dezhub.com/
*
* @dinhhungvn http://wwww.dezhub.com
* @version 0.1
*/
( function() {
    CKEDITOR.plugins.add( 'ajaxprocess',
    {
        init: function( editor )
        {
           var me = this;
           CKEDITOR.dialog.add( 'AjaxProcessDialog', function (instance)
           {
              return {
                 title : 'Ajax Process',
                 minWidth : 550,
                 minHeight : 200,
                 contents :
                       [
                          {
                             id : 'iframe',
                             expand : true,
                             elements :[{
                                id : 'embedArea',
                                type : 'textarea',
                                label : 'Paste Embed Code Here',
                                'autofocus':'autofocus',
                                setup: function(element){
                                },
                                commit: function(element){
                                }
                              }]
                          }
                       ],
                  onOk: function() {
                        for (var i = 0; i < window.frames.length; i++) {
                            if (window.frames[i].name == 'iframeMediaEmbed') {
                                var content = window.frames[i].document.getElementById("embed").value;
                            }
                        }
                        // console.log(this.getContentElement( 'iframe', 'embedArea' ).getValue());
                        div = instance.document.createElement('div');
                        div.setHtml(this.getContentElement('iframe', 'embedArea').getValue());
                        instance.insertElement(div);
                  }
              };
           } );

            editor.addCommand( 'AjaxProcess', new CKEDITOR.dialogCommand( 'AjaxProcessDialog' ) );

            editor.ui.addButton( 'AjaxProcess',
            {
                label: 'Ajax Process',
                command: 'AjaxProcess',
                icon: this.path + 'images/icon.png',
                toolbar: 'ajaxprocess'
            } );
        }
    } );
} )();
