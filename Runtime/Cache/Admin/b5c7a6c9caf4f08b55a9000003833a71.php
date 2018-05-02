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
                
    <script src="Admin/jsnew/ckeditor/ckeditor.js"></script>
    <script src="Admin/jsnew/all.fine-uploader/all.fine-uploader.min.js"></script>
    <link href="Admin/jsnew/all.fine-uploader/fine-uploader-gallery.min.css" rel="stylesheet"/>
    <link href="Admin/jsnew/all.fine-uploader/fine-uploader-new.min.css" rel="stylesheet"/>
    <style>
        .formbtn:hover{
            color:#333333
        }
        .qq-upload-button {
            width: 192px;
            height: 100px;
            border: 0;
            background: url("/admin/images/plus.png") no-repeat center center #efefef;
            border: 0;
            background-size: 50px;
        }
        .qq-upload-list-selector li{position: relative;}
        .pdel {
            background: url('/admin/images/cl.png') no-repeat left top;
            position: absolute;
            width: 14px;
            height: 14px;
            top: -5px;
            right:-5px;
            z-index: 1;
        }
        .qq-thumbnail-selector {
            vertical-align: middle;
            margin-right: 0px;
            width: 200px;
        }
        ul{
            list-style-type:none;
            margin: 0;
            padding: 0;
        }
        .sitem li.lion {
            background: #1ab394;
            color: #fff;
        }
        .sitem li{
            float: left;
            background: #f2f2f2;
            height: 25px;
            line-height: 25px;
            margin-right: 10px;
            padding: 0 10px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            cursor: pointer;
            color: #888;
            transition: 0.3s;
        }

    </style>
    <script>
        var grid = 0;
        $(function(){
            regionInit("region");
            $("[id^='li_']").click(function(){
                var h=$(this).attr("h");
                var item=$(this).attr("item");
                if(h==0){
                    $(this).attr("h",1);
                    $(this).addClass("lion");
                    var item1=$(this).attr("item1");
                    $("#ss_"+item).val(item1);
                }else if(h==1){
                    $(this).attr("h",0);
                    $(this).removeClass("lion");
                    $("#ss_"+item).val("");
                }
            });
        });
    </script>
	
	<link href="Admin/css/n.css" rel="stylesheet"  type="text/css" />
<script src='Admin/jsnew/jquery.validate.min.js' type='text/javascript'></script>
<script>
$(function(){
	$('form').validate({
		   errorPlacement: function (error, element) {
	            $(element).parent().append(error);
	        },
	    onkeyup: false,
	    rules: {
	    	tag_name: {
	            required: true,
	        },
	        tag_type: {
	            required: true,
	        },
	    },
	    messages: {
	    	tag_name: {
	    		required :  "<?php echo L('TAGNAME_NOT_EMPTY');?>",
	        },
	        tag_type: {
	    		required :  "<?php echo L('TYPE_NOT_EMPTY');?>",
            },
        },
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
                            <?php echo L('TAG_LIBRARY');?>
                            <small><?php echo L('ADD');?></small>
                        </h5>
                        <div class="ibox-button">
                            <a href="javascript:history.go(-1);" class="btn btn-primary btn-sm" type="button"><?php echo L('BACK');?></a>
                        </div>
                    </div>
                    <!-- content -->
                    <div class="ibox-content">

                        <form action="<?php echo U('Tag/add');?>" method='post' id="form" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('NAME');?><span class="required"></span></label>
                                <div class="col-sm-3">
                                    <input type="text" name="tag_name" value="" class="form-control" autocomplete="off" placeholder="<?php echo L('TAGNAME_NOT_EMPTY');?>">
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('TYPE');?><span class="required"></span></label>
                                <div class="col-sm-3">
                                    <select class="form-control m-b"  name="tag_type">
                                        <option value=""><?php echo L('PLEASE_SELECT');?></option>
                                        <?php if(is_array($sts)): $i = 0; $__LIST__ = $sts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><option value="<?php echo ($s["d_key"]); ?>"><?php echo (l($s["d_value"])); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>
							
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="javascript:history.go(-1);" class="btn btn-white" type="button"><?php echo L('BACK');?></a>
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