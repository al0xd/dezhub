<script src="includes/plugins/jquery-nestable/jquery.nestable.js"></script>  
<!-- END PAGE LEVEL SCRIPTS -->     
<script src="includes/scripts/ui-nestable.js"></script>
  <link rel="stylesheet" type="text/css" href="includes/plugins/jquery-nestable/jquery.nestable.css" />
 {if $msg} <div class="row-fluid">
<div class="span12">
 <div class="alert pulsate-regular" style="text-align:center;">
<button class="close" data-dismiss="alert"></button>
{$msg}
</div></div></div>{/if}


 <div class="row-fluid">

 <div  class="span6">
    <div class="portlet box grey">
        <div class="portlet-title">
            <div class="caption"><i class="icon-reorder"></i>Chỉnh sửa menu</div>
        </div>
        <div class="portlet-body form">
           

          <form class="form-horizontal" method="get">
          <input type="hidden" name="amod" value="system" />
          <input type="hidden" name="atask" value="nav" />
            
               <div class="row-fluid">
               	<div class="span2">
               <label class="control-label" style="text-align:left;"> Chọn menu</label></div>
                
                <div class="span4">
                <select name="menu" id="select2_sample1" class="span12 select2">
                {html_options options=$listmenu selected=$smarty.request.menu|default:$menu.id}
                </select>
                </div>
                <div class="span6">
                <button type="submit" class="btn">Chọn</button>
                 hoặc <a href="javascript:" id="btn-new-menu">tạo menu mới</a>
                 </div>
            </div>
          </form>
        </div>
    </div>
    
 <div class="portlet box grey frmnav" id="frm-new-menu" style="display:none;">
        <div class="portlet-title">
            <div class="caption"><i class="icon-reorder"></i>Thêm menu mới</div>
        </div>
        <div class="portlet-body form">
          <form class="form-horizontal" method="post"  onsubmit="return new_menu(this)">
            <input type="hidden" name="amod" value="system" />
            <input type="hidden" name="atask" value="nav" />
            <input type="hidden" name="task" value="new" />
               <div class="row-fluid">
               	<div class="span2">
               <label class="control-label" style="text-align:left;"> Tên menu</label></div>
                <div class="span4 control-group">
                	<input type="text" name="nav_menu" class="span12 m-wrap " />
                 </div>
                {if $language}
                <div class="span3 control-group">
                	<select name="lang_id" class="chosen span11">
                     {html_options options=$language}
                    </select>
                 </div>{/if}
                 <div class="span3">
                <button type="submit"  name="btn_new_menu" class="btn">Thêm mới</button>
                 </div>
            </div>
          </form>
        </div>
    </div>   
    <div class="row-fluid">
    <div class="span6" style="position:relative;">
    {if !$menu.id}
	<div style="position:absolute; width:100%; height:100%; z-index:30; background:#fff; opacity:0.7"></div>
{/if}

  <div class="accordion scrollable" id="accordion2">
  {section loop=$category name=foo}  {if $category[foo].items}
    <div class="accordion-group" id="category-box-{$smarty.section.foo.index+1}">
        <div class="accordion-heading">
            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_{$smarty.section.foo.index+1}">
            <i class="icon-angle-left"></i> {$category[foo].title}
            </a>
        </div>
        <div id="collapse_2_{$smarty.section.foo.index+1}" class="accordion-body collapse {if $smarty.section.foo.first}in{/if}">
            <div class="accordion-inner">
   	<form style="margin:0;" method="post" id="frm_cate_{$category[foo].type}" onsubmit="return insert_cate_to_nav(this)">
    <input type="hidden" name="cate_type" value="{$category[foo].type}" />
              <div class="scroller" style="height:200px">
               
        {assign var="cate_item" value=$category[foo].items}
          {section loop=$cate_item name=sfoo}
          <label>{$cate_item[sfoo].name}</label>
          {/section}
          </div>
     <button  type="submit" class="btn mini  pull-right blue">Thêm vào menu</button>  
    <a href="javascript:" class="btn mini pull-right" onclick="return select_all_category_nav({$smarty.section.foo.index+1},this)">Chọn hết</a>
       <div class="clearfix"></div>
