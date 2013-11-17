<!DOCTYPE html>
<!--[if IE 8]> <html lang="vi" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="vi" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="vi"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>{$aPageinfo.title}</title>
{if $aPageinfo.description}
<meta name="description" content="{$aPageinfo.description}" />
{/if}
{if $aPageinfo.keyword}
<meta name="keywords" content="{$aPageinfo.keyword}" />
{/if}
<link href="{$smarty.const.SITE_URL}favicon.png" rel="icon" type="image/x-icon"/>
<base href="{$smarty.const.SITE_URL}" />
<meta http-equiv="REFRESH" content="1800" />
<meta name="RATING" content="GENERAL" />
<meta name="robots" content="index,follow" />
<meta name="Googlebot" content="index,follow,archive" />
<meta name="revisit-after" content="1 days" />
<meta property="og:title" content="{$aPageinfo.title}" />
{if $aPageinfo.description}
<meta  property="og:description" content="{$aPageinfo.description}" />
<meta name="twitter:description" content="{$aPageinfo.description}">
{/if}
<meta name="twitter:title" content="{$aPageinfo.title}">
<meta property="fb:app_id" content="" />
<meta property="fb:admins" content="" />
<meta property="fb:page_id" content="">
<meta property="og:type" content="article" />
<meta property="og:site_name" content="{$aPageinfo.title}" />
<meta property="og:url" content="{''|selfURL}" />
<meta name="twitter:url" content="{''|selfURL}">
<link rel="canonical" href="{''|selfURL}">
<link rel="apple-touch-icon" href="{$smarty.const.SITE_URL}public/img/icon/favicon.png" />
<meta name="robots" content="all,index,follow" />
<meta name="googlebot" content="index,follow,noodp" />
<meta name="msnbot" content="all,index,follow" />
<meta name="Pragma" content="no-cache" />
<meta name="Expires" content="-1" />
<meta name="Cache-Control" content="no-cache" />
<meta name="distribution" content="Global" />
<meta http-equiv="content-language" content="Vietnamese" />
<meta name="geo.region" content="VN-HN" />
<link rel="search" type="application/opensearchdescription+xml" href="{$smarty.const.SITE_URL}opensearch.xml" title="{$aPageinfo.title}" />
<meta name="google-site-verification" content="" />
<meta name="msvalidate.01" content="" />
<meta name="alexaVerifyID" content="" />
<meta name="twitter:card" content="summary">
{if $aPageinfo.image}<meta property="og:image" content="{$aPageinfo.image}" />
<link rel="image_src" href="{$aPageinfo.image}" />
<meta name="twitter:image" content="{$aPageinfo.image}">
{/if} 
{if $aPageinfo.description}
<meta property="og:description" content="{$aPageinfo.description}" />
{/if}
{if $aPageinfo.prev_product}
<link rel="prev" href="" />{/if}
{if $aPageinfo.next_product}
<link rel="next" href="" />{/if}
<link rel="alternate" type="application/rss+xml" title="{$aPageinfo.rss.title}" href="{$aPageinfo.rss.link}" />
<link rel="shortcut icon" href="/public/img/icon/favicon.png" />
{loadModule name=css}{loadModule name=js}
{if $google_analytics}
<script>{$google_analytics}</script>
{/if}
</head>
<body>
	<div class="full-width bg-wrap">
		<div class="row-fluid mainslider hidden-phone">
			<div class="inner-mainslider">
				<div id="carousel-example-generic" class="carousel slide">
				  <!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
						<li data-target="#carousel-example-generic" data-slide-to="2"></li>
					</ol>
				  <!-- Wrapper for slides -->
				<div class="carousel-inner">			
					<div class="item active">
						<img src="public/images/slider-images/slide1.jpg" alt="...">					
					</div>
					<div class="item">
						<img src="public/images/slider-images/slide2.jpg" alt="...">					
					</div>
					<div class="item">
						<img src="public/images/slider-images/slide3.jpg" alt="...">					
					</div>
					<div class="item">
						<img src="public/images/slider-images/slide4.jpg" alt="...">					
					</div>
					<div class="item">
						<img src="public/images/slider-images/slide5.jpg" alt="...">					
					</div>
				</div>				  
				<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"><span class="icon-prev"></span></a>
				<a class="right carousel-control" href="#carousel-example-generic" data-slide="next"><span class="icon-next"></span></a>
				</div>
			</div><!--mainslider-->
		</div><!--mainslider-->
		<div class="header">
			<div id="header">					
				<div class="row-fluid navbar navbar-inverse">
					<div class="row-fluid">
						<div id="logo" class="span2"><h1><a href="togo.vn">togo.vn</a></h1></div>	     
						<div class="hotline span6"><span class="icon-hotline"> </span><p>+84 988 297 732 / +84 435 626 100</p></div>
						<div class="span4  navbar-inner main-menu">                   	
							<ul class="nav nav-pills bs-docs-tooltip-examples bs-docs-example tooltip-demo">
								<li>
									<a href="#"  title="first tooltip"><i class="flight tooltip" data-toggle="tooltip" data-placement="bottom" title="flights"></i></a>
								</li>									                          
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#">
										<i class="destination tooltip" data-placement="bottom"  data-toggle="tooltip" title="destinations"></i> <span class="caret"></span>
									</a>
									<ul class="dropdown-menu">
										<li><a href="#">Hanoi</a></li>
										<li><a href="#">HoChiMinh City</a></li>                                    
										<li><a href="#">Danang</a></li>
									</ul>
								</li>									
								<li>
									<a class="help"  href="#"><i class="help tooltip" data-toggle="tooltip" data-placement="bottom"  title="helps" ></i></a>
								</li>
								<li>
									<a class="contact" href="#"><i class="contact tooltip" data-toggle="tooltip" data-placement="bottom"  title="contact" ></i></a>
								</li>												
							</ul>  
						</div><!--navbar-inner-->					
					</div><!--span12-->
				</div><!--navbar-->
			</div><!--#header-->

