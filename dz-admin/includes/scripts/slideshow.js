var Slideshow =  {

	addmore: function(obj) {
		var _count = $("#"+obj+ " .scroller").find(".gitem").length;
		var str='';
str+='		<div class="gitem pull-left"><div class="portlet box grey" id="img-gallery-'+(_count+1)+'">';
str+='			 <div class="portlet-title">';
str+='			 <div class="caption">';
str+='			 <i class="icon-reorder"></i>Ảnh '+(_count+1)+'</div>';
str+='     <div class="actions">';
str+='<button type="button" class="btn mini red" onclick="BrowseServer( \'Images:/\', \'gallery-'+(_count+1)+'\' );">';	
str+='Chọn <i class="icon-plus"></i></button>';		
str+=' <a href="javascript:" style="display:none" onclick="return removeThumb(\'gallery-'+(_count+1)+'\')" class="btn mini red removepic" data-dismiss="fileupload">Xóa <i class="icon-remove"></i></a>';
str+=' <button type="button" class="btn mini blue" onclick="return Slideshow.removebox(\'gallery-'+(_count+1)+'\')" data-dismiss="fileupload"><i class="icon-trash"></i></button>';
str+='     </div>';
str+='			 </div>';
str+='			 <div class="portlet-body">';
str+='<div class="fileupload fileupload-new" style="text-align:center" id="inner-gallery-'+(_count+1)+'" data-provides="fileupload">';
str+='<div class="fileupload-new thumbnail" style="height:150px">';
str+='<img style="width:200px" src="data:image/gif;base64,R0lGODdhyACWAOMAAO/v76qqqubm5t3d3bu7u7KystXV1cPDw8zMzAAAAAAAAAAAAAAAAAAAAAAAAAAAACwAAAAAyACWAAAE/hDISau9OOvNu/9gKI5kaZ5oqq5s675wLM90bd94ru987//AoHBILBqPyKRyyWw6n9CodEqtWq/YrHbL7Xq/4LB4TC6bz+i0es1uu9/wuHxOr9vv+Lx+z+/7/4CBgoOEhYaHiImKi4yNjo+QkZKTlJWWl5iZmpucnZ6foKGio6SlpqeoqaqrrK2ur7CxsrO0tba3TAMFBQO4LAUBAQW+K8DCxCoGu73IzSUCwQECAwQBBAIVCMAFCBrRxwDQwQLKvOHV1xbUwQfYEwIHwO3BBBTawu2BA9HGwcMT1b7Vw/Dt3z563xAIrHCQnzsAAf0F6ybhwDdwgAx8OxDQgASN/sKUBWNmwQDIfwBAThRoMYDHCRYJGAhI8eRMf+4OFrgZgCKgaB4PHqg4EoBQbxgBROtlrJu4ofYm0JMQkJk/mOMkTA10Vas1CcakJrXQ1eu/sF4HWhB3NphYlNsmxOWKsWtZtASTdsVb1mhEu3UDX3RLFyVguITzolQKji/GhgXNvhU7OICgsoflJr7Qd2/isgEPGGAruTTjnSZTXw7c1rJpznobf2Y9GYBjxIsJYQbXstfRDJ1luz6t2TDvosSJSpMw4GXG3TtT+hPpEoPJ6R89B7AaUrnolgWwnUQQEKVOAy199mlonPDfr3m/GeUHFjBhAf0SUh28+P12QOIIgDbcPdwgJV+Arf0jnwTwsHOQT/Hs1BcABObjDAcTXhiCOGppKAJI6nnIwQGiKZSViB2YqB+KHtxjjXMsxijjjDTWaOONOOao44489ujjj0AGKeSQRBZp5JFIJqnkkkw26eSTUEYp5ZRUVmnllVhmqeWWXHbp5ZdghinmmGSW6UsEADs=" alt="">';
str+='</div>';
str+='<div class="clearfix"></div>';
str+='</div>';
str+='	<input type="hidden" class="span6 m-wrap medium" name="gallery[]" id="gallery-'+(_count+1)+'">';
str+='	</div>	</div></div>';
	$("#"+obj+" .scroller").append(str);
		
	},

	removebox: function(obj){
		$("#img-"+obj).parent().remove();
	}

    }

