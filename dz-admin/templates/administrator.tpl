{include file="admin_header.tpl"}
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        
			{include file="admin_menu.tpl"}
		</div>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content" id="pjax">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
            <div class="container-fluid"><div class="row-fluid">
            	<div class="span12">
            {loadModule name=admin task=channel}</div>
            <!-- END PAGE CONTAINER-->    
            </div></div></div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
    {include file="admin_footer.tpl"}
