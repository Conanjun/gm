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
                                        <a style="display: block;" target="_blank" href="<?php echo U('Message/view?id='.$vo['msg_id']);?>"><div class="dropdown-messages-box">

                                            <div class="media-body">
                                                <small class="pull-right"></small>
                                                <strong><?php echo ($vo["nickname"]); ?></strong>
                                                <strong><?php echo ($vo["title"]); ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                	 <?php if($vo['addtime']): echo (date("Y-m-d H:i:s",$vo['addtime'])); else: endif; ?>
                                                </small>
                                            </div>

                                        </div></a>
                                    </li>
                                    
                                <li class="divider"></li><?php endforeach; endif; else: echo "" ;endif; ?>
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
    <link href="Admin/css/in/iviews-order.css" rel="stylesheet">
    <link href="Admin/css/in/stylesheet.css" rel="stylesheet">
    <script src="Admin/js/in/vue.js"></script>
    <link href="Admin/css/in/piezas_dentales.css" rel="stylesheet">
    <style>
        #tt_2,#tt_3,#tt_4{display: none}
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
        .control-span{
            font-weight: normal;
            font-size: 14px;
            color: #999;
        }
        .col-sm-label{
            font-weight: normal;
            font-size: 14px;
            color: #999;
            float: left;
        }

        [v-cloak] {
            display: none !important;
        }
        #tt_1,#tt_2,#tt_3,#tt_4 {
            border-top: 0;
            padding-top: 0px;
        }
    </style>
    <script>
       $(function(){
           $("[id^='t_']").click(function(){
               $("[id^='t_']").parent().removeClass("active");
               $(this).parent().addClass("active");

               $("[id^='tt_']").hide();
               $("#t"+$(this).attr("id")).show();
           });
       });
    </script>
	
	<link href="Admin/css/n.css" rel="stylesheet"  type="text/css" />
	<link href="Admin/css/in/iviews-order.css" rel="stylesheet"  type="text/css" />

    <!-- content begin -->
    <div class="wrapper wrapper-content" id="app">

        <!-- in+ dom -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <!-- title -->
                    <div class="ibox-title">
                        <h5>
                            <?php echo L('ORDER_MANAGE');?>
                            <small><?php echo L('VIEW');?>&nbsp;<?php echo ($info["order_sn"]); ?></small>
                        </h5>
                        <div class="ibox-button">
                            <?php if(($info['state'] > 60) && ($info['state'] < 110)): ?><a href="<?php echo U('Order/change?id='.$vo['order_id']);?>" class="btn btn-sm btn-primary confirm ajax-get"><?php echo L('TASK_CHANGE');?></a><?php endif; ?>
                            <?php if($info['state'] == 50): ?><a href="<?php echo U('Order/confirm?id='.$vo['order_id']);?>" class="btn btn-sm btn-primary confirm ajax-get"><?php echo L('TASK_CONFIRM');?></a><?php endif; ?>
                            <?php if(($info['state'] == 120 && $info['hasmaking'] == 1) or ($info['state'] == -1) or ($info['state'] == 70 && $info['hasmaking'] == 0 && $info['hasdesign'] == 1)): ?><a href="javascript:;" id="close" class="btn btn-primary btn-sm"><?php echo L('CLOSE_ORDER');?></a><?php endif; ?>
                            <?php if($info['state'] == 110): ?><a href="javascript:;" id="confirm_goods" class="btn btn-primary btn-sm"><?php echo L('CONFIRM_GOODS');?></a><?php endif; ?>
                            <a href="javascript:history.go(-1);" class="btn btn-primary btn-sm" type="button"><?php echo L('BACK');?></a>
                        </div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="javascript:;" id="t_1">基本信息</a></li>
                        <li><a href="javascript:;" id="t_2">资料&方案</a></li>
                        <li><a href="javascript:;" id="t_3">费用信息</a></li>
                        <li><a href="javascript:;" id="t_4">操作记录</a></li>
                    </ul>

                    <div class="wrapper wrapper-content" id="tt_1">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <!-- title -->
                                    <div class="ibox-content">
                                        <form  class="form-horizontal">
                                            <div class="iviews-order-form">
                                                <div class="form-group">
                                                <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('ORDER_STYPE');?></label>
                                                <div class="col-sm-1">
                                                    <p class="form-control-static"><?php echo ($info["dv2"]); ?></p>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="iviews-order-form">
                                                <div class="form-group">
                                                <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('SERVICE_NAME');?></label>
                                                <div class="col-sm-4">
                                                    <p class="form-control-static"><span class="control-span"><?php echo L('PROSCH');?>:</span> <?php if($info['hasdesign']): echo L('DESIGHOP'); endif; if($info['hasmaking']): ?>&nbsp;&nbsp;<?php echo L('MODELMAKE'); endif; ?></p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="form-control-static"><span class="control-span"><?php echo L('NORMALS');?>:</span> <?php if($ns): echo (l($ns)); endif; ?></p>
                                                </div>
                                                <label class="col-sm-2 col-sm-offset-1 control-label"></label>
                                                <div class="col-sm-4">
                                                    <p class="form-control-static"><span class="control-span"><?php echo L('OTHERS');?>:</span> <?php if($os): echo (l($os)); endif; ?></p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="form-control-static"><span class="control-span"><?php echo L('ORDER_UG');?>:</span> <?php if($info['isurgent']): echo L('YES');?>
                                                        <?php else: ?>
                                                        <?php echo L('NO'); endif; ?></p>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="iviews-order-form">
                                                <div class="form-group">
                                                <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('CUSTOMERINFO');?></label>
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('DEINFO');?>:</span>  <?php echo ($orderext["dername"]); ?> <?php echo ($orderext["deaddr"]); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('SHIPINFO');?>:</span> <?php echo ($orderext["shiprname"]); ?> <?php echo ($orderext["shipaddr"]); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('SHIPUNAME');?>:</span> <?php echo ($orderext["shipuname"]); ?></p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('SHIPTEL');?>:</span> <?php echo ($orderext["shiptel"]); ?></p>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('DOCINFO');?>:</span> <?php echo ($orderext["doctor"]); ?> <?php echo ($orderext["doctor_tel"]); ?></p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('DOCOSSINFO');?>:</span> <?php echo ($orderext["doctorass"]); ?> <?php echo ($orderext["doctorass_tel"]); ?></p>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('ADOCINFO');?>:</span> <?php echo ($orderext["doctor1"]); ?> <?php echo ($orderext["doctor1_tel"]); ?></p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('ADOCOSSINFO');?>:</span> <?php echo ($orderext["doctorass1"]); ?> <?php echo ($orderext["doctorass1_tel"]); ?></p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="iviews-order-form">
                                                <div class="form-group">
                                                <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('PAINFO');?></label>
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('MNAME');?>:</span> <?php echo ($info["pname"]); ?></p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('SEX');?>:</span> <?php if(($info["psex"]) == "1"): echo L('MAN'); else: if(($info["psex"]) == "2"): echo L('WOMAN'); else: echo L('SECRECY'); endif; endif; ?></p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('P_BR');?>:</span> <?php if($orderext['pebirth']): echo (date("Y-m-d H:i",$orderext['pebirth'])); else: ?>-<?php endif; ?></p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('AGE');?>:</span> <?php echo ($orderext["peage"]); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('PAZHUSHU');?>:</span><?php echo ($orderext1["pedesc"]); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('REPAIRBODY');?>:</span> <?php echo ($orderext1["xft"]); ?></p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('PERIOD');?>:</span> <?php echo ($orderext1["yzy"]); ?></p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('TOOTHLOOSE');?>:</span> <?php echo ($orderext1["sd"]); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('FIXTYPE');?>:</span> <?php echo ($orderext1["rt"]); ?></p>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('PLANOPTIME');?>:</span> <?php if($orderext1['surgerytime']): echo (date("Y-m-d H:i",$orderext1['surgerytime'])); else: ?>-<?php endif; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="iviews-order-form">
                                                <div class="form-group" style="overflow: hidden;">
                                                    <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('MISSTOOTH');?></label>
                                                    <div id="img_pz" class="col-md-offset-1 col-md-11">
                                                        <div id="pz_dentales">
                                                            <div class="d_sup1 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup18" value="valuable" id="sup1">
                                                                <label for="sup1"></label>
                                                            </div>
                                                            <div class="d_sup2 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup17" value="valuable" id="sup2">
                                                                <label for="sup2"></label>
                                                            </div>
                                                            <div class="d_sup3 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup16" value="valuable" id="sup3">
                                                                <label for="sup3"></label>
                                                            </div>
                                                            <div class="d_sup4 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup15" value="valuable" id="sup4">
                                                                <label for="sup4"></label>
                                                            </div>
                                                            <div class="d_sup5 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup14" value="valuable" id="sup5">
                                                                <label for="sup5"></label>
                                                            </div>
                                                            <div class="d_sup6 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup13" value="valuable" id="sup6">
                                                                <label for="sup6"></label>
                                                            </div>
                                                            <div class="d_sup7 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup12" value="valuable" id="sup7">
                                                                <label for="sup7"></label>
                                                            </div>
                                                            <div class="d_sup8 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup11" value="valuable" id="sup8">
                                                                <label for="sup8"></label>
                                                            </div>
                                                            <div class="d_sup9 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup21" value="valuable" id="sup9">
                                                                <label for="sup9"></label>
                                                            </div>
                                                            <div class="d_sup10 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup22" value="valuable" id="sup10">
                                                                <label for="sup10"></label>
                                                            </div>
                                                            <div class="d_sup11 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup23" value="valuable" id="sup11">
                                                                <label for="sup11"></label>
                                                            </div>
                                                            <div class="d_sup12 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup24" value="valuable" id="sup12">
                                                                <label for="sup12"></label>
                                                            </div>
                                                            <div class="d_sup13 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup25" value="valuable" id="sup13">
                                                                <label for="sup13"></label>
                                                            </div>
                                                            <div class="d_sup14 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup26" value="valuable" id="sup14">
                                                                <label for="sup14"></label>
                                                            </div>
                                                            <div class="d_sup15 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup27" value="valuable" id="sup15">
                                                                <label for="sup15"></label>
                                                            </div>
                                                            <div class="d_sup16 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup28" value="valuable" id="sup16">
                                                                <label for="sup16"></label>
                                                            </div>
                                                            <!--INFERIOR-->
                                                            <div class="d_inf1 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf48" value="valuable" id="inf1">
                                                                <label for="inf1"></label>
                                                            </div>
                                                            <div class="d_inf2 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf47" value="valuable" id="inf2">
                                                                <label for="inf2"></label>
                                                            </div>
                                                            <div class="d_inf3 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf46" value="valuable" id="inf3">
                                                                <label for="inf3"></label>
                                                            </div>
                                                            <div class="d_inf4 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf45" value="valuable" id="inf4">
                                                                <label for="inf4"></label>
                                                            </div>
                                                            <div class="d_inf5 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf44" value="valuable" id="inf5">
                                                                <label for="inf5"></label>
                                                            </div>
                                                            <div class="d_inf6 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf43" value="valuable" id="inf6">
                                                                <label for="inf6"></label>
                                                            </div>
                                                            <div class="d_inf7 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf42" value="valuable" id="inf7">
                                                                <label for="inf7"></label>
                                                            </div>
                                                            <div class="d_inf8 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf41" value="valuable" id="inf8">
                                                                <label for="inf8"></label>
                                                            </div>
                                                            <div class="d_inf9 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf31" value="valuable" id="inf9">
                                                                <label for="inf9"></label>
                                                            </div>
                                                            <div class="d_inf10 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf32" value="valuable" id="inf10">
                                                                <label for="inf10"></label>
                                                            </div>
                                                            <div class="d_inf11 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf33" value="valuable" id="inf11">
                                                                <label for="inf11"></label>
                                                            </div>
                                                            <div class="d_inf12 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf34" value="valuable" id="inf12">
                                                                <label for="inf12"></label>
                                                            </div>
                                                            <div class="d_inf13 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf35" value="valuable" id="inf13">
                                                                <label for="inf13"></label>
                                                            </div>
                                                            <div class="d_inf14 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf36" value="valuable" id="inf14">
                                                                <label for="inf14"></label>
                                                            </div>
                                                            <div class="d_inf15 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf37" value="valuable" id="inf15">
                                                                <label for="inf15"></label>
                                                            </div>
                                                            <div class="d_inf16 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf38" value="valuable" id="inf16">
                                                                <label for="inf16"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="overflow: hidden;">
                                                    <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('SEEDTOOTH');?></label>
                                                    <div id="img_pz_2" class="col-md-offset-1 col-md-11">
                                                        <div id="pz_dentales_2">
                                                            <div class="d_sup1 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup18" value="valuable" id="sup1_2">
                                                                <label for="sup1_2"></label>
                                                            </div>
                                                            <div class="d_sup2 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup17" value="valuable" id="sup2_2">
                                                                <label for="sup2_2"></label>
                                                            </div>
                                                            <div class="d_sup3 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup16" value="valuable" id="sup3_2">
                                                                <label for="sup3_2"></label>
                                                            </div>
                                                            <div class="d_sup4 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup15" value="valuable" id="sup4_2">
                                                                <label for="sup4_2"></label>
                                                            </div>
                                                            <div class="d_sup5 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup14" value="valuable" id="sup5_2">
                                                                <label for="sup5_2"></label>
                                                            </div>
                                                            <div class="d_sup6 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup13" value="valuable" id="sup6_2">
                                                                <label for="sup6_2"></label>
                                                            </div>
                                                            <div class="d_sup7 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup12" value="valuable" id="sup7_2">
                                                                <label for="sup7_2"></label>
                                                            </div>
                                                            <div class="d_sup8 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup11" value="valuable" id="sup8_2">
                                                                <label for="sup8_2"></label>
                                                            </div>
                                                            <div class="d_sup9 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup21" value="valuable" id="sup9_2">
                                                                <label for="sup9_2"></label>
                                                            </div>
                                                            <div class="d_sup10 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup22" value="valuable" id="sup10_2">
                                                                <label for="sup10_2"></label>
                                                            </div>
                                                            <div class="d_sup11 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup23" value="valuable" id="sup11_2">
                                                                <label for="sup11_2"></label>
                                                            </div>
                                                            <div class="d_sup12 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup24" value="valuable" id="sup12_2">
                                                                <label for="sup12_2"></label>
                                                            </div>
                                                            <div class="d_sup13 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup25" value="valuable" id="sup13_2">
                                                                <label for="sup13_2"></label>
                                                            </div>
                                                            <div class="d_sup14 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup26" value="valuable" id="sup14_2">
                                                                <label for="sup14_2"></label>
                                                            </div>
                                                            <div class="d_sup15 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup27" value="valuable" id="sup15_2">
                                                                <label for="sup15_2"></label>
                                                            </div>
                                                            <div class="d_sup16 diente">
                                                                <input type="checkbox" class="diente_sup" name="sup28" value="valuable" id="sup16_2">
                                                                <label for="sup16_2"></label>
                                                            </div>
                                                            <!--INFERIOR-->
                                                            <div class="d_inf1 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf48" value="valuable" id="inf1_2">
                                                                <label for="inf1_2"></label>
                                                            </div>
                                                            <div class="d_inf2 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf47" value="valuable" id="inf2_2">
                                                                <label for="inf2_2"></label>
                                                            </div>
                                                            <div class="d_inf3 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf46" value="valuable" id="inf3_2">
                                                                <label for="inf3_2"></label>
                                                            </div>
                                                            <div class="d_inf4 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf45" value="valuable" id="inf4_2">
                                                                <label for="inf4_2"></label>
                                                            </div>
                                                            <div class="d_inf5 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf44" value="valuable" id="inf5_2">
                                                                <label for="inf5_2"></label>
                                                            </div>
                                                            <div class="d_inf6 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf43" value="valuable" id="inf6_2">
                                                                <label for="inf6_2"></label>
                                                            </div>
                                                            <div class="d_inf7 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf42" value="valuable" id="inf7_2">
                                                                <label for="inf7_2"></label>
                                                            </div>
                                                            <div class="d_inf8 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf41" value="valuable" id="inf8_2">
                                                                <label for="inf8_2"></label>
                                                            </div>
                                                            <div class="d_inf9 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf31" value="valuable" id="inf9_2">
                                                                <label for="inf9_2"></label>
                                                            </div>
                                                            <div class="d_inf10 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf32" value="valuable" id="inf10_2">
                                                                <label for="inf10_2"></label>
                                                            </div>
                                                            <div class="d_inf11 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf33" value="valuable" id="inf11_2">
                                                                <label for="inf11_2"></label>
                                                            </div>
                                                            <div class="d_inf12 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf34" value="valuable" id="inf12_2">
                                                                <label for="inf12_2"></label>
                                                            </div>
                                                            <div class="d_inf13 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf35" value="valuable" id="inf13_2">
                                                                <label for="inf13_2"></label>
                                                            </div>
                                                            <div class="d_inf14 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf36" value="valuable" id="inf14_2">
                                                                <label for="inf14_2"></label>
                                                            </div>
                                                            <div class="d_inf15 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf37" value="valuable" id="inf15_2">
                                                                <label for="inf15_2"></label>
                                                            </div>
                                                            <div class="d_inf16 diente">
                                                                <input type="checkbox" class="diente_inf" name="inf38" value="valuable" id="inf16_2">
                                                                <label for="inf16_2"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group" style="overflow: hidden;">
                                                    <label class="col-sm-2 col-sm-offset-1 control-label"></label>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('ZZBRAND');?>:</span> <?php echo ($orderext1["surname"]); ?></p>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <p class="form-control-static"><span class="control-span"><?php echo L('OPTOOL');?>:</span> <?php echo ($orderext1["surname1"]); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="iviews-order-form">
                                                <div class="form-group">
                                                    <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('BLZL');?></label>
                                                    <div class="col-sm-9">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <p class="form-control-static"><span class="control-span"><?php echo L('KNMX');?>:</span> <?php echo ($orderext1["knmx"]); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <p class="form-control-static"><span class="control-span"><?php echo L('REMARKS');?>:</span><?php echo ($orderext1["note"]); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <p class="form-control-static"><span class="control-span"><?php echo L('HGDY');?>:</span> <?php if(($orderext1["print1"]) == "1"): echo L('YES'); else: echo L('NO'); endif; ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <p class="form-control-static"><span class="control-span"><?php echo L('MXDY');?>:</span> <?php if(($orderext1["print2"]) == "1"): echo L('YES'); else: echo L('NO'); endif; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wrapper wrapper-content" id="tt_2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <!-- title -->
                                    <div class="ibox-content">
                                        <div class="iviews-folder" id="drop-zone">

                                            <div class="form-group-cbct-file iviews-folder-button">
                                                上传文件夹
                                                <input type="file" name="filesToUpload[]" id="filesToUpload" multiple="multiple" accept="*.dcm" webkitdirectory="" directory="" />
                                            </div>

                                            <div class="iviews-folder-header clearfix">
                                                <div class="pull-left iviews-folder-header-nav">
                                                    <a href="javascript:void(0);" class="gotof">返回上一级</a>
                                                    <nav>
                                                    </nav>
                                                </div>
                                                <span class="pull-right">已全部加载,共<?php echo ($count); ?>个</span>
                                            </div>

                                            <div class="iviews-folder-bodyer">
                                                <table class="table table-hover" id="folderSee">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left" width="40%">文件名</th>
                                                            <th>文件类型</th>
                                                            <th>大小</th>
                                                            <th>上传日期</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        <!-- <tr>
                                                            <td>
                                                                <?php if($vo['path'] != ''): ?><span class="iviews-type-folder"><?php echo ($vo['path']); ?></span>
                                                                    <?php elseif($vo['ext'] == 'zip'): ?>
                                                                    <span class="iviews-type-zip"><?php echo ($vo['name']); ?></span>
                                                                    <?php elseif($vo['ftype'] == 'jpg'): ?>
                                                                    <span class="iviews-type-jpg"><?php echo ($vo['name']); ?></span>
                                                                    <?php else: ?>
                                                                    <span class="iviews-type-zip"><?php echo ($vo['name']); ?></span><?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo ($vo['ext']); ?>
                                                            </td>
                                                            <td><?php echo (format_bytes($vo['size'])); ?></td>
                                                            <td><?php echo (date('Y-m-d H:i',$vo['addtime'])); ?></td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                                <div class="clearfix" id="folderPages">
                                                    <div class="btn-group pull-right">
                                                        <button type="button" class="btn btn-white">
                                                            <i class="fa fa-chevron-left"></i>
                                                        </button>
                                                        <div class="pull-left">
                                                            <!-- <button class="btn btn-white">1</button>
                                                            <button class="btn btn-white  active">2</button>
                                                            <button class="btn btn-white">3</button>
                                                            <button class="btn btn-white">4</button> -->
                                                        </div>
                                                        <button type="button" class="btn btn-white">
                                                            <i class="fa fa-chevron-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wrapper wrapper-content" id="tt_3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <!-- title -->
                                    <div class="ibox-content">
                                        <table
                                                class="table table-center"
                                                style="text-align: center">
                                            <thead>

                                            <tr>
                                                <th style="width: 100px;text-align: left; padding-left: 10px"><?php echo L('FEE_NAME');?></th>
                                                <th style="width: 80px;text-align: left"><?php echo L('PAYMENT_METHOD');?></th>
                                                <th style="width: 80px;text-align: left"><?php echo L('PAYMENT_STATUS');?></th>
                                                <th style="width: 100px;text-align: left"><?php echo L('AMOUNT_PAYABLE');?></th>
                                                <th style="width: 80px;text-align: left"><?php echo L('AMOUNT_PAID');?></th>
                                                <th style="width: 80px;text-align: left"><?php echo L('PAY_CURRENCY');?></th>
                                                <th style="width: 150px;text-align: left"><?php echo L('ADD_TIME');?></th>
                                                <th style="width: 150px;text-align: left"><?php echo L('LAST_PAYMENTTIME');?></th>
                                                <th style="text-align: left"><?php echo L('REMARKS');?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($order_pay)): if(is_array($order_pay)): $i = 0; $__LIST__ = $order_pay;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                                    <td style="text-align: left;width: 100px;padding-left: 10px"><?php echo ($vo["feename"]); ?></td>
                                                    <td style="text-align: left">
                                                        <?php if($vo['paytype']==0): echo L('CASH_PAYMENT');?>
                                                            <?php else: ?>
                                                            <?php echo L('PAY_MONTHLY'); endif; ?>
                                                    </td>
                                                    <td style="text-align: left">
                                                        <?php if($vo['state']==0): echo L('UNPAID');?>
                                                            <?php else: ?>
                                                            <?php echo L('ALREADY_PAID'); endif; ?>
                                                    </td>
                                                    <td style="text-align: left"><?php echo ($vo["money"]); ?>/<?php echo ($vo["money1"]); ?></td>
                                                    <td style="text-align: left;"><?php echo ($vo["pay_money"]); ?></td>
                                                    <td style="text-align: left"><?php echo ($vo["currency"]); ?></td>
                                                    <td style="text-align: left">
                                                        <?php if($vo['addtime']): echo (date("Y-m-d H:i:s",$vo['addtime'])); else: ?>-<?php endif; ?>
                                                    </td>
                                                    <td style="text-align: left">
                                                        <?php if($vo['paytime']): echo (date("Y-m-d H:i:s",$vo['paytime'])); else: ?>-<?php endif; ?>
                                                    </td>
                                                    <td style="text-align: left"><?php echo ($vo["note"]); ?></td>
                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?> <?php else: ?>
                                                <td colspan="9" class="text-center table_nodata"><?php echo L('NOCONCENT');?></td><?php endif; ?>
                                            </tbody>
                                        </table></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wrapper wrapper-content" id="tt_4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <!-- title -->
                                    <div class="ibox-content">
                                        <table
                                                class="table table-center"
                                                style="text-align: center">
                                            <thead>

                                            <tr>
                                                <th style="width: 160px; text-align: left;padding-left: 10px"><?php echo L('ORDER_STATUS');?></th>
                                                <th style="width: 80px"><?php echo L('OPERATION_USER');?></th>
                                                <th style="width: 160px"><?php echo L('OPERATION_TIME');?></th>
                                                <th style="text-align: left"><?php echo L('OPERATION_NOTE');?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($order_log)): if(is_array($order_log)): $i = 0; $__LIST__ = $order_log;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                                    <td style="width: 160px; text-align: left;padding-left: 10px"><?php echo (l($vo["str_state"])); ?></td>
                                                    <td style="width: 80px"><?php echo ($vo["nickname"]); ?></td>

                                                    <td style="width: 160px">
                                                        <?php if($vo['addtime']): echo (date("Y-m-d H:i",$vo['addtime'])); else: ?>-<?php endif; ?>
                                                    </td>
                                                    <td style="text-align: left"><?php echo ($vo["note"]); ?></td>
                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?> <?php else: ?>
                                                <td colspan="4" class="text-center table_nodata"><?php echo L('NOCONCENT');?></td><?php endif; ?>
                                            </tbody>
                                        </table></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="iviews-order-mask" v-cloak v-if="step6.loadStatus">

                <div class="iviews-order-load">
                    <span v-cloak :class="{ 'load': step6.flagStatus , 'success': !step6.flagStatus }">{{ step6.flagStatus ? '正在上传' : '上传结束' }}</span>
                    <a href="javascript:void(0);" class="iv-icon-close"></a>

                    <strong v-if="step6.flagStatus" v-cloak>正在上传: {{ step6.folder[0].file[step6.folder[0].file.length-1].name }}</strong>
                    <strong v-if="!step6.flagStatus">上传成功</strong>

                    <div class="folder-list">
                        <div class="folder-size" v-cloak>大小: {{ step6.folder[0].file[step6.folder[0].file.length-1].size | sizeFilter }}</div>
                        <div class="folder-progress" v-cloak>已上传:
                            <small>{{ step6.folder[0].file.length }}</small>/{{ step6.folder[0].length }}</div>
                    </div>
                    <div class="tips">提示: 请勿关闭页面以免影响文件上传</div>

                </div>

            </div>

            <div class="iviews-order-mask" v-cloak v-if="step6.fileStatus">

                <div class="iviews-order-folder">
                    <a href="javascript:void(0);" class="iv-icon-close"></a>

                    <div class="iviews-order-folder-header">
                        <span class="folder-name" v-cloak>{{ step6.folder[0].id }}</span>
                        <span class="folder-length" v-cloak>共{{ step6.folder[0].length }}个文件</span>
                        <span class="folder-total" v-cloak>{{ step6.folder[0].total | sizeFilter }} </span>
                        <a href="javascript:void(0)"></a>
                    </div>

                    <div class="full-height-scroll" style="height: 480px; overflow-y: scroll">
                        <table class="table table-striped table-hover">
                            <tbody>
                            <tr>
                                <td class="folder-name"><?php echo L('FILENAME');?></td>
                                <td class="folder-time"><?php echo L('UPLOADTIME');?></td>
                                <td class="folder-type"><?php echo L('FILETYPE');?></td>
                                <td class="folder-size"><?php echo L('FILESIZE');?></td>
                            </tr>
                            <tr v-for=" (item,$index) in step6.folder[0].file ">
                                <td class="folder-name" v-cloak>{{ item.name }}</td>
                                <td class="folder-time" v-cloak>{{ item.time }}</td>
                                <td class="folder-type" v-cloak>{{ item.type }}</td>
                                <td class="folder-size" v-cloak>{{ item.size | sizeFilter }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>


    </div>
    <!-- content end -->
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

    <script>
        var error_box = $("#errorModal");
        $(function () {
            var $tooh1 =  "<?php echo ($orderext1['toothposition']); ?>";
            var $tooh2 =  "<?php echo ($orderext1['toothposition1']); ?>";
            var arr1 = [];
            var arr2 = [];
            if($tooh1 !=''){
                arr1 = $tooh1.split(',');
                for(var i=0;i<arr1.length;i++){
                    $('#pz_dentales [name="sup'+arr1[i]+'"]').prop('checked',true);
                    $('#pz_dentales [name="inf'+arr1[i]+'"]').prop('checked',true);
                }
            }
            if($tooh2 !=''){
                arr2 = $tooh2.split(',');
                for(var i=0;i<arr2.length;i++){
                    $('#pz_dentales_2 [name="sup'+arr2[i]+'"]').prop('checked',true);
                    $('#pz_dentales_2 [name="inf'+arr2[i]+'"]').prop('checked',true);
                }
            }
            $('body').on('click','.iviews-order-load > a',function(){
                $('body').removeClass('hasMask');
                $('#page-wrapper > .border-bottom').eq(0).removeClass('hasMask');
                $('#page-wrapper > .wrapper').eq(0).removeClass('hasMask');
                order.step6.loadStatus = false;
            })

            $('body').on('click', '.iviews-order-folder > a', function () {
                $('body').removeClass('hasMask');
                $('#page-wrapper > .border-bottom').eq(0).removeClass('hasMask');
                $('#page-wrapper > .wrapper').eq(0).removeClass('hasMask');
                order.step6.fileStatus = false;
            })
            $('.diente_sup').prop('disabled',true);
            $('.diente_inf').prop('disabled',true);
            $("#confirm_goods").click(function () {
                    var id="<?php echo ($info["order_id"]); ?>";
                    var url = "<?php echo U('Order/confirm_goods');?>";
                    var param = $("#send_form").serialize();
                    $.ajax({
                        url: base.url + url ,
                        type: 'POST' ,
                        data: {'id':id},
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
            });
            $("#close").click(function () {
                var id="<?php echo ($info["order_id"]); ?>";
                var url = "<?php echo U('Order/close');?>";
                $.ajax({
                    url: base.url + url ,
                    type: 'POST' ,
                    data: {'id':id},
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
            });

            function handleDragOver(evt) {
                evt.stopPropagation();
                evt.preventDefault();
                evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
            }
            var dropZone = document.getElementById('drop-zone');
            // var dropFile = document.getElementById('filesToUpload');
            dropZone.addEventListener('dragover', handleDragOver, false);
            
            function handleFileSelect(evt) {
                evt.stopPropagation();
                evt.preventDefault();
                var files = [], folder = '',
                    items = evt.dataTransfer.items;
            
                order.step6.loadStatus = true;
            
                if ( order.step6.folder.length == 1 ) {
                    // alert('CBCT只允许上传一个文件夹');
                    order.step6.loadStatus = false;
                    $.scojs_message("<?php echo L('CBCT_ONLY_ONE');?>", $.scojs_message.TYPE_ERROR);
                    return false;
                }
            
                function folderRead(entry,ordername) {
                    var folderObj = { name: entry.name, total: 0, id: ordername, file: [] }
            
                    entry.createReader().readEntries(function (entries) {
                        folderObj.length = entries.length;
                        // let total = 0;
                        for (var i = 0; i < entries.length; i++) {
                            var entrys = entries[i];
            
                            if (entrys.isFile) {
                                entrys.file(function (file) {
            
                                    // total += file.size;
                                    var fileObj = { name: file.name, size: file.size, type: file.type, time: 'ss'}
                                    // order.step6.loadStatus = true;
                                    // 打开状态层
                                    var fd = new FormData();
                                    fd.append('mypic', file);
                                    var url = "<?php echo U('Dentist/Order/uploadFile',array('code'=>$code,'sn'=>$sn,'type'=>'cbct'));?>";
                                    /* var path = files[x].webkitRelativePath.split('/');
                                     path.pop();
                                     var filename = path.toString().replace(/,/g,'/');*/
            
                                    $.ajax({
                                        url: url,
                                        method: 'post',
                                        contentType: false, // 注意这里应设为false
                                        processData: false,
                                        cache: false,
                                        async: true,
                                        data: fd,
                                        success: function(res) {
                                            if ( typeof res == 'string' ) {
                                                res = JSON.parse(res);
                                            }
            
                                            if (!res) return false;
                                            fileObj.time = res.msg.addtime;
                                            fileObj.size = res.msg.size;
                                            fileObj.type = res.msg.ext;
                                            folderObj.total += res.msg.size;
                                            order.step6.flagStatus = true;
                                            folderObj.file.push(fileObj)
                                            // total +=res.size;
                                            if ( folderObj.length == folderObj.file.length ) {
                                                order.step6.flagStatus = false;
                                                // order.step6.loadStatus = false;
                                            }
                                            $.full.open();
                                        },
                                        error: function(error) {
                                            console.log(error);
                                        }
                                    })
                                    // folderObj.total =  format_bytes(total);
                                    // folderObj.total = total;
                                })
                            } else {
                                folder = entrys.name;
                            }
                        }
            
                    });
                    order.step6.folder.push(folderObj)
                }
                for (var i = 0; i < items.length; i++) {
                    var entry = items[i].webkitGetAsEntry();
                    if (!entry) {
                        return;
                    }
                    if (entry.isFile) {
                        $.scojs_message("<?php echo L('PFUPLOADFILE');?>", $.scojs_message.TYPE_ERROR);
                    } else {
                        folderRead(entry, '<?php echo ($sn); ?>');
                    }
                }
            }
            dropZone.addEventListener('drop', handleFileSelect, false);
            
            $('#filesToUpload').on('change', function(ev, ordername){
            
                order.step6.loadStatus = true;
            
                if (order.step6.folder.length == 1) {
                    order.step6.loadStatus = false;
                    $.scojs_message("<?php echo L('CBCT_ONLY_ONE');?>", $.scojs_message.TYPE_ERROR);
                    return false;
                }
            
                ordername = '<?php echo ($sn); ?>'
            
                var folderObj = { name: '', id: ordername, total: 0, file: [], length: ev.target.files.length }
            
                if ( ev.target.files.length >= 1 ) {
                    var files = ev.target.files;
                    // var name = files[0].webkitRelativePath.split('/')[0];
            
                    folderObj.name = name;
            
                    for ( x in files ) {
                        if ( files[x].size ) {
                            let pathArr = files[x].webkitRelativePath.split('/');
                            pathArr.pop();
                            if ( files[x].size != 'undefined' && files[x].size >= 0 ) {
                                //total += files[x].size;
                                let fileObj = { path: pathArr.toString(), name: files[x].name, size: files[x].size, type: files[x].type, time: '' }
                                // var fileObj = { name: files[x].name, size: files[x].size, type: files[x].type, time: 'ss' }
                                var fd = new FormData();
                                fd.append('mypic', files[x]);
                                // fd.append('filename', 'ocdf/sdafsd');
                                var url1 = "<?php echo U('Dentist/Order/uploadFile',array('code'=>$code,'sn'=>$info['order_sn'],'type'=>'pro','vid'=>$vid,'oid'=>$info['order_id']));?>";
                                $.ajax({
            
                                    url: url1+'&path='+pathArr.toString(),
                                    method: 'post',
                                    contentType: false, // 注意这里应设为false
                                    processData: false,
                                    cache: false,
                                    async: true,
                                    data: fd,
                                    success: function (res) {
                                        // console.log(res);
                                        // console.log(res.size);
                                        if (typeof res == 'string') {
                                            res = JSON.parse(res);
                                        }
                                        var data = res;
                                        if (!data || data == 'false') return false;
                                        fileObj.time = data.msg.addtime;
                                        fileObj.size = data.msg.size;
                                        fileObj.type = data.msg.ext;
                                        order.step6.flagStatus = true;
                                        folderObj.file.push(fileObj)
                                        folderObj.total += data.msg.size;
                                        if (folderObj.length == folderObj.file.length) {
                                            order.step6.flagStatus = false;
                                            // order.step6.loadStatus = false;
                                        }
            
                                        $('.iviews-order-mask').css({
                                            'position': 'fixed',
                                            'width': $(window).width(),
                                            'height': $(window).height(),
                                            'left': -($('.navbar-default').width() + 15),
                                            'top': -$('#page-wrapper > .border-bottom').eq(0).height()
                                        })
                                        $('body').addClass('hasMask');
                                        $('#page-wrapper > .border-bottom').eq(0).addClass('hasMask');
                                        $('#page-wrapper > .wrapper').eq(0).addClass('hasMask');
                                    },
                                    error: function (error) {
                                        console.log(error);
                                    }
                                })
                                // folderObj.total = format_bytes(total);
                            }
                        }
                    }
                    order.step6.folder.push(folderObj)
            
                } else {
                    order.step6.loadStatus = false;
                    $.scojs_message('<?php echo L("MISC");?>', $.scojs_message.TYPE_ERROR);
                }
            
            })

            // for 数据
            // url con =   "<?php echo U('Order/file_info');?>"+'&pid=0&limit=0'
            var $oid         =   "<?php echo ($info["order_id"]); ?>" ;
            // var $oid         =   111;
            var $path_url    =   "<?php echo U('Order/file_info');?>",
                $table       =   $('#folderSee').find('tbody'),
                $tr          =   '',
                $page        =   '';
        
            var $navs = $('.iviews-folder-header-nav');
            
            function getFolder(url) {
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function (res) {
                        console.log(res);
                        $('#folderSee').attr('data-pid',res.pid);

                        if ( res.count == 0 ) {
                            $.scojs_message("这是个空文件夹", $.scojs_message.TYPE_ERROR);
                            return false;
                        }

                        for (var i = 0; i < res.files.length; i++) {
                            var $file = res.files[i],
                                $ext = null,
                                $name = null;
                            if ($file.ext) {
                                $name = $file.name;
                                if ($file.ext == 'zip' || $file.ext == 'rar') {
                                    $ext = 'zip';
                                } else {
                                    $ext = 'jpg';
                                }

                            } else {
                                $name = $file.path;
                                $ext = 'folder';
                            }
                            // $tr += '<tr><td>' + $file.size + '</td><td>' + $file.addtime + '</td></tr>'
                            $tr += '<tr data-pid="' + $file.fid + '" data-type="' + $ext + '"><td><span class="iviews-type-' + $ext + '"></span>' + $name + '</td>' +
                                '   <td>' + $ext + '</td>' +
                                '   <td>' + $file.size + '</td>' +
                                '   <td>' + $file.addtime + '</td></tr>';
                        }
                        
                        for (var k =1; k <= res.pages; k++ ) {
                            if ( k == (parseInt(res.limit) + 1) ) {
                                $page += '<button class="btn btn-white active">' + k + '</button>';
                            } else {
                                $page += '<button class="btn btn-white">'+ k +'</button>';
                            }
                        }
                        

                        $table.empty().append($tr);
                        $('#folderPages .pull-left').empty().append($page);
                        $tr = '';
                        $page = '';
                        
                        // 分页状态
                        if ($('#folderPages .pull-left').find('.active').text() == 1) {
                            $('.fa-chevron-left').parent().prop('disabled', true);
                            $('.fa-chevron-right').parent().prop('disabled', false);
                        } else if ($('#folderPages .pull-left').find('.active').text() == res.pages) {
                            $('.fa-chevron-right').parent().prop('disabled', true);
                            $('.fa-chevron-left').parent().prop('disabled', false);
                        } else {
                            $('.fa-chevron-right , .fa-chevron-left').parent().prop('disabled', false);
                        }

                        // 面包屑导航
                        if ( $('#folderSee').attr('data-pid') == 0 ) {
                            $navs.find('a').hide();
                            $navs.children('nav').css('margin-left','-20px');
                            $navs.children('nav').empty().append('<span data-pid="'+ res.pid +'">'+res.sn+'</span>');
                        } else {
                            $navs.find('a').show();
                            $navs.children('nav').css('margin-left', '0px');
                        }
                        
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            }
            
            // 初次请求
            getFolder($path_url+'&oid='+$oid)

            // 面包屑导航
            $navs.on('click','nav > a',function(){
                
                $(this).nextAll().remove();
                var $pid = $(this).attr('data-pid');
                 $navs.find('nav > a').last().contents().unwrap().wrap('<span data-pid="' + $pid + '"><span>');
                if ( $(this).attr('data-pid') && $(this).attr('data-pid') == 0 ) {
                    getFolder($path_url + '&oid=' + $oid)
                } else {
                    getFolder($path_url + '&oid=' + $oid + '&pid=' + $(this).attr('data-pid') + '&limit=0');
                }
            })

            $navs.on('click', '.gotof', function(){
                var $pid = $navs.find('nav').find('a').last().attr('data-pid');
                $navs.find('nav').find('a').last().nextAll().remove();
                getFolder($path_url + '&oid=' + $oid + '&pid=' + $pid + '&limit=0');
            })

            // 点击进入下一级
            $('#folderSee').on('click','tbody > tr',function(){
                var $self = $(this);
                
                if ( $self.attr('data-type') && $self.attr('data-type') == 'folder' ) {
                    getFolder($path_url+'&oid='+$oid+'&pid='+$self.attr('data-pid')+'&limit=0');
                    var $pid = $navs.find('nav > span').attr('data-pid');
                    $navs.find('nav > span').contents().unwrap().wrap('<a data-pid="'+$pid+'"><a>');
                    $navs.find('nav').append('<span data-pid="'+$self.attr('data-pid')+'">'+$self.find('td').eq(0).text()+'</span>')
                }
            })

            // 分页
            var $pages = $('#folderPages');
            $pages.on('click','.pull-left > button', function(){
                var $self = $(this);
                if ( !$self.hasClass('active') ) {
                    getFolder($path_url + '&oid=' + $oid + '&pid=' + $('#folderSee').attr('data-pid') + '&limit=' + ($self.text() - 1));
                }
            })

            $pages.find('.fa-chevron-right').parent().on('click', function(){
                var $text = $pages.find('.active').text();
                getFolder($path_url + '&oid=' + $oid + '&pid=' + $('#folderSee').attr('data-pid') + '&limit=' + $text);
            })

            $pages.find('.fa-chevron-left').parent().on('click', function () {
                var $text = $pages.find('.active').prev().text();
                getFolder($path_url + '&oid=' + $oid + '&pid=' + $('#folderSee').attr('data-pid') + '&limit=' + ($text-1));
            })

        });

        var order = new Vue({
            el: '#app',
            data () {
                return {
                    step6: {

                        folder: [] ,
                        fileStatus: false,
                        flagStatus: false,
                        loadStatus: false,

                    },
                }
            },
            updated () {
                $('.full-height-scroll').slimscroll({
                    height: '480px'
                })

                if(order.step6.loadStatus || order.step6.fileStatus) {
                    $('.iviews-order-mask').css({
                        'position': 'fixed',
                        'width': $(window).width(),
                        'height': $(window).height(),
                        'left': -($('.navbar-default').width() + 15),
                        'top': -$('#page-wrapper > .border-bottom').eq(0).height()
                    })
                    $('body').addClass('hasMask');
                    $('#page-wrapper > .border-bottom').eq(0).addClass('hasMask');
                    $('#page-wrapper > .wrapper').eq(0).addClass('hasMask');

                    $.full.open();
                } else {
                    $('.iviews-order-mask').attr('style','');
                    $('body').removeClass('hasMask');
                    $('#page-wrapper > .border-bottom').eq(0).removeClass('hasMask');
                    $('#page-wrapper > .wrapper').eq(0).removeClass('hasMask');

                    $.full.close();
                }
            },
            filters: {
                sizeFilter (val) {
                    var $units =   ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
                    for (var $i =0; val >= 1024 && $i < 5; $i++) val /= 1024;
                    return  val.toFixed(2) + $units[$i];
                },
            },
            methods: {
                step6FolderDel(index) {
                    delete_file(index);
                },
                step6FolderSee() {
                    this.step6.fileStatus = true;
                }
            }
        });

        function delete_file(index){
            var $res = confirm('确定删除吗');
            if($res){
                $.get("<?php echo U('Order/delete_file?sn='.$sn);?>",function(data){
                    if(data.done){
                        order.step6.folder.splice(index,1);
                        $("#filesToUpload").val('');
                    }else{
                        $.scojs_message(data.msg, $.scojs_message.TYPE_ERROR);
                    }
                });
            }
        }

    </script>

            </div>
        </div>
    </div>
    
</body>

</html>