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
                
    <script src="Admin/jsnew/ckeditor/ckeditor.js"></script>
    <script src="Admin/jsnew/all.fine-uploader/all.fine-uploader.min.js"></script>
    <link href="Admin/jsnew/all.fine-uploader/fine-uploader-gallery.min.css" rel="stylesheet"/>
    <link href="Admin/jsnew/all.fine-uploader/fine-uploader-new.min.css" rel="stylesheet"/>
    <script src='Admin/jsnew/jquery.validate.min.js' type='text/javascript'></script>
<script src='Admin/jsnew/jquery.datetimepicker.full.js' type='text/javascript'></script>
<link href="Admin/css/jquery.datetimepicker.css" rel="stylesheet"  type="text/css" />
<script>
$(function(){
    $('#birthday').datetimepicker({step:10,lang:'ch',timepicker:false,format:'Y-m-d'});
    jQuery.validator.addMethod("isMobile", function(value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "<?php echo L('MOBILE_CORRECT');?>");

    $('form').validate({
        errorPlacement: function (error, element) {
            $(element).parent().append(error);
            console.log(error);
            console.log(element);
        },
        onkeyup: false,
        rules: {
        	username: {
                required: true,
             /*   byteRange: [3, 15, 'utf-8'],*/
                remote: {
                    url: "<?php echo U('User/check_user');?>",
                    type: 'post',
                    data: {
                        username: function () {
                           return $('#username').val();
                        }
                    }
                }
            },
            password: {
                required: true,
                maxlength: 20,
                minlength: 6
            },
           nickname: {
               required: true
           },
           email: {
               required: true,
               email:true,
               remote: {
                   url: "<?php echo U('User/check_email');?>",
                   type: 'post',
                   data: {
                       email: function () {
                           return $('#email').val();
                       }
                   }
               }
           },
           mobile: {
               required: true,
               isMobile:true,
               remote: {
                   url: "<?php echo U('User/check_mobile');?>",
                   type: 'post',
                   data: {
                       mobile: function () {
                           return $('#mobile').val();
                       }
                   }
               }
           },
        },
        messages: {
        	username: {
        		required : "<?php echo L('USERNAME_NOT_EMPTY');?>", // 用户名不能为空
                remote: "<?php echo L('USERNAME_EXISTED');?>" //用户名已被占用
            },
            password: {
            	required : "<?php echo L('PASSWORD_NOT_EMPTY');?>",
               maxlength: "<?php echo L('PASSWORD_LENTH');?>",
    			minlength: "<?php echo L('PASSWORD_LENTH');?>"
            },
           nickname: {
               required: "<?php echo L('MNAME_NOT_EMPTY');?>",
           },
           email: {
               required: "<?php echo L('EMAIL_NOT_EMPTY');?>",
               email:"<?php echo L('EMAIL_FORMAT');?>",
               remote: "<?php echo L('EMAIL_EXISTED');?>"
           },
           mobile: {
               required: "<?php echo L('MOBILE_NOT_EMPTY');?>",
               isMobile:"<?php echo L('MOBILE_CORRECT');?>",
               remote: "<?php echo L('MOBILE_EXISTED');?>"
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
                            <?php echo L('STUDIO_USER');?>
                            <small><?php echo L('ADD');?></small>
                        </h5>
                        <div class="ibox-button">
                            <a href="javascript:history.go(-1);" class="btn btn-primary btn-sm" type="button"><?php echo L('BACK');?></a>
                        </div>
                    </div>
                    <!-- content -->
                    <div class="ibox-content">

                        <form action="<?php echo U('User/add');?>" method='post' id="form" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('UNAME');?><span class="required"></span></label>
                                <div class="col-sm-3">
                                    <input type="text" name="username" id="username" value="" class="form-control" autocomplete="off" placeholder="<?php echo L('UNAME_NOT_EMPTY');?>">
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('PASSWORD');?><span class="required"></span></label>
                                <div class="col-sm-3">
                                    <input type="password" name="password" id="password" value="" class="form-control" autocomplete="off" placeholder="<?php echo L('PASSWORD_LENTH');?>">
                                </div>
                            </div>
							 <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('MNAME');?><span class="required"></span></label>
                                <div class="col-sm-3">
                                    <input type="text" name="nickname" id="nickname" id="nickname" value="" class="form-control" autocomplete="off" placeholder="<?php echo L('NNAME_NOT_EMPTY');?>">
                                </div>
                            </div>
                            <!--<div class="form-group">-->
                                <!--<label class="col-sm-2 control-label"><?php echo L('DNAME');?></label>-->
                                <!--<div class="col-sm-3">-->
                                    <!--<select class="form-control m-b"  name="dept">-->
                                        <!--<option><?php echo L('PLEASE_SELECT');?></option>-->
                                        <!--<?php if(is_array($depts)): $i = 0; $__LIST__ = $depts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?>-->
											<!--<option value="<?php echo ($r["did"]); ?>"><?php echo ($r["title_show"]); ?></option>-->
										<!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                                    <!--</select>-->
                                <!--</div>-->
                            <!--</div>-->
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('EMAIL');?><span class="required"></span></label>
                                <div class="col-sm-3">
                                    <input type="text" name="email" class="form-control" id="email" value="" class="form-control" autocomplete="off"placeholder="<?php echo L('EMAIL_NOT_EMPTY');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('MOBILE');?><span class="required"></span></label>
                                <div class="col-sm-3">
                                    <input type="text" name="mobile" id="mobile" value="" class="form-control" autocomplete="off" placeholder="<?php echo L('MOBILE_NOT_EMPTY');?>">
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('BIRTHDAY');?></label>
                                <div class="col-sm-3">
                                    <input type="text" name="birthday" id="birthday" value="" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('SEX');?></label>
                                <div class="col-sm-3">
                                    <div class="radio  radio-inline"> <input type="radio" value="1" name="sex" checked id="sex"><label for="sex"> <?php echo L('MAN');?></label></div>
                                    <div class="radio  radio-inline"> <input type="radio" value="2" name="sex"  id="sex1"> <label for="sex1"> <?php echo L('WOMAN');?> </label></div>
									<div class="radio  radio-inline"><input type="radio" value="0" name="sex"  id="sex2"> <label for="sex2"><?php echo L('SECRECY');?></label> </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="javascript:history.go(-1);" class="btn btn-default" type="button"><?php echo L('BACK');?></a>
									<a href="javascript:;" id="submit" class="btn btn-primary" onclick="$('form').submit();" data-loading="稍候..."><i class="icon-save"></i> <?php echo L('SAVE');?></a>
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