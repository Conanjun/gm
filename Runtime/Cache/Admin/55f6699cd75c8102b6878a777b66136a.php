<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Admin/css/in/bootstrap.min.css" rel="stylesheet">
    <link href="/Admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/Admin/css/in/animate.css" rel="stylesheet">
    <link href="/Admin/css/in/style.css" rel="stylesheet">

    <link rel="stylesheet" href="/Admin/css/in/stylesheet.css">
    <link href="/Admin/css/in/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
	<link rel="stylesheet" href="/Admin/js/in/plugins/scojs/css/scojs.css">
</head>
<body>
<div class="modal-dialog">
    <div class="modal-body" style="    color: #18a689;
    font-size: 20px;">
      <div class="alert with-icon alert-pure" style="color: #9B30FF">
        <i class="icon-smile"></i>
        
        <div class="content">
        <?php echo($message); ?>
     	</div>
      </div>
    </div>
    <div class="modal-footer">
   <a href="<?php echo($jumpUrl); ?>" class="btn btn-primary" style="float: right;">确定</a>
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
					//clearInterval(interval);
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