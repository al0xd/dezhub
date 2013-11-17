var value_defaul_photo = 0;
function changeLang(langid, url, tab){
	$.get(url+'&lang_id='+langid, function(result){
		document.getElementById(tab).parentNode.innerHTML = result;		
	});
}
function changeGroup(groupid, url, tab){
	$.get(url+'&group_id='+groupid, function(result){	
		document.getElementById(tab).innerHTML = result;
	});
}
function clearDivAttribute(tab)
{
	document.getElementById(tab).innerHTML = '';
}
function addUploadFields()
{	
	varBr = document.createElement("br");	
	img = document.createElement('INPUT');
	img.type = "file";
	img.name = "Product_Photo[]";
	img.style.width = "250";
	document.getElementById('div_photo').appendChild(varBr);
	document.getElementById('div_photo').appendChild(varBr);
	document.getElementById('div_photo').appendChild(img);	
}

 function locdau(str) {  
  str= str.toLowerCase();  
  str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");  
  str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");  
  str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");  
  str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");  
  str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");  
  str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");  
  str= str.replace(/đ/g,"d");  
  str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-"); 
/* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */ 
  str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1- 
  str= str.replace(/^\-+|\-+$/g,"");  
//cắt bỏ ký tự - ở đầu và cuối chuỗi  
  return str;  
  }  

  function hideToolbar(){
	$("#cols-left .icon-chevron-left").hide();
	$("#cols-left .icon-chevron-right").show();
	$("#cols-left").animate({
		"left":'-180px'	
	},200);	
}
  function showToolbar(){
	$("#cols-left .icon-chevron-left").show();
	$("#cols-left .icon-chevron-right").hide();
	$("#cols-left").animate({
		"left":'0'	
	},200);	
}
function kiemtra(arr){
	
}
