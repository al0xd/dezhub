<div id="widget-plugins"> {if $msg} <div class="row-fluid">
<div class="span12">
 <div class="alert pulsate-regular" style="text-align:center;">
<button class="close" data-dismiss="alert"></button>
{$msg}
</div></div></div>{/if}
<div class="row-fluid">
    <div class=" portlet box grey" id="box-1">
        <div class="portlet-title">
            <div class="caption"><i class="icon-reorder"></i>Thêm widget</div>
            <div class="tools">
                <a href="javascript:;" class="collapse"></a>
            </div>
        </div>
        <div class="portlet-body">
            <form method="post">
            <div class="row-fluid">
            	<div class="span8">
                <div class="span3">
                <label class="control-label">Hãy chọn một widget</label>
                </div>
                <div class="span5">
                <select class="select2 span12 select2_sample2">
                    <option>Html widget</option>
                    <option>Custom widget</option>
                </select>
                </div>
                <div class="span4">
                	<button type="submit" class="btn purple">Tạo widget</button>
                </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>


<div class="row-fluid">
	<div class="span12" style="margin-bottom:10px;">
    <button type="button" class="btn blue pull-right">Lưu thứ tự widget <i class="icon-save"></i></button>
    <div class="clearfix"></div>
    </div>
</div>
<div class="row-fluid">
	<div class="span12 well text-center portlet yellow">
    	<h2 style="color:white">Header (Đầu trang)</h2>
    </div>
