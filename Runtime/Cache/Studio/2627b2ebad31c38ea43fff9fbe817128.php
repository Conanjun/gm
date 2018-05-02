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
                                    <a href="<?php echo U('User/updatepassword');?>" class="iframe" data-width="500" data-height="250"><?php echo L('CHANGE_PASSWORD');?></a>
                                </li>
                                <li>
                                    <a href="<?php echo U('User/update');?>" class="iframe" data-width="600" data-height="320"><?php echo L('EDIT_PERSONAL_INFORMATION');?></a>
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
                        <?php if(!empty($lists)): ?><li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-warning">16</span>
                            </a>
                            <ul class="dropdown-menu dropdown-messages">
                                <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                        <div class="dropdown-messages-box">

                                            <div class="media-body">
                                                <small class="pull-right"></small>
                                                <strong><?php echo ($vo["nickname"]); ?></strong>
                                                <strong><?php echo ($vo["title"]); ?></strong>.
                                                <br>
                                                <small class="text-muted">
                                                	 <?php if($vo['addtime']): echo (date("Y-m-d H:i:s",$vo['addtime'])); else: ?>-<?php endif; ?>
                                                </small>
                                            </div>

                                        </div>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="mailbox.html">
                                            <i class="fa fa-envelope"></i>
                                            <strong>Read All Messages</strong>
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
                
    <script src='Admin/jsnew/jquery.validate.min.js' type='text/javascript'></script>
    <script>
        $(function(){
            $('#form').validate({
                errorPlacement: function (error, element) {
                    $(element).parent().append(error);
                    console.log(error);
                    console.log(element);
                },
                onkeyup: false,
                rules: {
                    zh_pname: {
                        required: true,
                    },
                    en_pname: {
                        required: true,
                    },
                    servicetype: {
                        required: true,
                    },
                },
                messages: {
                    zh_pname: {
                        required :"<?php echo L('FILL_IN_ZHNAME');?>"
                    },
                    en_pname: {
                        required : "<?php echo L('FILL_IN_ENNAME');?>"
                    },
                    servicetype: {
                        required : "<?php echo L('PLAY_IN_SERVICE_TYPE');?>"
                    },
                }
            });
        });


    </script>
    <!-- content begin -->
    <div class="wrapper wrapper-content">

        <!-- in+ dom -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <!-- title -->
                    <div class="ibox-title">
                        <h5>
                            <?php echo L('COSTPLAN');?>
                            <small><?php echo L('EDIT');?></small>
                            <div class="ibox-button">
                            	<a href="javascript:history.go(-1);" class="btn btn-primary btn-sm" type="button"><?php echo L('BACK');?></a>
                        	</div>
                        </h5>
                    </div>
                    <!-- content -->
                    <div class="ibox-content">

                        <form action="<?php echo U('Costplan/edit');?>" method='post' id="form" class="form-horizontal" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo ($data["planid"]); ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('SERVICE_TYPE');?><span class="required"></span></label>
                                <div class="col-sm-3">
                                    <select class="form-control m-b"  name="servicetype">
                                        <option value=""><?php echo L('PLEASE_SELECT');?></option>
                                        <?php if(is_array($dic)): $i = 0; $__LIST__ = $dic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$d): $mod = ($i % 2 );++$i;?><option value="<?php echo ($d["d_key"]); ?>" <?php if($data['servicetype'] == $d['d_key']): ?>selected<?php endif; ?>><?php echo (l($d["d_value"])); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('SERVICE_NAME_ZH');?><span class="required"></span></label>
                                <div class="col-sm-3">
                                    <input type="text" name="zh_pname" value="<?php echo ($data["zh_pname"]); ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('SERVICE_NAME_EN');?><span class="required"></span></label>
                                <div class="col-sm-3">
                                    <input type="text" name="en_pname" class="form-control" value="<?php echo ($data["en_pname"]); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('TYPE');?></label>
                                <div class="col-sm-3">
                                    <div class="radio  radio-inline"> <input type="radio" value="0" name="type" id="type" <?php if($data['type'] == 0): ?>checked<?php endif; ?> ><label for="type"> <?php echo L('NORMALS');?></label></div>
                                    <div class="radio  radio-inline"> <input type="radio" value="1" name="type"  id="type1" <?php if($data['type'] == 1): ?>checked<?php endif; ?>> <label for="type1"> <?php echo L('OTHERS');?> </label></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('DISCOUNT');?></label>
                                <div class="col-sm-3">
                                    <input type="text" name="discount" value="<?php echo ($data["discount"]); ?>" class="form-control">
                                </div>
                            </div>
                            <?php if(is_array($data1)): $i = 0; $__LIST__ = $data1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$d): $mod = ($i % 2 );++$i; if($d["plansubid"] != ''): ?><input type="hidden" name="plansubid[]"  value="<?php echo ($d["plansubid"]); ?>" class="form-control">
                                    <?php else: ?>
                                    <input type="hidden" name="plansubid[]"  value="-1" class="form-control"><?php endif; ?>
                                <input type="hidden" name="feeitem[]" class="form-control" value="<?php echo ($d["itemid"]); ?>">
                                <input type="hidden" name="feecode[]" class="form-control" value="<?php echo ($d["feecode"]); ?>">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo L('FEE_NAME');?></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" value="<?php echo ($d["feename"]); ?>" disabled="true">
                                        <input type="hidden" name="feename[]" class="form-control" value="<?php echo ($d["feename"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo L('PRICE_RMB');?></label>
                                    <div class="col-sm-3">
                                        <input type="text" name="price[]"  value="<?php echo ($d["price"]); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo L('DOLLAR_PRICE');?></label>
                                    <div class="col-sm-3">
                                        <input type="text" name="price1[]" value="<?php echo ($d["price1"]); ?>" class="form-control">
                                    </div>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="javascript:history.go(-1);" class="btn btn-white" type="button"><?php echo L('BACK');?></a>
                                    <button class="btn btn-primary" type="submit"><?php echo L('SAVE');?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- content end -->

            </div>
        </div>
    </div>
    
</body>

</html>