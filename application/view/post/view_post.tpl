<div id="col-mid">
            
    <script src="public/js/cloudzoom.js" type="text/javascript"></script>       
    <script src="public/js/jquery.lightbox-0.5.min.js" type="text/javascript"></script>        
<div class="NavContent">Đang duyệt:<span class="NavLink"><a href="/">Trang chủ</a></span>
<span class="NavLink"><a href="product/{$category.keycode}">{$category.name}</a></span>
</div>
<div class="box-head">{$row.post_title}</div>
<div class="box-body">

<div class="prodetail clearfix">
<div class="proname"><h1>{$row.post_title}</h1></div>


</div>

<div class="contentpro">
{$row.post_content}

</div>

<div class="Tag">
Tag: {$aPageinfo.keyword}</div>
 
</div>

<div id="ctl03_u_load_control1_ctl00_pnlNewer">
	
<div class="news-related clearfix">
    <h3>Các tin khác</h3>
    <ul>
    	{section loop=$other name=foo}
            <li><a href="news/{$category.keycode}/{$other[foo].post_code}">{$other[foo].post_title}({$other[foo].post_updatetime})</a></li>
        {/section}
    </ul>
</div>

</div>
</div>