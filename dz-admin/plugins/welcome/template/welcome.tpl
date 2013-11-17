            <h3 class="page-title">Hệ thống quản trị <small>Chào mừng bạn đến với hệ thống quản trị dữ liệu.</small></h3>	
				<!-- END PAGE HEADER-->
				<div id="dashboard">
					<!-- BEGIN DASHBOARD STATS -->
					<div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat blue">
								<div class="visual">
									<i class="icon-list"></i>
								</div>
								<div class="details">
									<div class="number">
										{$welcome.countcategory}
									</div>
									<div class="desc">                           
										Danh mục
									</div>
								</div>
								<a class="more" href="?amod=post&atask=group">
								Xem thêm <i class="m-icon-swapright m-icon-white"></i>
								</a>                 
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat green">
								<div class="visual">
									<i class="icon-file-text"></i>
								</div>
								<div class="details">
									<div class="number">{$welcome.countpost}</div>
									<div class="desc">Bài viết</div>
								</div>
								<a class="more" href="?amod=post&atask=post">
								Xem thêm <i class="m-icon-swapright m-icon-white"></i>
								</a>                 
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
							<div class="dashboard-stat purple">
								<div class="visual">
									<i class="icon-tags"></i>
								</div>
								<div class="details">
									<div class="number">{$welcome.counttags}</div>
									<div class="desc">Từ khóa</div>
								</div>
								<a class="more" href="?amod=post&atask=tags">
								Xem thêm <i class="m-icon-swapright m-icon-white"></i>
								</a>                 
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat yellow">
								<div class="visual">
									<i class="icon-user"></i>
								</div>
								<div class="details">
									<div class="number">{$welcome.countuser}</div>
									<div class="desc">Thành viên</div>
								</div>
								<a class="more" href="?amod=user&atask=user">
								Xem thêm <i class="m-icon-swapright m-icon-white"></i>
								</a>                 
							</div>
						</div>
					</div>
					<!-- END DASHBOARD STATS -->
					<div class="clearfix"></div>
	<div class="row-fluid">
					<div class="span6">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
						<div class="portlet box red">
							<div class="portlet-title">
								<div class="caption"><i class="icon-cogs"></i>Bài viết</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="?amod=post&atask=post" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
                            <div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible="0">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Tiêu đề</th>
											<th class="hidden-480">Cập nhật</th>
											<th>Tình trạng</th>
										</tr>
									</thead>
									<tbody>
										{section loop=$welcome.post name=foo}
                                        {assign var="postfoo" value=$welcome.post[foo]}
                                        <tr>
											<td>{$smarty.section.foo.index+1}</td>
											<td>{$postfoo.post_title}</td>
											<td class="hidden-480">{$postfoo.post_updatetime}</td>
											<td>
                                            {if $postfoo.post_status==1}
                                            <span class="label label-success">Kích hoạt</span>{else}
                                            <span class="label label-danger">Chờ xét duyệt</span>
                                            {/if}
                                            </td>
                                        </tr>
                                        {/section}
									</tbody>
								</table>
							</div></div>
						</div>
						<!-- END SAMPLE TABLE PORTLET-->
					</div>
					<div class="span6">
						<!-- BEGIN BORDERED TABLE PORTLET-->
						<div class="portlet box yellow">
							<div class="portlet-title">
								<div class="caption"><i class="icon-coffee"></i>Danh mục</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="?amod=post&atask=group" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
                            <div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible="0">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Tiêu đề</th>
											<th class="hidden-480">Slug</th>
											<th>Tình trạng</th>
										</tr>
									</thead>
									<tbody>
										{section loop=$welcome.category name=foo}
                                        {assign var="catefoo" value=$welcome.category[foo]}
                                        <tr>
											<td>{$smarty.section.foo.index+1}</td>
											<td>{$catefoo.name}</td>
											<td class="hidden-480">{$catefoo.keycode}</td>
											<td>
                                            {if $catefoo.active==1}
                                            <span class="label label-success">Kích hoạt</span>{else}
                                            <span class="label label-danger">Chờ xét duyệt</span>
                                            {/if}
                                            </td>
                                        </tr>
                                        {/section}
									</tbody>
								</table>
							</div>
                            </div>
						</div>
						<!-- END BORDERED TABLE PORTLET-->
					</div>
				</div>				
					<div class="clearfix"></div>
				</div>
