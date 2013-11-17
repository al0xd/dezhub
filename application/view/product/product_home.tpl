{section loop=$home_product name=f}
{assign var=item value=$home_product[f]}
<div class="box-head"><div class="viewAll"></div>
<h2><a href="product/{$item.keycode}" >{$item.name}</a></h2></div>

 <div class="box-body clearfix">
 {if $item.sub}
 {section loop=$item.sub name=foo}
 <div id="P{$item.sub[foo].post_id}" class="pro-view tooltip">
<div class="div_img">
<a title="" href="product/{$item.keycode}/{$item.sub[foo].post_code}">
<img src="{$item.sub[foo].post_photo}" alt="{$item.sub[foo].post_title}"></a>
</div><h3>
<a title="{$item.sub[foo].post_title}" href="product/{$item.keycode}/{$item.sub[foo].post_code}">
{$item.sub[foo].post_title}</a></h3>
</div>
 <div id="data_P{$item.sub[foo].post_id}" style="display: none;">
  <div class="protip-title">{$item.sub[foo].post_title}  - <span>{$item.sub[foo].post_price|number_format} đ</span></div> 
  <div class="protip-content last">
  <div class="protip-summary last">
  {$item.sub[foo].post_description}
</div></div></div>

        {/section}{/if}
        </div>
{/section}
