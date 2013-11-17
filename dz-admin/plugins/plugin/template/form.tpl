 {* Emit any javascript from quickform *}
 {if $FormData.javascript}
     {$FormData.javascript}
 {/if}
<form {$FormData.attributes}  class="form-horizontal"> {$FormData.hidden}
<div class="row-fluid">
					<div class="span8">
						<!-- BEGIN SAMPLE FORM PORTLET-->   
						<div class="portlet box grey">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Form</div>
							</div>
							<div class="portlet-body form">
								<!-- BEGIN FORM-->
{if $FormData.required_note and not $FormData.frozen}
<div class="alert">
<button class="close" data-dismiss="alert"></button>
{$FormData.required_note}
</div>

{/if}
									<div class="control-group {if $FormData.errors.post_title}warning{/if}">
										<label class="control-label">{$FormData.post_title.label}
                                        {if $FormData.post_title.required}<span class="required">*</span>{/if}
                                        </label>
										<div class="controls">
											{$FormData.post_title.html}
											{if $FormData.errors.post_title}<span class="help-inline">{$FormData.errors.post_title}</span>{/if}
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">{$FormData.post_photo.label}
                                        {if $FormData.post_photo.required}<span class="required">*</span>{/if}
                                        </label>
										<div class="controls">
											{$FormData.post_photo.html}
											<span class="help-inline"></span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">{$FormData.post_description.label}
                                        {if $FormData.post_description.required}<span class="required">*</span>{/if}
                                        </label>
										<div class="controls">
											{$FormData.post_description.html}
											<span class="help-inline"></span>
										</div>
									</div>
								<!-- END FORM-->  
							</div>
						</div>
						<!-- END SAMPLE FORM PORTLET-->
					</div>
                    <div class="span4">
 						<div class="portlet box grey">
							<div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>Cấu hình</div>
							</div>
							<div class="portlet-body form">
                            <div class="control-group">
										<label class="span3 control-label">{$FormData.post_status.label}
                                        {if $FormData.post_status.required}<span class="required">*</span>{/if}
                                        </label>
										<div class="controls span9">
											{$FormData.post_status.html}
											<span class="help-inline"></span>
										</div>
									</div>
                      <div class="text-center">
                        <button type="submit" class="btn blue"><i class="icon-ok"></i> Lưu lại</button>
                        <button type="reset" class="btn">Reset</button>
                                    </div>
                            </div>
                   	
                    </div>
				</div>		
                </div>						
</form>
   

