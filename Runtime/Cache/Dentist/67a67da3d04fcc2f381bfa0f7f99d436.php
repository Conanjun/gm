<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo($error); ?>
</title>
<link rel="stylesheet" href="Admin/theme/default/zh-cn.default.css"
	type="text/css" media="screen">
<style>#featurebar ul.nav li .chosen-container a.chosen-single{background:#F8FAFE; border:none; -webkit-box-shadow:none;box-shadow:none; padding-top:5px;}
#featurebar ul.nav li .chosen-container .chosen-drop {min-width: 200px;!important}
#dept_chosen.chosen-container .chosen-drop {min-width: 400px;!important}
body{background: #f1f1f1;}
.container{padding: 0}
.modal-dialog{width: 500px!important; margin-top: 10%;}
.modal-footer{text-align: center;margin-top: 0;}

.table,.alert{margin: 0;}
.table+.alert{margin-top: 20px;}
.table.table-form>thead>tr>th, .table.table-form>tbody>tr>th, .table.table-form>tfoot>tr>th{color: #666}
.table>thead>tr>th{background-color: transparent;}
.table.table-form>thead>tr>th, .table.table-form>tbody>tr>th, .table.table-form>tfoot>tr>th, .table.table-form>thead>tr>td, .table.table-form>tbody>tr>td, .table.table-form>tfoot>tr>td{vertical-align: middle;}

@media (max-width: 700px){.modal-dialog{padding: 0;} .modal-content{box-shadow: none;border-width: 1px 0;border-radius: 0}}

.alert {display: table;}
.btn {transition:none;}

.body-modal .modal-dialog {margin: 50px auto; border: none; box-shadow: none;}
</style>
</head>
<body>
	<div class="modal-dialog">
    <div class="modal-header"><strong>提醒
        <i class="icon-info-sign"></i></strong></div>
    <div class="modal-body">
      <div class="alert with-icon alert-pure">
        <i class="icon-frown"></i>
        
        <div class="content">
        <?php echo($error); ?>
     	</div>
      </div>
    </div>
    <div class="modal-footer">
             <a href="<?php echo($jumpUrl); ?>" class="btn  btn-primary" style="float: right;">重新登陆</a>
             <a href="<?php echo($indexUrl); ?>" class="btn  btn-default" style="float:right";">返回首页</a>
</div>
  </div>
	
	<script type="text/javascript">
		(function() {
			var wait = document.getElementById('wait'), href = document
					.getElementById('href').href;
			var interval = setInterval(function() {
				var time = --wait.innerHTML;
				if (time <= 0) {
					//location.href = href;
					clearInterval(interval);
				}
				;
			}, 1000);
			window.stop = function() {
				console.log(111);
				clearInterval(interval);
			}
		})();
	</script>
</body>
</html>