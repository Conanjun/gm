<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo L('SYSTITLE');?></title>
	<link href="/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link href="/favicon.ico" type="image/x-icon" rel="icon">

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
    <script src="Admin/jsnew/jquery.form.js" type="text/javascript"></script>



    <script>

        $(function(){

            $('.ui-select').chosen();
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $.menu();
        })

        var autoformcan=false;
    function cksimpleload(e){
    	autoformcan=false;
    	$("#autoform").remove();

		var form="<form id='autoform'><input type='file' name='ckauto' id='ckauto' accept='image/*'/></form>";
		$("body").prepend(form);
		
		$("#autoform").submit(function(e){
			if(!autoformcan){
				return false;
			}
		});
		
		$("#ckauto").change(function (ex) {
			autoformcan=true;
			$("#autoform").ajaxSubmit({    
				url: "<?php echo U('Index/loadfile');?>" ,    
				type: 'POST',    
				dataType: 'json',    
				success: function (data) {  
					if(data.done){
						if(data.w>800){
							data.w=data.w/2;
							data.h=data.h/2;
						}
						var element = CKEDITOR.dom.element.createFromHtml( '<img data-cke-saved-src="'+data.path+'" src="'+data.path+'" style="width:'+data.w+'px;height:'+data.h+'px;"/>' );
						e.insertElement(element);
					}
					$("#autoform").remove();
				},    
				error: function (data) {    
					//alert(data);
					$("#autoform").remove();
				}    
			});
		});
		
		$("#ckauto").click();
    }
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
                        <!--<li class="dropdown">-->
                            <!--<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">-->
                                <!--<i class="fa fa-envelope"></i>-->
                                <!--<span class="label label-warning">16</span>-->
                            <!--</a>-->
                            <!--<ul class="dropdown-menu dropdown-messages">-->
                                <!--<li>-->
                                    <!--<div class="dropdown-messages-box">-->
                                       <!---->
                                        <!--<div class="media-body">-->
                                            <!--<small class="pull-right">46h ago</small>-->
                                            <!--<strong>Mike Loreipsum</strong> started following-->
                                            <!--<strong>Monica Smith</strong>.-->
                                            <!--<br>-->
                                            <!--<small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>-->
                                        <!--</div>-->
                                    <!--</div>-->
                                <!--</li>-->
                                <!--<li class="divider"></li>-->
                                <!--<li>-->
                                    <!--<div class="text-center link-block">-->
                                        <!--<a href="mailbox.html">-->
                                            <!--<i class="fa fa-envelope"></i>-->
                                            <!--<strong>Read All Messages</strong>-->
                                        <!--</a>-->
                                    <!--</div>-->
                                <!--</li>-->
                            <!--</ul>-->
                        <!--</li>-->
                        <li>
                            <a href="<?php echo U('Public/logout');?>">
                                <i class="fa fa-sign-out"></i><?php echo L('LOGOUT');?>
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">
                
    <script type="text/javascript">
        var grid = 0;
        var ajaxurl = "<?php echo U('Dictionary/ajax_col');?>";
        $(function(){
            regionInit("region");
        });
    </script>
    <!-- content begin -->
    <div class="wrapper wrapper-content">

        <div class="row">
            <div class="col-lg-12">
                <!-- ibox begin -->
                <div class="ibox">
                    <div class="ibox-title">
                        <h5><?php echo L('DATA_DICTIONARY');?></h5>
                        <div class="ibox-button">
                            <a href="<?php echo U('Dictionary/add');?>" class="btn btn-primary btn-sm"><?php echo L('ADD');?></a>
                        </div>
                    </div>

                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-lg-12">
                                <form method="get" class="form-horizontal">
                                    <input type="hidden" name="s" value="/Admin/Dictionary/index"/>
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <label><?php echo L('CODE');?></label>
                                                <input class="form-control" type="text" name="code" value="<?php echo ($_GET['code']); ?>">
                                            </td>
                                            <td>
                                                <label><?php echo L('NAME');?></label>
                                                <input class="form-control" type="text" name="name" value="<?php echo ($_GET['name']); ?>">
                                            </td>
                                            <td>
                                                <label><?php echo L('STATE');?></label>
                                                <select name="d_del" class="form-control">
                                                    <option value=""><?php echo L('PLEASE_SELECT');?></option>
                                                    <option value="1" <?php if($_GET['d_del']== 1): ?>selected<?php endif; ?>><?php echo L('OPEN');?></option>
                                                    <option value="2" <?php if($_GET['d_del']== 2): ?>selected<?php endif; ?>><?php echo L('CLOSE');?> </option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="submit" class="btn btn-primary" value="<?php echo L('QUERY');?>">
                                                <?php if($filtered != 0): ?><a href="<?php echo U('Dictionary/index');?>" class="btn btn-white"><?php echo L('BACKOUT');?></a><?php endif; ?>
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
                                    <th style="width: 30px"><div class="checkbox checkbox-success"><input type="checkbox" class="check-all"><label></label></div></th>
                                    <th><span ectype="order_by" fieldname="d_code"><?php echo L('CODE');?> <i class="fa fa-sort"></i></span></span></th>
									<th><span ectype="order_by" fieldname="d_name"><?php echo L('NAME');?><i class="fa fa-sort"></i></span></th>
                                    <th><span ectype="order_by" fieldname="d_key"><?php echo L('DKEY');?> <i class="fa fa-sort"></i></span></span></th>
                                    <th><span ectype="order_by" fieldname="d_value"><?php echo L('DVALUE');?><i class="fa fa-sort"></i></span></span></th>
                                    <th><span ectype="order_by" fieldname="d_order"><?php echo L('DORDER');?><i class="fa fa-sort"></i></span></th>
									<th><span ectype="order_by" fieldname="d_del"><?php echo L('STATE');?><i class="fa fa-sort"></i></span></th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($lists)): if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                            <td>
                                                <div class="checkbox checkbox-success">
                                                    <input type="checkbox" name="check" value="<?php echo ($vo['d_tid']); ?>" class="check"><label></label></div>
                                            </td>
                                            <td><?php echo ($vo['d_code']); ?></td>
                                            <td><?php echo ($vo['d_name']); ?></td>
                                            <td><?php echo ($vo['d_key']); ?></td>
                                            <td><?php echo ($vo['d_value']); ?></td>
											<td><?php echo ($vo['d_order']); ?></td>
                                            <td>
                                                <?php if($vo['d_del'] == 0): ?><img src="Admin/images/positive_enabled.png" ectype="inline_edit" fieldname="d_del" fieldid="<?php echo ($vo["d_tid"]); ?>" fieldvalue="0" title="<?php echo L('EDITABLE');?>"/>
                                                    <?php else: ?>
                                                    <img src="Admin/images/positive_disabled.png" ectype="inline_edit" fieldname="d_del" fieldid="<?php echo ($vo["d_tid"]); ?>" fieldvalue="1" title="<?php echo L('EDITABLE');?>"/><?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo U('Dictionary/edit?id='.$vo['d_tid']);?>" class="btn btn-xs btn-primary"><?php echo L('EDIT');?></a>
                                                <a href="<?php echo U('Dictionary/deletedata?id='.$vo['d_tid']);?>" class="btn btn-xs btn-white confirm ajax-get"><?php echo L('DELETE');?></a>
                                            </td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                <?php else: ?>
                                   <tr>
                                       <td colspan="9"><?php echo L('NOCONCENT');?></td>
                                   </tr><?php endif; ?>

                                </tbody>
                            </table>
                        </div>

                        <div class="iviews-pager clearfix">
                            <div class="pull-left">
                                <input type="hidden" id="checkBoxArr" value="" name="ids">
                                <button type="button" id="del" class="btn btn-white"><?php echo L('DELETE');?></button>
                            </div>
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
    <!-- content end -->
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            // 多选删除
            var url = 'index.php?s=/Admin/Dictionary/deletedata';

            $('#del').on('click', function(){
                $.del.all('.table',url);
            })
        });
    </script>

            </div>
        </div>
    </div>
    
</body>

</html>