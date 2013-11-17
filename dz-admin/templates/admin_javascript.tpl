	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
   	<!-- BEGIN CORE PLUGINS -->   
	<script src="includes/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="includes/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="includes/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
	<script src="includes/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="includes/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
	<!--[if lt IE 9]>
	<script src="includes/plugins/excanvas.min.js"></script>
	<script src="includes/plugins/respond.min.js"></script>  
	<![endif]-->   
	<script src="includes/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="includes/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="includes/plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="includes/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<script src="includes/plugins/fancybox/source/jquery.fancybox.pack.js"></script>   
	
	
	
	
	<script type="text/javascript" src="includes/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script type="text/javascript" src="includes/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="includes/plugins/data-tables/jquery.dataTables.js"></script>

	<script type="text/javascript" src="includes/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
	<script type="text/javascript" src="includes/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="includes/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="includes/plugins/clockface/js/clockface.js"></script>
	<script type="text/javascript" src="includes/plugins/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="includes/plugins/bootstrap-daterangepicker/daterangepicker.js"></script> 
	<script type="text/javascript" src="includes/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
	<script type="text/javascript" src="includes/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
	<script type="text/javascript" src="includes/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>   
	<script src="includes/plugins/dropzone/dropzone.js"></script>
  <script type="text/javascript" src="includes/plugins/jquery.pulsate.min.js"></script>
	<script src="includes/plugins/jquery.pwstrength.bootstrap/src/pwstrength.js" type="text/javascript" ></script>

	<script type="text/javascript" src="includes/plugins/data-tables/DT_bootstrap.js"></script>
	<script src="includes/scripts/app.js" type="text/javascript"></script>
	<script src="includes/scripts/ui-general.js" type="text/javascript"></script>
	<script src="includes/scripts/index.js" type="text/javascript"></script>
	<script src="includes/scripts/gallery.js" type="text/javascript"></script>        
	<script src="includes/scripts/table-managed.js" type="text/javascript"></script>        
	<script src="includes/scripts/form-components.js" type="text/javascript"></script>        
	<script src="includes/scripts/slideshow.js"></script>
	<!-- END PAGE LEVEL SCRIPTS -->  
	<script type="text/javascript" src="/lib/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/lib/ckfinder/ckfinder.js"></script>
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="includes/scripts/custom.js"></script>
    <script type="text/javascript" src="/lib/datagrid/templates/datagrid.js"></script>
	{literal}<script>
		jQuery(document).ready(function() { 
		   App.init(); // initlayout and core plugins
		   Index.init();
		   Gallery.init();
		   TableManaged.init();
		   FormComponents.init();
		   if($("input[data-marks*='removeMarks']").length){
			   var keycode = $("input[data-marks*='removeMarks']").attr("data-source");
				$("input[data-marks*='removeMarks']").keyup(function(e){
					$("input[name='"+keycode+"']").val(locdau($(this).val()));
				});  
			}
		  // Slideshow();
			// setup pulsate
			 if (jQuery().pulsate) {
				jQuery('.pulsate-regular').pulsate({
					color: "#bf1c56",
                    repeat: false
				});
				jQuery('.pulsate-regular-once').pulsate({
					color: "#bf1c56",
                    repeat: false
				});
			 }

		});

function BrowseServer( startupPath, functionData )
{
	// You can use the "CKFinder" class to render CKFinder in a page:
	var finder = new CKFinder();

	// The path for the installation of CKFinder (default = "/ckfinder/").
	finder.basePath = '{/literal}{$smarty.const.SITE_URL}lib/ckfinder/{literal}';

	//Startup path in a form: "Type:/path/to/directory/"
	finder.startupPath = startupPath;

	// Name of a function which is called when a file is selected in CKFinder.
	finder.selectActionFunction = SetFileField;

	// Additional data to be passed to the selectActionFunction in a second argument.
	// We'll use this feature to pass the Id of a field that will be updated.
	finder.selectActionData = functionData;

	// Name of a function which is called when a thumbnail is selected in CKFinder.
//	finder.selectThumbnailActionFunction = ShowThumbnails;
	// Launch CKFinder
	finder.popup();
}

// This is a sample function which is called when a file is selected in CKFinder.
function SetFileField( fileUrl, data )
{
	console.log(fileUrl);
	document.getElementById( data["selectActionData"] ).value = fileUrl;
	$("#inner-"+ data["selectActionData"] ).children(".thumbnail").children("img").attr("src",fileUrl);
	$("#img-"+ data["selectActionData"] ).find(".removepic").show();
}

// This is a sample function which is called when a thumbnail is selected in CKFinder.
function removeThumb (id){
	$("#"+id).attr("value","");
	$("#inner-"+id).children(".thumbnail").children("img").attr("src","data:image/gif;base64,R0lGODdhyACWAOMAAO/v76qqqubm5t3d3bu7u7KystXV1cPDw8zMzAAAAAAAAAAAAAAAAAAAAAAAAAAAACwAAAAAyACWAAAE/hDISau9OOvNu/9gKI5kaZ5oqq5s675wLM90bd94ru987//AoHBILBqPyKRyyWw6n9CodEqtWq/YrHbL7Xq/4LB4TC6bz+i0es1uu9/wuHxOr9vv+Lx+z+/7/4CBgoOEhYaHiImKi4yNjo+QkZKTlJWWl5iZmpucnZ6foKGio6SlpqeoqaqrrK2ur7CxsrO0tba3TAMFBQO4LAUBAQW+K8DCxCoGu73IzSUCwQECAwQBBAIVCMAFCBrRxwDQwQLKvOHV1xbUwQfYEwIHwO3BBBTawu2BA9HGwcMT1b7Vw/Dt3z563xAIrHCQnzsAAf0F6ybhwDdwgAx8OxDQgASN/sKUBWNmwQDIfwBAThRoMYDHCRYJGAhI8eRMf+4OFrgZgCKgaB4PHqg4EoBQbxgBROtlrJu4ofYm0JMQkJk/mOMkTA10Vas1CcakJrXQ1eu/sF4HWhB3NphYlNsmxOWKsWtZtASTdsVb1mhEu3UDX3RLFyVguITzolQKji/GhgXNvhU7OICgsoflJr7Qd2/isgEPGGAruTTjnSZTXw7c1rJpznobf2Y9GYBjxIsJYQbXstfRDJ1luz6t2TDvosSJSpMw4GXG3TtT+hPpEoPJ6R89B7AaUrnolgWwnUQQEKVOAy199mlonPDfr3m/GeUHFjBhAf0SUh28+P12QOIIgDbcPdwgJV+Arf0jnwTwsHOQT/Hs1BcABObjDAcTXhiCOGppKAJI6nnIwQGiKZSViB2YqB+KHtxjjXMsxijjjDTWaOONOOao44489ujjj0AGKeSQRBZp5JFIJqnkkkw26eSTUEYp5ZRUVmnllVhmqeWWXHbp5ZdghinmmGSW6UsEADs=");
	$("#img-"+ id ).find(".removepic").hide();
}
function open_win(id)
{	
	win = window.open("/dz-admin?amod=user&atask=group&task=popup&id="+id+"&ajax=true", "sendtofriend", "location=1,status=1,scrollbars=1,width=950,height=600");
	
}

	</script>{/literal}
<!-- END JAVASCRIPTS -->