</div>
<div class="row-fluid" id="sortable_portlets">
					<div class="span3 column sortable" id="widget-left">
						<!-- BEGIN Portlet PORTLET-->
                        <div class="span12 well text-center">
                        <h4>Left (Cột trái)</h4>
                        </div>
						<div class=" portlet box grey" id="box-1">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Danh mục sản phẩm</div>
								<div class="actions">
									<div class="btn-group">
										<a class="btn mini green" href="#" data-toggle="dropdown">
										<i class="icon-cog"></i>
										<i class="icon-angle-down"></i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="#"><i class="icon-pencil"></i> Sửa</a></li>
											<li><a href="#"><i class="icon-trash"></i> Xóa</a></li>
											<li><a href="#"><i class="icon-ban-circle"></i> Ẩn hiển thị</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="portlet-body">
								<div>
									Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. 
									Cras mattis consectetur purus sit amet fermentum. Duis mollis.
								</div>
							</div>
						</div>
						<!-- END Portlet PORTLET-->
						<!-- BEGIN Portlet PORTLET-->
						<div class=" portlet box grey" id="box-2">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Hỗ trợ trực tuyến</div>
								<div class="actions">
									<div class="btn-group">
										<a class="btn mini green" href="#" data-toggle="dropdown">
										<i class="icon-cog"></i>
										<i class="icon-angle-down"></i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
											<li><a href="#"><i class="icon-trash"></i> Delete</a></li>
											<li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
											<li class="divider"></li>
											<li><a href="#"><i class="i"></i> Make admin</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="portlet-body">
								<div>
									Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. 
									Cras mattis consectetur purus sit amet fermentum. Duis mollis.
								</div>
							</div>
						</div>
						<!-- END Portlet PORTLET-->
						<!-- BEGIN Portlet PORTLET-->
						<div class=" portlet box green" id="box-3">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Portlet</div>
								<div class="actions">
									<a href="#" class="btn yellow mini"><i class="icon-pencil"></i> Edit</a>
									<a href="#" class="btn green mini"><i class="icon-plus"></i> Add</a>
								</div>
							</div>
							<div class="portlet-body">
								Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. 
								Cras mattis consectetur purus sit amet fermentum. Duis mollis.
							</div>
						</div>
						<!-- END Portlet PORTLET-->
					</div>
					<div class="span6 column sortable" id="widget-center">
						<!-- BEGIN Portlet PORTLET-->
                        <div class="span12 well text-center">
                        <h4>Center box (Cột nội dung chính)</h4>
                        </div>
						<div class=" portlet box red" id="box-4">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Portlet</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
								</div>
								<div class="actions">
									<a href="#" class="btn blue mini"><i class="icon-pencil"></i> Edit</a>
								</div>
							</div>
							<div class="portlet-body">
								Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. 
								Cras mattis consectetur purus sit amet fermentum.Duis mollis.
							</div>
						</div>
						<!-- END Portlet PORTLET-->
						<!-- BEGIN Portlet PORTLET-->
						<div class="portlet box green" id="box-5">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Portlet</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
								</div>
								<div class="actions">
									<a href="#" class="btn blue mini"><i class="icon-pencil"></i> Edit</a>
								</div>
							</div>
							<div class="portlet-body">
								Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. 
								Cras mattis consectetur purus sit amet fermentum.Duis mollis.                       
							</div>
						</div>
						<!-- END Portlet PORTLET-->
						<!-- BEGIN Portlet PORTLET-->
						<div class=" portlet box red" id="box-6">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Portlet</div>
								<div class="actions">
									<a href="#" class="btn yellow mini"><i class="icon-pencil"></i> Edit</a>
									<a href="#" class="btn green mini"><i class="icon-plus"></i> Add</a>
								</div>
							</div>
							<div class="portlet-body">
								Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. 
								Cras mattis consectetur purus sit amet fermentum. Duis mollis.
							</div>
						</div>
						<!-- END Portlet PORTLET-->
					</div>
					<div class="span3 column sortable" id="widget-right" style="margin-bottom:20px;">
						<!-- BEGIN Portlet PORTLET-->
                        <div class="span12 well text-center">
                        <h4>Right box (Cột phải)</h4>
                        </div>
						<div class=" portlet box yellow" id="box-7">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Portlet</div>
								<div class="actions">
									<a href="#" class="btn blue mini"><i class="icon-pencil"></i> Edit</a>
									<div class="btn-group">
										<a class="btn mini green" href="#" data-toggle="dropdown">
										<i class="icon-user"></i> User
										<i class="icon-angle-down"></i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
											<li><a href="#"><i class="icon-trash"></i> Delete</a></li>
											<li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
											<li class="divider"></li>
											<li><a href="#"><i class="i"></i> Make admin</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="portlet-body">
								Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. 
								Cras mattis consectetur purus sit amet fermentum. Duis mollis.
							</div>
						</div>
						<!-- END Portlet PORTLET-->
						<!-- BEGIN Portlet PORTLET-->
						<div class=" portlet box red" id="box-8">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Portlet</div>
								<div class="actions">
									<a href="#" class="btn blue mini"><i class="icon-pencil"></i> Edit</a>
									<div class="btn-group">
										<a class="btn mini green" href="#" data-toggle="dropdown">
										<i class="icon-user"></i> User
										<i class="icon-angle-down"></i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="#"><i class="icon-pencil"></i> Edit</a></li>
											<li><a href="#"><i class="icon-trash"></i> Delete</a></li>
											<li><a href="#"><i class="icon-ban-circle"></i> Ban</a></li>
											<li class="divider"></li>
											<li><a href="#"><i class="i"></i> Make admin</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="portlet-body">
								Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentumDuis mollis, est non commodo luctus.
							</div>
						</div>
						<!-- END Portlet PORTLET-->
						<!-- BEGIN Portlet PORTLET-->
						<div class=" portlet box yellow" id="box-9">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Portlet</div>
								<div class="actions">
									<a href="#" class="btn yellow mini"><i class="icon-pencil"></i> Edit</a>
									<a href="#" class="btn green mini"><i class="icon-plus"></i> Add</a>
								</div>
							</div>
							<div class="portlet-body">
								Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. 
								Cras mattis consectetur purus sit amet fermentum. Duis mollis.
							</div>
						</div>
						<!-- END Portlet PORTLET-->
					</div>
				</div>
<div class="row-fluid">
	<div class="span12 well text-center  portlet yellow">
    	<h2 style="color:white">Footer (Chân website)</h2>
    </div>
</div>

<div class="row-fluid">
	<div class="span12" style="margin-bottom:10px;">
    <button type="button" class="btn blue pull-right">Lưu thứ tự widget <i class="icon-save"></i></button>
    <div class="clearfix"></div>
    </div>
</div>

</div>
{literal}
<style type="text/css">
#widget-plugins h4{ margin:0; padding:0;}
</style>
{/literal}
 <script src="includes/scripts/portlet-draggable.js"></script> 
	<script>
		jQuery(document).ready(function() {       
		   PortletDraggable.init();
		});
	</script>

