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
<div class="proleftdet">
<div class="img-box last"><a href="{$row.post_photo}" title="{$row.post_title} ">
<img alt="{$row.post_title}" id="mainImg" src="{$row.post_photo}"
 data-cloudzoom='zoomImage:"{$row.post_photo}"'></a>
<div class="cloudzoom-caption last">{$row.post_title}</div></div></div>

<div class="prodetailright last" style="width:400px;">
{$row.post_description}
</div>
</div>

<div class="contentpro">
{$row.post_content}

</div>
<script type="text/javascript"> var options = { zoomMatchSize:true, tintColor:"#000", tintOpacity:0.25, zoomPosition:3, captionSource:"", captionPosition:"bottom", maxMagnification:4/*zoomPosition:'inside', zoomOffsetX:0*/}; $('#mainImg').CloudZoom(options);$(".imageslider").bxSlider({ auto: true, prevText: "", nextText: "", pause: 3e3, pager: false, minSlides: 4, maxSlides: 4, slideWidth: 50, infiniteLoop: false, nextSelector: "#gallery-controls", prevSelector: "#gallery-controls" }); $(".imageslider a").hover(function () { var e = $(this).attr("href"); $("#mainImg").attr("src", e); $("#mainImg").parent().attr("href", e); f=$('#mainImg').data('CloudZoom');f.loadImage(e,e); }); $('.img-box a, .imageslider a').lightBox();</script>

<div class="Tag">
Tag: {$aPageinfo.keyword}</div>
 
</div>
<div class="box-head">Sản phẩm cùng loại</div>
 {section loop=$other name=foo}
 <div id="P{$other[foo].post_id}" class="pro-view tooltip">
<div class="div_img">
<a title="" href="product/{$category.keycode}/{$other[foo].post_code}">
<img src="{$other[foo].post_photo}" alt="{$other[foo].post_title}"></a>
</div><h3>
<a title="{$other[foo].post_title}" href="product/{$category.keycode}/{$other[foo].post_code}">
{$other[foo].post_title}</a></h3>
</div>
 <div id="data_P{$other[foo].post_id}" style="display: none;">
  <div class="protip-title">{$other[foo].post_title}  - <span>{$other[foo].post_price|number_format} đ</span></div> 
  <div class="protip-content last">
  <div class="protip-summary last">
  {$other[foo].post_description}
</div></div></div>

        {/section}

</div>



            
            
        </div>