</form>
            </div>
        </div>
    </div>{/if}
   {/section} 
   <div class="accordion-group" id="category-box-page">
        <div class="accordion-heading">
            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_page">
            <i class="icon-angle-left"></i> Trang
            </a>
        </div>
        <div id="collapse_2_page" class="accordion-body collapse">
            <div class="accordion-inner">
   	<form style="margin:0;" method="post" id="frm_cate_page" onsubmit="return insert_cate_to_nav(this)">
    <input type="hidden" name="cate_type" value="page" />
              <div class="scroller" style="height:200px">
               
          {section loop=$page name=foo}
          <label>
          <input type="checkbox" data-type='page' data-type-name='page' data-name='{$page[foo].post_title}' name='cate_nav[]' value="{$page[foo].post_id}" />
          {$page[foo].post_title}</label>
          {/section}
          </div>
     <button  type="submit" class="btn mini  pull-right blue">Thêm vào menu</button>  
    <a href="javascript:" class="btn mini pull-right" onclick="return select_all_category_nav({$smarty.section.foo.index+1},this)">Chọn hết</a>
       <div class="clearfix"></div>
</form>
            </div>
        </div>
    </div>
   </div>
	</div>
    <div class="span6" style="position:relative;">
    {if !$menu.id}
	<div style="position:absolute; width:100%; z-index:3; height:100%; background:#fff; opacity:0.7"></div>
{/if}
    <div class="portlet box grey">

        <div class="portlet-title">
            <div class="caption"><i class="icon-reorder"></i>Custom links</div>
        </div>
        <div class="portlet-body form">
          <form class="form-horizontal" method="post" onsubmit="return insert_link_menu(this)">
               <div class="row-fluid control-group">
               	<div class="span4">
               <label class="control-label" style="text-align:left;">Url</label></div>
                <div class="span8">
                	<input type="text" value="http://" name="link_url" class="small m-wrap " />
                 </div>
                </div>
                
                <div class="row-fluid control-group">
               	<div class="span4">
               <label class="control-label" style="text-align:left;">Label text</label></div>
                <div class="span8">
                	<input type="text" name="link_name" class="small m-wrap " />
                 </div>
                 </div>
            <div class="row-fluid control-group">
            <div class="span4"></div>
                 <div class="span8">
                <button type="submit" class="btn blue">Thêm vào menu</button>
                </div>
            </div>
          </form>
        </div>
    </div>	
    </div>
     
    </div>
</div>
<div class="span6" style="position:relative;">
{if !$menu.id}
	<div style="position:absolute; width:100%; z-index:3; height:100%; background:#fff; opacity:0.7"></div>
{/if}
 <form method="post" onsubmit="return save_menu()">
<div class="portlet box grey frmnav" >
    <div class="portlet-title">
    <div class="caption"><i class="icon-reorder"></i>Quản lý menu: {$menu.name}</div>
 <div id="nestable_list_menu" class="actions">
        <button type="button" class="btn blue" title="Hiện hết" data-action="expand-all">-</button>
        <button type="button" title="Thu lại" class="btn blue" data-action="collapse-all">+</button>
        <button type="submit" class="btn green" name="btn_save_menu">Lưu menu  <i class="icon-save"></i></button>
    </div>
    </div>
    <div class="portlet-body">
		<p>Kéo và thả từng menu vào thứ tự mà bạn thích. Bấm vào nút sửa bên phải để sửa lại menu của bạn</p>
         <input type="hidden" name="amod" value="system" />
         <input type="hidden" name="atask" value="nav" />
         <input type="hidden" name="task" value="save_menu" />
         <input type="hidden" name="menu" value="{$menu.id}" />
         <input type="hidden" name="lang_id" value="{$menu.lang_id}" />
