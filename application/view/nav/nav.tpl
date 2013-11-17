<header>
    	<div class="header">
        <a href="/" id="logo"><img src="{$logo}"></a>
        <img  id="slogan" src="/public/images/slogan.png">
        <div class="language">
        	<span>{#language#}</span>
            <a href="index.php?lang=vn"><img src="/public/images/ico-vn.jpg"></a>
            <a href="index.php?lang=en"><img src="/public/images/ico-en.jpg"></a>
        </div>
        
        </div>
        <nav>
        	<ul>
         	<li><a href="index.php" style="padding-left:0;">{#HOME#}</a></li>
           {section loop=$primary_nav.items name=foo}{assign var=item value=$primary_nav.items[foo]}
            	<li><a class="{$item.active}" title="{$item.post_title}" href="{$lang}{$item.src}">{$item.post_title}</a></li>{/section}
            </ul>
        </nav>
        <div class="submenu">
        	{section loop=$primary_nav.items name=foo}{assign var=item value=$primary_nav.items[foo]}
            {if $item.active=='active'}
            <ul>
            {section loop=$item.sub name=f}
            {assign var=i value=$item.sub[f]}
        	<li><a href="{$lang}{$i.src}" class="{$i.active}" title="{$i.post_title}">{$i.post_title}</a></li>{/section}
            </ul>{/if}
            {/section}
        </div>
    </header>
    <div id="slidebg"></div>
    <div class="body">
	<div class="container">
    	<div id="carousel-example-generic" class="carousel slide bs-docs-carousel-example">
        <ol class="carousel-indicators">
         {section loop=$slideshow name=f}
          <li data-target="#carousel-example-generic" data-slide-to="{$smarty.section.f.index}" class="{if $smarty.section.f.first} active{/if}"></li>{/section}
        </ol>
        <div class="carousel-inner">
        {section loop=$slideshow name=f}
          <div class="item{if $smarty.section.f.first} active{/if}">
            <img src="{$slideshow[f].post_photo}" alt="{$slideshow[f].post_title}">
          </div>{/section}
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
          <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
          <span class="icon-next"></span>
        </a>
      </div>
     <div id="service"> <div class="service-top">
      	<div><img src="/public/images/ico-s-1.png"></div>
      	<div><img src="/public/images/ico-s-2.png"></div>
      	<div><img src="/public/images/ico-s-3.png"></div>
      </div>
      </div>
      
    </div>
    </div>
