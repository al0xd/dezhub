<div id="col-mid">
            
            
            
<div class="NavContent">Đang duyệt:<span class="NavLink"><a href="/">Trang chủ</a></span>
<span class="NavLink">{$category.name}</span></div>
<div id="load">
<div class="box-head">
<h1>{$category.name}</h1></div>
<div class="box-body clearfix">
 {section loop=$list_post name=foo}
 <div id="P{$list_post[foo].post_id}" class="pro-view tooltip">
<div class="div_img">
<a title="" href="product/{$category.keycode}/{$list_post[foo].post_code}">
<img src="{$list_post[foo].post_photo}" alt="{$list_post[foo].post_title}"></a>
</div><h3>
<a title="{$list_post[foo].post_title}" href="product/{$item.keycode}/{$list_post[foo].post_code}">
{$list_post[foo].post_title}</a></h3>
</div>
 <div id="data_P{$list_post[foo].post_id}" style="display: none;">
  <div class="protip-title">{$list_post[foo].post_title}  - <span>{$list_post[foo].post_price|number_format} đ</span></div> 
  <div class="protip-content last">
  <div class="protip-summary last">
  {$list_post[foo].post_description}
</div></div></div>

        {/section}
        </div>
</div>
            
   {$sPaging}         
        </div>