<div class="dd" id="nestable_list_3" style="margin:20px 0;">
         
            <ol class="dd-list">
             {foreach $menu.items as $keyvar=>$i}
                <li class="dd-item dd3-item" data-type="{$i.post_content}" data-pid="{$i.pid}" data-id="{$i.post_id}">
                    <div class="dd-handle dd3-handle">Drag</div>
                    <div class="dd3-content">
                    	<span>{$i.post_name}</span> ({$i.type_name})
                    <i onclick="javascript:collapse_nav_item(this)" class="icon-collapse pull-right"></i>
                    <div class="menu-content" style="display:none;">
                    	{if $i.post_content=='nav_link'}<div class="span11">
                        	<label>Url</label>
                            <input type="text" name="url_menu_item_{$i.post_id}" value="{$i.post_gid}" class="m-wrap span12" />
                        </div>{/if}
                    <div class="row-fluid">
                    	<div class="span5">
                        	<label>Tên danh mục</label>
                            <input name="name_menu_item_{$i.post_id}"  value="{$i.post_title}" class="m-wrap span12"type="text" />
                        </div>
                    	<div class="span5">
                        	<label>Tiêu đề thuộc tính</label>
                            <input  name="option_menu_item_{$i.post_id}"  value="{$i.post_description}" class="m-wrap span12" type="text" />
                        </div></div>
                      <a href="javascript:" onclick="return remove_nav_item(this)">Xóa Menu</a> | 
                      <a href="javascript:" onclick="return collapse_nav_item($(this).parent().parent().children('i'))">Hủy bỏ</a>
                    </div> </div>
{if $i.sub}
<ol class="dd-list">
{foreach $i.sub as $si}
<li class="dd-item dd3-item" data-type="{$si.post_content}" data-pid="{$si.pid}" data-id="{$si.post_id}">
<div class="dd-handle dd3-handle">Drag</div>
<div class="dd3-content">
<span>{$si.post_name}</span> ({$si.type_name})
<i onclick="javascript:collapse_nav_item(this)" class="icon-collapse pull-right"></i>
<div class="menu-content" style="display:none;">
{if $si.post_content=='nav_link'}<div class="span11">
<label>Url</label>
<input type="text" name="url_menu_item_{$si.post_id}" value="{$si.post_gid}" class="m-wrap span12" />
</div>{/if}

<div class="row-fluid">
<div class="span5">
<label>Tên danh mục</label>
<input name="name_menu_item_{$si.post_id}"  value="{$si.post_title}" class="m-wrap span12"type="text" />
</div>
<div class="span5">
<label>Tiêu đề thuộc tính</label>
<input  name="option_menu_item_{$si.post_id}"  value="{$si.post_description}" class="m-wrap span12" type="text" />
</div></div>
<a href="javascript:" onclick="return remove_nav_item(this)">Xóa Menu</a> | 
<a href="javascript:" onclick="return collapse_nav_item($(this).parent().parent().children('i'))">Hủy bỏ</a>
</div> </div>
{if $si.sub}
<ol class="dd-list">
{foreach $si.sub as $ssi}
<li class="dd-item dd3-item" data-type="{$ssi.post_content}" data-pid="{$ssi.pid}" data-id="{$ssi.post_id}">
<div class="dd-handle dd3-handle">Drag</div>
<div class="dd3-content">
<span>{$ssi.post_name}</span> ({$ssi.type_name})
<i onclick="javascript:collapse_nav_item(this)" class="icon-collapse pull-right"></i>
<div class="menu-content" style="display:none;">
{if $ssi.post_content=='nav_link'}<div class="span11">
<label>Url</label>
<input type="text" name="url_menu_item_{$ssi.post_id}" value="{$ssi.post_gid}" class="m-wrap span12" />
</div>{/if}

