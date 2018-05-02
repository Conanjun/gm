<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo L('SYSTITLE');?></title>

    <link href="/Admin/css/in/bootstrap.min.css" rel="stylesheet">
    <link href="/Admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/Admin/css/in/animate.css" rel="stylesheet">
    <link href="/Admin/css/in/style.css" rel="stylesheet">

    <link rel="stylesheet" href="/Admin/css/in/stylesheet.css">
    <link href="/Admin/css/in/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
	<link rel="stylesheet" href="/Admin/js/in/plugins/scojs/css/scojs.css">
    <!-- Mainly scripts -->
    <script src="/Admin/js/in/jquery-2.1.1.js"></script>
    <script src="/Admin/js/in/bootstrap.min.js"></script>
    <script src="/Admin/js/in/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/Admin/js/in/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/Admin/js/in/plugins/iCheck/icheck.min.js"></script>

    <!-- Chosen -->
    <script src="/Admin/js/in/plugins/chosen/chosen.jquery.js"></script>

    <link href="/Admin/css/in/plugins/chosen/chosen.css" rel="stylesheet">

    <!-- Custom and plugin javascript -->
    <script src="/Admin/js/in/inspinia.js"></script>
    <script src="/Admin/js/in/plugins/pace/pace.min.js"></script>

    <script src="/Admin/js/in/iviews.base.js"></script>
	<script src="/Admin/js/in/iviews.extend.js"></script>

    <!-- Scojs -->
    <script src="/Admin/js/in/plugins/scojs/js/sco.modal.js"></script>
    <script src="/Admin/js/in/plugins/scojs/js/sco.confirm.js"></script>
    <script src="/Admin/js/in/plugins/scojs/js/sco.message.js"></script>	
    
    <script src="/Admin/js/in/mlselection.js"></script>
    <script src="/Admin/js/in/inline_edit.js"></script>



    <script>

        $(function(){

            $('.ui-select').chosen();
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $.menu();
        })

    </script>

</head>

