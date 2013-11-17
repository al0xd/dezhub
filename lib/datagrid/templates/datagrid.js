// JavaScript Document	
	
	function check_all(obj_all)
	{
		var i=0;
		var aObj = document.getElementsByTagName('input');
		var obj = document.getElementById("check_"+i);
		while(obj)
		{
			obj.checked =  obj_all.checked;
			i++;
			obj = document.getElementById("check_"+i);
		}
	}
	
	function event_check(task,confrm)
	{
		
		if(validate_check()){
			if(confirm(confrm))
			{
				document.for_datagrid.task.value = task;
				document.for_datagrid.submit();
			}
		}
		else{
			alert("You must select at least one item!");
		}
	}
	
	function validate_check()
	{
		var i=0;		
		var obj = document.getElementById("check_"+i);
		while(obj)
		{
			if(obj.checked == true)
				return true;
			i++;
			obj = document.getElementById("check_"+i);
		}			
		return false;
	}
		
	function confirm_redirect(confirm_text, url){
		if(confirm(confirm_text))
		{
			var re = window.location.href;
			document.cookie = "re_dir="+re;
			window.location.href= url;
		}
	}
	
	function redirect_url(url)
	{
		var re = window.location.href;
		document.cookie = "re_dir="+re;
		window.location.href= url;		
	}
	
	/*function show_img(id, src)
	{
		document.getElementById(id).src = src;
		document.getElementById(id).style.display = "";
	}
	
	function hide_img(id)
	{
		document.getElementById(id).style.display = "none";
	}*/
	
	function sortData(field, type){
		document.for_datagrid.sort_by.value=field; 
		document.for_datagrid.sort_value.value=type; 
		document.for_datagrid.submit();
	}
	
// event when change status for item
	function doPublish( url, obj ){
		var simage = obj.src;
		var status;
		if( obj.alt == 'unpublish'){
			obj.src = simage.replace('active', 'loading');
			status = 0;
		}else{
			obj.src = simage.replace('deactive', 'loading');
			status = 1;
		}
		url = url + '&status='+status;
		console.log(url);
		$.get(url,function(data){	
		
				if( obj.alt == 'unpublish'){					
					obj.src = simage.replace('active', 'deactive');
					obj.alt = 'publish';
				}else{
					obj.src = simage.replace('deactive','active');
					obj.alt = 'unpublish';
				}			
			}
		);
	}
	
// event when click button filter
	function resetFilter(){
		var contain = document.getElementById('filter_area');
		var a = contain.getElementsByTagName('input');
		if( a != 'undefine' )
		for (i = 0; i< a.length; i++){
			if( a[i].type == 'text') a[i].value='';
		}
		
		var b = contain.getElementsByTagName('select');
		if(b != 'undefine')
		for (i = 0; i< b.length; i++){
			b[i].selectedIndex = 0;
		}
		
		document.for_datagrid.submit();
	}
	
	function save_order(sTask){
		document.for_datagrid.task.value = sTask;
		document.for_datagrid.submit();		
	}