<div class="row-fluid">
<div class="span5">
<label>Tên danh mục</label>
<input name="name_menu_item_{$ssi.post_id}"  value="{$ssi.post_title}" class="m-wrap span12"type="text" />
</div>
<div class="span5">
<label>Tiêu đề thuộc tính</label>
<input  name="option_menu_item_{$ssi.post_id}"  value="{$ssi.post_description}" class="m-wrap span12" type="text" />
</div></div>
<a href="javascript:" onclick="return remove_nav_item(this)">Xóa Menu</a> | 
<a href="javascript:" onclick="return collapse_nav_item($(this).parent().parent().children('i'))">Hủy bỏ</a>
</div> </div>
{if $ssi.sub}
<ol class="dd-list">
{foreach $ssi.sub as $sssi}
<li class="dd-item dd3-item" data-type="{$sssi.post_content}"  data-pid="{$sssi.pid}" data-id="{$sssi.post_id}">
<div class="dd-handle dd3-handle">Drag</div>
<div class="dd3-content">
<span>{$sssi.post_name}</span> ({$sssi.type_name})
<i onclick="javascript:collapse_nav_item(this)" class="icon-collapse pull-right"></i>
<div class="menu-content" style="display:none;">
{if $sssi.post_content=='nav_link'}<div class="span11">
<label>Url</label>
<input type="text" name="url_menu_item_{$sssi.post_id}" value="{$sssi.post_gid}" class="m-wrap span12" />
</div>{/if}

<div class="row-fluid">
<div class="span5">
<label>Tên danh mục</label>
<input name="name_menu_item_{$sssi.post_id}"  value="{$sssi.post_title}" class="m-wrap span12"type="text" />
</div>
<div class="span5">
<label>Tiêu đề thuộc tính</label>
<input  name="option_menu_item_{$sssi.post_id}"  value="{$sssi.post_description}" class="m-wrap span12" type="text" />
</div></div>
<a href="javascript:" onclick="return remove_nav_item(this)">Xóa Menu</a> | 
<a href="javascript:" onclick="return collapse_nav_item($(this).parent().parent().children('i'))">Hủy bỏ</a>
</div> </div>
{if $sssi.sub}
<ol class="dd-list">
{foreach $sssi.sub as $ssssi}
<li class="dd-item dd3-item" data-type="{$ssssi.post_content}" data-pid="{$ssssi.pid}" data-id="{$ssssi.post_id}">
<div class="dd-handle dd3-handle">Drag</div>
<div class="dd3-content">
<span>{$ssssi.post_name}</span> ({$ssssi.type_name})
<i onclick="javascript:collapse_nav_item(this)" class="icon-collapse pull-right"></i>
<div class="menu-content" style="display:none;">
{if $ssssi.post_content=='nav_link'}<div class="span11">
<label>Url</label>
<input type="text" name="url_menu_item_{$ssssi.post_id}" value="{$ssssi.post_gid}" class="m-wrap span12" />
</div>{/if}

<div class="row-fluid">
<div class="span5">
<label>Tên danh mục</label>
<input name="name_menu_item_{$ssssi.post_id}"  value="{$ssssi.post_title}" class="m-wrap span12"type="text" />
</div>
<div class="span5">
<label>Tiêu đề thuộc tính</label>
<input  name="option_menu_item_{$ssssi.post_id}"  value="{$ssssi.post_description}" class="m-wrap span12" type="text" />
</div></div>
<a href="javascript:" onclick="return remove_nav_item(this)">Xóa Menu</a> | 
<a href="javascript:" onclick="return collapse_nav_item($(this).parent().parent().children('i'))">Hủy bỏ</a>
</div> </div>
</li>              
{/foreach}
</ol>
{/if}
</li>              
{/foreach}
</ol>
{/if}

</li>              
{/foreach}
</ol>
{/if}
</li>              
{/foreach}
</ol>
{/if}
                    
   
</li>{/foreach}

