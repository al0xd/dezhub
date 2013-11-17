 
 <div id="col-mid">
<div class="NavContent">Đang duyệt:<span class="NavLink">
<a href="/">Trang chủ</a></span><span class="NavLink">Liên hệ</span></div>
<div class="box-head">Liên hệ</div>
<div class="box-body">
{literal}
<style type="text/css">
.form-control{ width:250px;border:1px solid #999; padding:2px;}
.col-lg-4{ width:200px; }
.has-warning .form-control{ border:1px solid red;}
</style>
{/literal}
<form class="form-horizontal" method="post" role="form">
            <div class="row">
            {if $msg}<div class="alert alert-warning" style="padding:10px; color:red">
            	{$msg}
            </div>{/if}
           <table class="col-md-12" style="width:650px" cellpadding="5" cellspacing="5">
           	<tr><td class="col-lg-4">Họ tên *</td>
            <td class="{$error.hoten}">
            	<input type="text" class="form-control" value="{$smarty.request.hoten}" name="hoten">
            </td></tr>
            
           	<tr><td class="col-lg-4">Email *</td>
            <td class="{$error.email}">
            	<input type="text" class="form-control" value="{$smarty.request.email}" name="email">
            </td></tr>
           	<tr><td class="col-lg-4">Điện thoại *</td>
            <td class="{$error.dienthoai}">
            	<input type="text" class="form-control" value="{$smarty.request.dienthoai}" name="dienthoai">
            </td></tr>
           <tr>
           		<td class="col-lg-4">Yêu cầu </td>
                <td>
                    <textarea style="height:100px;" class="form-control" name="yeucau">{$smarty.request.yeucau}</textarea>
                </td>
            </tr>
           <tr>
           		<td class="col-lg-4">Mã bảo mật *</td>
                <td>
                <div class="form-group">
                    <label for="inputEmail1" class="col-lg-3 control-label">{$captcha.a} + {$captcha.b} = ?</label>
                <div class="col-lg-5 {$error.captcha}">
                    <input type="text" class="form-control" name="captcha" id="keycode" placeholder="">
                </div>
                </div>
                </td>
            </tr>
            
         <tr>
         	<td></td>
            <td>
            	<button type="submit" class="contact-button">Gửi</button>
            	<button type="reset" class="contact-button">Reset</button>
            </td>
         </tr>
           </table> 
   			<div class="text-left well">* Required</div>
          </div>
  </form><div class="clear last"></div>
</div>
            
            
        </div>
        
    