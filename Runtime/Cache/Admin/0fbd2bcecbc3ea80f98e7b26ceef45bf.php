<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	<?php echo($error); ?>
</title>

</head>
<body>
	<div class="modal-dialog">
    <div class="modal-header"><strong><?php echo L('REMIND');?>
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
<a href="<?php echo($jumpUrl); ?>" class="btn btn-primary" style="float: right;"><?php echo L('CONFIRM');?></a>
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