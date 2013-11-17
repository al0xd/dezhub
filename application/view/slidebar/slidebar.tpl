

    <div id="content" class="clearfix">
        <div id="col-left">
{section loop=$primary_nav.items name=f}
{assign var=item value=$primary_nav.items[f]}
            
<div class="box-head">
<a href="{$item.src}" target="_self">{$item.post_title}</a>
</div>
{if $item.sub}
<ul id="left-menu" class="menu">
{section loop=$item.sub name=foo}{assign var=sitem value=$item.sub[foo]}
<li class="icon {$sitem.active}"><a href="{$sitem.src}" target="_self">{$sitem.post_title}</a>
{if $sitem.sub}
<ul>
{section loop=$sitem.sub name=sfoo}{assign var=ssitem value=$sitem.sub[sfoo]}
<li><a href="{$ssitem.src}" target="_self">{$ssitem.post_title}</a></li>
{/section}
</ul>{/if}
</li>{/section}
</ul>{/if}

{/section}

<script type="text/javascript"> $('li:last-child').addClass("last");</script>

			
<div class="video"> 
<div class="box-video"><script type="text/javascript">
playfile('{$video}', "210", "152", false, "", "", "");
</script></div></div>
			
<div class="box-head head1">Thống kê truy cập</div>
<div class="box-body center" style="padding-top:5px;">
<!-- Histats.com  START  (standard)-->
{literal}
<script type="text/javascript">document.write(unescape("%3Cscript src=%27http://s10.histats.com/js15.js%27 type=%27text/javascript%27%3E%3C/script%3E"));</script>
<a href="http://www.histats.com" target="_blank" title="site hit counter" ><script  type="text/javascript" >
try {Histats.start(1,2499274,4,402,118,80,"00011111");
Histats.track_hits();} catch(err){};
</script></a>
<noscript><a href="http://www.histats.com" target="_blank"><img  src="http://sstatic1.histats.com/0.gif?2499274&101" alt="site hit counter" border="0"></a></noscript>
<!-- Histats.com  END  -->
{/literal}
</div>

            
            <div class="box-head">Đối tác</div> 
            <div class="box-body center">
            {section loop=$partner name=foo}
            <a href="{$partner[foo].post_gid}" target="_self" title="{$partner[foo].post_title}">
            <img alt="" src="{$partner[foo].post_photo}"  width="218" height="185" />
            </a>{/section}
            </div> 
            
        </div>
