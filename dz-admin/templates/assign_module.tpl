<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="{$smarty.const.SITE_URL}dz-admin/" />
<title>Thiết lập quyền cho: {$usertype.name}</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
{include file='admin_style.tpl'}
	<script src="includes/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="includes/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="includes/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
	<!--[if lt IE 9]>
	<script src="includes/plugins/excanvas.min.js"></script>
	<script src="includes/plugins/respond.min.js"></script>  
	<![endif]-->   
	<script src="includes/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="includes/plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="includes/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<script src="includes/scripts/app.js" type="text/javascript"></script>
	<script>
		jQuery(document).ready(function() {    
		   App.init(); // initlayout and core plugins
		  $("select, input").uniform();
		});
</script>
{literal}
<script  type="text/javascript">
	function select_module(moduleID){
		
		//$('#roll200_').prop('checked',true);
		
		var selected = $('#module_'+ moduleID).prop("checked");
		
		var i = 0;
		var obj = document.getElementById('roll' + moduleID + '_' + i.toString());		
		//console.log(moduleID);
	while(obj){
			if(!obj.disabled)
				obj.checked = selected;
			i ++;
			obj = document.getElementById('roll' + moduleID + '_' + i.toString());
		}
		$.uniform.update();
		
	}
	
	function select_roll(moduleID,objroll){
		
		if(objroll != null && objroll.checked){
			document.getElementById('module_' + moduleID).checked = true;
		}else if(!objroll.checked){
			var i = 0;
			var obj = document.getElementById('roll' + moduleID + '_' + i.toString());		
			var flag = false;
			while(obj){
				if(obj.checked){
					flag = true;
					break;
				}
				i ++;
				obj = document.getElementById('roll' + moduleID + '_' + i.toString());
			}
			if(!flag) document.getElementById('module_' + moduleID).checked = false;
		}
		$.uniform.update();
	}
</script>
{/literal}</head>
<body>

<form action="" name="" method="post" >
<input type="hidden" value="{$usertype.id}" name="id" />
<div class="row-fluid">
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
                        {if $usertype}
						<div class="portlet box light-grey">
                        
							<div class="portlet-title">
								<div class="caption"><i class="icon-globe"></i><em>Thiết lập quyền cho: {$usertype.name}</em></div>
                                <div class="actions">
    <button type="button" class="btn blue" name="" onClick="window.close();">Đóng lại <i class="icon-remove-circle"></i></button>
								<div class="btn-group"></div>	
								</div>
                                
                                </div>
							
							<div class="portlet-body">
                             <div class="scroller" style="height:430px" data-always-visible="1" data-rail-visible="0">
								{if $usertype.id==1}
                                <div class="alert">
									<button class="close" data-dismiss="alert"></button>
									Bạn không thể cài đặt quyền cho nhóm quản trị cao nhất, bởi nhóm này luôn có đủ tất cả các quyền.
								</div>
                                {else}
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th></th>
    {section loop=$basicroll name=foo}{assign var=item value=$basicroll[foo]}
    <th  style="width:130px; font-size:12px; font-weight:normal;font-style:italic; text-align:center"><i class="{$item.icon}"></i> {$item.title}</th>
    {/section}
    <th>Full</th>
										</tr>
									</thead>
									<tbody>
										
	{assign var="counter" value=0}
{foreach from = $modules item = module name=modul }
	<tr><td class="span4">
		{if $module.level == 0}
		{assign var="counter" value=$counter+1}
			<em>{$module.title}</em>
		{else}
			 &nbsp;&nbsp;&nbsp;<em>{$module.title}</em>
		{/if}
        
        </td>  
        {section loop=$module.roll name=foo}{assign var=rollseg value=$module.roll[foo]}  
       <td align="center" style="text-align:center">
      {if $rollseg.checked=='checked'}
				<input name="roll{$module.id}[]" id="roll{$module.id}_{$smarty.section.foo.index}"
                 onClick="select_roll('{$module.id}',this);" type="checkbox" value="{$rollseg.id}" 
                checked="{$rollseg.checked}"/>
      {elseif $rollseg.checked=='none'}
				<input name="roll{$module.id}[]" id="roll{$module.id}_{$smarty.section.foo.index}"
                 onClick="select_roll('{$module.id}',this);" type="checkbox" value="{$rollseg.id}" 
                />
       {elseif $rollseg.checked=='disable'}
       		<input type="checkbox"  id="roll{$module.id}_{$smarty.section.foo.index}" disabled="disabled" />
        {/if}
			 </td>	 
		{/section}
		
<td align="center">
      {if $module.checked=='checked'}
		<input name="module[]" id="module_{$module.id}"
         onClick="select_module('{$module.id}');" type="checkbox" 
         value="{$module.id}" checked="checked"/>
      {elseif $module.checked=='none'}
		<input name="module[]" id="module_{$module.id}"
         onClick="select_module('{$module.id}');" type="checkbox" 
         value="{$module.id}"/>
       {elseif $module.checked=='disable'}
         	<input type="checkbox" disabled="disabled" />
         {/if}	
		</td>
        
        </tr>
{/foreach}
									
									</tbody>
								</table>
                                </div>
                                <div class="table-toolbar">
									<div class="btn-group">
<button type="submit" name="" class="btn green">Lưu lại <i class="icon-save"></i></button>
									</div>
                                    
								</div>{/if}
							</div>
						</div>{else}
                                <div class="alert">
									<button class="close" data-dismiss="alert"></button>
									Không tồn tại nhóm thành viên này!
								</div>
                        {/if}
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
				
				<!-- END PAGE CONTENT-->
			</div>
