<?php if (!defined('THINK_PATH')) exit();?>

    <link href="Admin/css/in/iviews-order.css" rel="stylesheet">
    <!-- content begin -->
    <div class="wrapper wrapper-content">
        <div class="iviews-order-content iviews-order-step1">
            <div class="iviews-order-type">
                <?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['d_value'] == 'PLANT'): ?><a href="<?php echo U('Order/add?type='.$vo['sid']);?>"  data-type="1" class="iviews-order-type-1" ><?php echo (l($vo['d_value'])); ?></a>
                        <?php elseif($vo['d_value'] == 'GINGIVITIS'): ?>
                        <a href="<?php echo U('Order/add?type='.$vo['sid']);?>"  data-type="1" class="iviews-order-type-2" ><?php echo (l($vo['d_value'])); ?></a>
                        <?php elseif($vo['d_value'] == 'IROK'): ?>
                        <a href="<?php echo U('Order/add?type='.$vo['sid']);?>"  data-type="1" class="iviews-order-type-3" ><?php echo (l($vo['d_value'])); ?></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
    <!-- content end -->