</ol>
</div>        <div class="clearfix"></div>
    <div class="row-fluid" style="margin-bottom:30px;">
     <h4>Cấu hình</h4>
	<label>
    <input type="checkbox" {if $menu.isprimary==1} checked="checked"{/if} name="is_primary" value="1" /> 
    Chọn làm menu chính</label>
    </p>
    <p>
    	<label>Chọn vị trí hiển thị
    <select name="menu_postion"  class="select2_sample2">
    {html_options options=$type_menu selected=$menu.position_menu}
    </select>
    </label>

    </p>
    <textarea id="nestable_list_3_output" style="display:none" name="menu_item"></textarea>
    </div>
    <div class="clearfix"></div>
    <a onclick="return confirm_remove_menu()" href="?amod=system&atask=nav&task=delete&menu={$menu.id}" class="btn red">Xóa menu <i class="icon-remove"></i></a>
     <button type="submit" class="btn blue pull-right" name="btn_save_menu">Lưu menu <i class="icon-save"></i></button>
    <div class="clearfix"></div>
    </div></div></form>
</div>


 </div>  

<script>
var reload_page=false;
	function confirm_remove_menu(){
		if(!confirm("Bạn chắc chắn muốn xóa menu này?"))
			return false;
	}
	function collapse_nav_item(obj){
		if($(obj).hasClass("icon-collapse-top")){
			$(obj).removeClass("icon-collapse-top");
			$(obj).addClass("icon-collapse");
			$(obj).next(".menu-content").slideUp(200,function(){
				$(obj).parent().css("height","30px");
			
			});
		}else{
			$(obj).removeClass("icon-collapse");
			$(obj).addClass("icon-collapse-top");
			$(obj).next(".menu-content").slideDown(200);
			$(obj).parent().css("height","auto");
		}
		
	}
	function select_all_category_nav(id,obj){
		text = $(obj).text();
		$.each($("#category-box-"+id).find("input[type='checkbox']"),function(index,val){
			//console.log(index);
			if(text=='Chọn hết'){
				$(this).prop('checked',true);
				$(obj).text('Hủy chọn hết');
			}
			else{
				$(this).prop('checked',false);
				$(obj).text('Chọn hết');
			}
			$.uniform.update();
		})
	}
      jQuery(document).ready(function() {       
 	var $newmenufrm = $("#frm-new-menu");
	
	$("#btn-new-menu").click(function(){
		if($("#frm-new-menu").css("display")=='block')
			$newmenufrm.hide();
		else{
			jQuery($newmenufrm).pulsate({
					color: "#bf1c56",
                    repeat: false
				});
			$newmenufrm.show();
		}
	});
        // initiate layout and plugins
         UINestable.init();
      });
	 function insert_cate_to_nav(frm){
		if($(frm).find("input[type='checkbox']:checked").length<1){
			alert('Phải chọn ít nhất 1 danh mục');
			return false;
		}
		else{
		//	$.ajax(url,
		$(frm).find("input[type='checkbox']:checked").each(function(index, element) {
			str ='';
			str += '<li class="dd-item dd3-item" data-type="'+$(element).attr('data-type')+'" data-id="'+$(element).val()+'" data-pid="'+$(element).val()+'">';
			str += '           <div class="dd-handle dd3-handle">Drag</div>';
			str += '           <div class="dd3-content">';
			str += '           	<span>'+$(element).attr('data-name')+'</span> ('+$(element).attr('data-type-name')+')';
			str += '           <i onclick="javascript:collapse_nav_item(this)" class="icon-collapse pull-right"></i>';
			str += '           <div class="menu-content" style="display:none;">';
			str += '          <div class="row-fluid">	<div class="span5">';
			str += '              	<label>Tên danh mục</label>';
			str += '                  <input name="name_menu_item_'+$(element).val()+'" class="m-wrap span12" value="'+$(element).attr('data-name')+'" type="text" />';
			str += '              </div>';
			str += '          	<div class="span5">';
			str += '              	<label>Tiêu đề thuộc tính</label>';
			str += '                  <input name="option_menu_item_'+$(element).val()+'" class="m-wrap span12" type="text" />';
			str += '             </div></div>';
			str += '            <a href="javascript:" onclick="return remove_nav_item(this)">Xóa Menu</a> | ';
			str += '            <a href="javascript:" onclick="return collapse_nav_item($(this).parent().parent().children(\'i\'))">Hủy bỏ</a>';
			str += '          </div></div>';
			str += '      </li>';	
			
			$("#nestable_list_3>ol").append($(str).fadeIn(200));
			$(this).prop('checked',false);
			$.uniform.update();
			reload_page= true;
        });
		 UINestable.init();
		}
		return false;
	}
	function remove_nav_item(obj){
		$(obj).closest("li").fadeOut(200,function(){
			$(this).remove();
			 UINestable.init();
		});
	
	} 
	function save_menu(){
			reload_page= false;
	}
	function new_menu(frm){
		if($(frm).find("input[type='text']").val()==''){
			alert("Bạn phải nhập tên cho menu.");
			$(frm).find("input[type='text']").parent().addClass('error');
			$(frm).find("input[type='text']").focus();
			return false;
		}
	}
	$(window).bind('beforeunload', function(){
		if(reload_page==true)
			return 'Bạn chắc chắn muốn rời khỏi trang này mà chưa lưu?';
	});
	function insert_link_menu(frm){
			if($(frm).find("input[name='link_name']").val()=="" || $(frm).find("input[name='link_url']").val()=='http://'){
				alert('Xin hãy nhập đầy đủ url và label text!');
				if($(frm).find("input[name='link_name']").val()=="")
					$(frm).find("input[name='link_name']").focus();
				if($(frm).find("input[name='link_url']").val()=="http://")
					$(frm).find("input[name='link_url']").focus();
				return false;
			}
			label = $(frm).find("input[name='link_name']").val();
			index = $("#nestable_list_3").find("li[data-type='nav_link']").length+1;
			url = $(frm).find("input[name='link_url']").val();
			str ='';
			str += '<li class="dd-item dd3-item" data-link="'+url+'" data-type="nav_link" data-id="'+index+'">';
			str += '           <div class="dd-handle dd3-handle">Drag</div>';
			str += '           <div class="dd3-content">';
			str += '           	<span>'+label+'</span> (Custom link)';
			str += '           <i onclick="javascript:collapse_nav_item(this)" class="icon-collapse pull-right"></i>';
			str += '           <div class="menu-content" style="display:none;">';
			str += '          <div class="row-fluid">	';
			str += '          <div class="span12"><label>Url</label>';
			str += '			 <input name="url_menu_item_'+index+'" class="m-wrap span12" value="'+url+'" type="text" /></div>';
			str += '			<div class="row-fluid"><div class="span6">';
			str += '              	<label>Tên danh mục</label>';
			str += '                  <input name="name_menu_item_'+index+'" class="m-wrap span12" value="'+label+'" type="text" />';
			str += '              </div>';
			str += '          	<div class="span6">';
			str += '              	<label>Tiêu đề thuộc tính</label>';
			str += '                  <input name="option_menu_item_'+index+'" class="m-wrap span12" type="text" />';
			str += '             </div></div></div>';
			str += '            <a href="javascript:" onclick="return remove_nav_item(this)">Xóa Menu</a> | ';
			str += '            <a href="javascript:" onclick="return collapse_nav_item($(this).parent().parent().children(\'i\'))">Hủy bỏ</a>';
			str += '          </div></div>';
			str += '      </li>';	
			
			$("#nestable_list_3>ol").append($(str).fadeIn(200));
			$.uniform.update();
			reload_page= true;
		 UINestable.init();
		 return false;
	}
   </script>