<body class="">

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span>
                                <img alt="image" class="img-circle" src="/Admin/img/profile_small.jpg" style="width: 50px"/>
                            </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="m-t-xs block">
                                         <strong class="font-bold"><?php echo session('user_auth.username');?></strong>
                                        <b class="caret"></b>
                                    </span>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                               <li>
                                    <a data-trigger="modal" data-title="<?php echo L('CHANGE_PASSWORD');?>" data-width="1000px" href="<?php echo U('User/updatepassword');?>" class="iframe"><?php echo L('CHANGE_PASSWORD');?></a>
                                </li>
                                <li>
                                    <a data-trigger="modal" data-title="<?php echo L('EDIT_PERSONAL_INFORMATION');?>" data-width="1000px" href="<?php echo U('User/update');?>" class="iframe" ><?php echo L('EDIT_PERSONAL_INFORMATION');?></a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo U('Public/logout');?>"><?php echo L('LOGOUT');?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            GM
                        </div>
                    </li>
                    <li class="nav-language">
                        <span><?php echo L('LANG_SWITCHER');?></span>
                          <div class="nav-language-list">
                            <a href="javascript:" data-u="/index.php?s=/Admin/index/changelang/&lang=zh" id="langurl1" class="nav-language-cn">
                                <span><?php echo L('ZH_CN');?></span>
                            </a>
                            <a href="javascript:" data-u="/index.php?s=/Admin/index/changelang/&lang=en" id="langurl2" class="nav-language-en">
                                <span><?php echo L('EN_US');?></span>
                            </a>
                        </div>
                        <script>
                        $("#langurl1").click(function(){
                        	$.ajax({
                     		   type: "POST",
                     		   url: $(this).data("u"),
                     		   dataType: 'text',
                     		   data: {},
                     		   success: function(data){
                     		    	window.location.href="<?php echo ($_url_); ?>";
                     		   }
                     		});
                        });
                        $("#langurl2").click(function(){
                        	$.ajax({
                     		   type: "POST",
                     		   url: $(this).data("u"),
                     		   dataType: 'text',
                     		   data: {},
                     		   success: function(data){
                     		    	window.location.href="<?php echo ($_url_); ?>";
                     		   }
                     		});
                        });
                        </script>
                    </li>
                    <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                            <a href="javascript:;">
                                <i class="fa <?php echo ($menu["icon_class"]); ?>"></i>
                                <span class="nav-label"><?php echo (l($menu["title"])); ?></span>
                                <?php if(!empty($menu["child"])): ?><span class="fa arrow"></span><?php endif; ?>
                            </a>
                            <?php if(!empty($menu["child"])): ?><ul class="nav nav-second-level collapse">
                                    <?php if(is_array($menu["child"])): $i = 0; $__LIST__ = $menu["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><li class="<?php echo ($child["a"]); ?>">
                                            <a href="<?php echo (u($child["url"])); ?>"><?php echo (l($child["title"])); ?></a>
                                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul><?php endif; ?>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message"><?php echo L('WELCOME_MESSAGE');?></span>
                        </li>
                        <?php if(!empty($list_s)): ?><li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-warning"><?php echo ($count); ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-messages">
                                <?php if(is_array($list_s)): $i = 0; $__LIST__ = $list_s;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                        <div class="dropdown-messages-box">

                                            <div class="media-body">
                                                <small class="pull-right"></small>
                                                <strong><?php echo ($vo["nickname"]); ?></strong>
                                                <strong><?php echo ($vo["title"]); ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                	 <?php if($vo['addtime']): echo (date("Y-m-d H:i:s",$vo['addtime'])); else: endif; ?>
                                                </small>
                                            </div>

                                        </div>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="<?php echo U('Message/index');?>">
                                            <i class="fa fa-envelope"></i>
                                            <strong><?php echo L('READAll');?></strong>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <?php else: ?>
                             <li class="dropdown">
		                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
		                                <i class="fa fa-envelope"></i>
		                                <span class="label label-warning">0</span>
		                            </a>
		                        </li><?php endif; ?>
                        <li>
                            <a href="<?php echo U('Public/logout');?>">
                                <i class="fa fa-sign-out"></i><?php echo L('LOGOUT');?>
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                
    <!-- content begin -->
    <div class="wrapper wrapper-content">

        <div class="row">
            <div class="col-lg-12">
                <!-- ibox begin -->
                <div class="ibox">
                    <div class="ibox-title">
                        <h5><?php echo L('ORDER_MANAGE');?></h5>
                    </div>

                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="get" class="form-horizontal">
                                    <input type="hidden" name="s" value="/Studio/OrderTaskCp/index"/>
                                    <table id="tt_1">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <label><?php echo L('TASK_LIST_NAME');?></label>
                                                <input class="form-control" type="text" name="tname" value="<?php echo ($_GET['tname']); ?>">
                                            </td>
                                            <td>
                                                <label><?php echo L('ORDER_SN');?></label>
                                                <input class="form-control" type="text" name="order_sn" value="<?php echo ($_GET['order_sn']); ?>">
                                            </td>
                                            <td>
                                                <label><?php echo L('FINISHMAN');?></label>
                                                <input class="form-control" type="text" name="finishname" value="<?php echo ($_GET['finishname']); ?>">
                                            </td>
                                            <td>
                                                <label><?php echo L('TASK_STATE');?></label>
                                                <select name="state" class="form-control" style="width: 180px">
                                                    <option value=""><?php echo L(PLEASE_SELECT);?></option>
                                                    <option value="1" <?php if($_GET['state']== 1): ?>selected<?php endif; ?>><?php echo L('FINISH');?></option>
                                                    <option value="2" <?php if($_GET['state']== 2): ?>selected<?php endif; ?>><?php echo L('NOFINISH');?> </option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label><?php echo L('ISURGENT');?></label>
                                                <select name="isurgent" class="form-control" style="width: 180px">
                                                    <option value=""><?php echo L(PLEASE_SELECT);?></option>
                                                    <option value="1" <?php if($_GET['isurgent']== 1): ?>selected<?php endif; ?>><?php echo L('YES');?></option>
                                                    <option value="2" <?php if($_GET['isurgent']== 2): ?>selected<?php endif; ?>><?php echo L('NO');?> </option>
                                                </select>
                                            </td>
                                            <td>
                                                <label><?php echo L('TASK_SEND_TIME');?></label>
                                                <input style="width: 110px;" class="form-control" type="text"  id="start_addtime" name="start_addtime" value="<?php echo ($_GET['start_addtime']); ?>">
                                                <input style="width: 110px;" class="form-control" type="text" id="end_addtime" name="end_addtime" value="<?php echo ($_GET['end_addtime']); ?>">
                                            </td>
                                            <td>
                                                <label><?php echo L('FINISHTIME');?></label>
                                                <input style="width: 110px;" class="form-control" type="text" id="start_finishtime" name="start_finishtime" value="<?php echo ($_GET['start_finishtime']); ?>">
                                                <input style="width: 110px;" class="form-control" type="text" id="end_finishtime" name="end_finishtime" value="<?php echo ($_GET['end_finishtime']); ?>">
                                            </td>
                                            <td>
                                                <input type="submit" class="btn btn-primary" value="<?php echo L('QUERY');?>">
                                                <?php if($filtered != 0): ?><a href="<?php echo U('OrderTaskCp/index');?>" class="btn btn-default"><?php echo L('BACKOUT');?></a><?php endif; ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-center">
                                <thead>
                                <tr>
                                    <th><?php echo L('TASK_LIST_NAME');?> </th>
                                    <th><?php echo L('TASK_ORDER');?> </span></th>
                                    <th style="width: 100px"><span ectype="order_by" fieldname="t.isurgent"><?php echo L('ISURGENT');?><i class="fa fa-sort"></i></span></th>
                                    <th style="width: 100px"><?php echo L('TASK_STATE');?></th>
                                    <th style="width: 150px"><span ectype="order_by" fieldname="t.addtime"><?php echo L('TASK_SEND_TIME');?><i class="fa fa-sort"></i></span></th>
                                    <th style="width: 150px"><span ectype="order_by" fieldname="t.finishtime"><?php echo L('FINISHTIME');?><i class="fa fa-sort"></i></span></th>
                                    <th style="width: 80px"><?php echo L('FINISHMAN');?></th>
                                    <th style="width: 120px"><?php echo L('HANDLE');?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($lists)): if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td style="text-align: left"><?php echo ($vo['tname']); ?></td>
                                            <td>
                                                <a href="<?php echo U('PlatOrder/view?id='.$vo['oid']);?>"><?php echo ($vo["order_sn"]); ?>-<?php echo L($vo['str_state']);?></a>
                                            </td>
                                            <td>
                                                <?php if($vo['task_isurgent']): ?><img src="Admin/images/prompt.png"/>
                                                    <?php else: ?>
                                                    <img src="Admin/images/positive_disabled.png"/><?php endif; ?>
                                            </td>
                                            <td><?php if($vo['task_state'] == 1): echo L(FINISH); else: echo L(NOFINISH); endif; ?></td>
                                            <td>
                                                <?php if($vo['task_addtime']): echo (date("Y-m-d H:i:s",$vo['task_addtime'])); else: ?>-<?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($vo['task_finishtime']): echo (date("Y-m-d H:i:s",$vo['task_finishtime'])); else: ?>-<?php endif; ?>
                                            </td>
                                            <td><?php if($vo['task_finishuid'] > 0): echo ($vo["task_finishman"]); else: ?>-<?php endif; ?></td>
                                            <td>
                                                <?php if($vo['task_state'] == 0): ?><a href="javascript:;"  onclick="reply(<?php echo ($vo['tastkid']); ?>)" class="btn btn-xs btn-primary"><?php echo L('FINISH_HANDEL');?></a><?php endif; ?>
                                                <?php if($vo["prompt"] == 1): ?><span class="red"><?php echo L('S_NOPAY');?></span><?php endif; ?>
                                            </td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="9"><?php echo L('NOCONCENT');?></td>
                                    </tr><?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="modal fade" id="edit-form">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <a class="close" href="#" data-dismiss="modal">×</a>
                                        <h3><?php echo L('S_TASK_TASK_SPEC');?></h3>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo U('OrderTaskCp/confirm');?>" class="form-horizontal" id="task_form" method='post' enctype="multipart/form-data">
                                            <input type="hidden" name="tid" id="task_id" value="" >
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"><?php echo L('S_TASK_TASK_SPEC');?></label>
                                                <div class="col-sm-9">
                                                    <textarea  name="finishnote" style="width: 400px;height: 170px;"></textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-default" data-dismiss="modal"><?php echo L('S_TASK_CANCEL');?></a>
                                        <a href="javascript:void(0);"  id="save" class="btn btn-primary" data-action="1"><?php echo L('S_TASK_CONFIRM');?></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="iviews-pager clearfix">
                            <div class="btn-group pull-right">
                                <?php echo ($_page); ?>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ibox end -->
            </div>
        </div>

    </div>
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        <?php echo L('sysnotice');?>
                    </h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo L('close');?></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
    <!-- content end -->
    <script>
        $(document).ready(function(){
            var error_box = $("#errorModal");
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $("#save").click(function () {
                var tid=$("#task_id").val() ;
                var finishnote = $("#finishnote").val() ;
                $.ajax({
                    url: base.url + $('#task_form').attr('action') ,
                    type: 'POST' ,
                    data: {'tid':tid,'finishnote':finishnote},
                    dataType: 'json' ,
                    beforeSend: function() {
                    },
                    success: function(res) {
                        if( res.status == 1 ) {
                            window.location.href = res.url;
                        } else {
                            modal.text(error_box, res.info);
                            modal.open(error_box);
                        }
                    },
                    error: function(err) {
                    }

                })
            })
        });
        function reply(id) {
            $('.ui-select').chosen();
            $('#task_id').val(id);
            modal.open('#edit-form');
        }
    </script>

            </div>
        </div>
    </div>
    
</body>

</html>