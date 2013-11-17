<ul class="page-sidebar-menu">
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
					&nbsp;
				</li>
				<li class="start {if !$smarty.request.amod}active{/if}">
					<a href="/dz-admin">
					<i class="icon-home"></i> 
					<span class="title">Dashboard</span>
					<span class="selected"></span>
					</a>
				</li>
                  {section loop=$menu_admin name=foo}{assign var=item value=$menu_admin[foo]}
				{if $item.show}<li class="{if $item.selected}active{/if}">
					<a data-pjax  href="{if $item.sub}javascript:;{else}index.php?{php}
                    $link = $template->getTemplateVars('item');
                    echo urldecode($link['link']);
                    {/php}{/if}">
					<i class="{if $item.icon}{$item.icon}{else}icon-file-alt{/if}"></i> 
					<span class="title">{$item.title}</span>
					{if $item.sub}<span class="arrow {if $item.selected}open{/if}"></span>{/if}
                    {if $item.selected}<span class="selected"></span>{/if}
					</a>
					{if $item.sub}<ul class="sub-menu">
						 {section loop=$item.sub name=sfoo}{assign var=sub value=$item.sub[sfoo]}
                         {if $sub.show}<li class="{if $sub.selected}active{/if}">
							<a  data-pjax href="{if $sub.sub}javascript:;{else}?{php}
                            $link = $template->getTemplateVars('sub');
                           echo urldecode( $link['link']);
                            {/php}{/if}">
							<i class="{if $sub.icon}{$sub.icon}{else}icon-file-alt{/if}"></i> 
							{$sub.title}
							 {if $sub.sub}<span class="arrow {if $sub.selected}open{/if}"></span>{/if}
							</a>
							 {if $sub.sub}<ul class="sub-menu">
								{section loop=$sub.sub name=foo_sub}{assign var=sub_sub value=$sub.sub[foo_sub]}
								{if $sub_sub.show}<li class="{if $sub_sub.selected}active{/if}"><a data-pjax href="{if $sub_sub.sub}javascript:{else}?{php}
                                $link = $template->getTemplateVars('sub_sub');
                                echo urldecode($link['link']);
                                
                                {/php}{/if}">
                                <i class="{if $sub_sub.icon}{$sub_sub.icon}{else}icon-file-alt{/if}"></i>
                                {$sub_sub.title}
                                 {if $sub_sub.sub}<span class="arrow {if $sub_sub.selected}open{/if}"></span>{/if}
                                </a>
                                 {if $sub_sub.sub}<ul class="sub-menu">
                                 {section loop=$sub_sub.sub name=foo_sub_sub}{assign var=sub_sub_sub value=$sub_sub.sub[foo_sub_sub]}
								{if $sub_sub_sub.show}<li class="{if $sub_sub_sub.selected}active{/if}"><a data-pjax href="?{php}
                               $link = $template->getTemplateVars('sub_sub_sub');
                                echo urldecode($link['link']);
                                
                                {/php}">
                                <i class="{if $sub_sub_sub.icon}{$sub_sub_sub.icon}{else}icon-file-alt{/if}"></i>
                                {$sub_sub_sub.title}
                                </a></li>{/if}
                                {/section}
                                 </ul>{/if}
                                </li>{/if}
                                {/section}
							</ul>{/if}
						</li>{/if}{/section}
						
					</ul>{/if}
				</li>{/if}{/section}
			
			
				
				
			</ul>
			<!-- END SIDEBAR MENU -->