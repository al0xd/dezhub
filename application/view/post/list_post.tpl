<div id="col-mid">
            
            
            
<div class="NavContent">Đang duyệt:<span class="NavLink"><a href="/">Trang chủ</a></span>
<span class="NavLink">Tin tức sự kiện</span></div><div class="box-head"><h1>Tin tức sự kiện</h1></div>
<div class="box-body clearfix">
{section loop=$list_post name=f}
<div class="cat-news clearfix">
<a href="{$lang}news/{$smarty.get.post_id}/{$list_post[f].post_code}"
 title="{$list_post[f].post_title}">
 <img src="{$list_post[f].post_photo}" alt="" title="" align="left"></a>
 <h3><a href="{$lang}news/{$smarty.get.post_id}/{$list_post[f].post_code}"
  title="{$list_post[f].post_title}">{$list_post[f].post_title}</a>
   </h3><div class="clearfix"><p>{$list_post[f].post_content|pagebreak}</p>
      </div><div class="news-more last">
     <a href="{$lang}news/{$smarty.get.post_id}/{$list_post[f].post_code}">Xem tiếp</a></div></div>
{/section}
</div>
{$sPaging}            
</div>
            
        </div>
        
        
        
        
        