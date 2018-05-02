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
                            <a href="<?php echo ($_url_); ?>&lang=zh" class="nav-language-cn">
                                <span><?php echo L('ZH_CN');?></span>
                            </a>
                            <a href="<?php echo ($_url_); ?>&lang=en" class="nav-language-en">
                                <span><?php echo L('EN_US');?></span>
                            </a>
                        </div>
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
	
	<link href="Admin/css/n.css" rel="stylesheet"  type="text/css" />
	<link href="Admin/css/in/iviews-order.css" rel="stylesheet"  type="text/css" />

    <!-- content begin -->
    <div class="wrapper wrapper-content">

        <!-- in+ dom -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <!-- title -->
                    <div class="ibox-title">
                        <h5>
                            <?php echo L('PLATORDER');?>
                            <small><?php echo L('VIEW');?></small>
                        </h5>
                        <div class="ibox-button">
                            <a href="javascript:history.go(-1);" class="btn btn-primary btn-sm" type="button"><?php echo L('BACK');?></a>
                        </div>
                    </div>
                    <!-- content --><div class="row">
                    <div class="col-sm-12">
                    <div class="iviews-order">
                    <div class="iviews-order-content iviews-order-step7">

                                <div class="iviews-order-form">
                                    <form  class="form-horizontal">

                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('ORDER_STYPE');?></label>
                                            <div class="col-sm-1">
                                                <p class="form-control-static"><?php echo ($info["dv2"]); ?></p>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('SERVICE_NAME');?></label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><?php echo L('PROSCH');?>: <?php if($info['hasdesign']): echo L('DESIGHOP'); endif; if($info['hasmaking']): ?>&nbsp;&nbsp;<?php echo L('MODELMAKE'); endif; ?></p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><?php echo L('NORMALS');?>: <?php if($ns): echo (l($ns)); endif; ?></p>
                                            </div>
                                            <label class="col-sm-2 col-sm-offset-1 control-label"></label>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><?php echo L('OTHERS');?>: <?php if($os): echo (l($os)); endif; ?></p>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="form-control-static"><?php echo L('ORDER_UG');?>: <?php if($info['isurgent']): echo L('YES');?>
                                                    <?php else: ?>
                                                    <?php echo L('NO'); endif; ?></p>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('CUSTOMERINFO');?></label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <p class="form-control-static"><?php echo L('DEINFO');?>:  <?php echo ($orderext["dername"]); ?> <?php echo ($orderext["deaddr"]); ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <p class="form-control-static"><?php echo L('SHIPINFO');?>: <?php echo ($orderext["shiprname"]); ?> <?php echo ($orderext["shipaddr"]); ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('SHIPUNAME');?>: <?php echo ($orderext["shipuname"]); ?></p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('SHIPTEL');?>: <?php echo ($orderext["shiptel"]); ?></p>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('DOCINFO');?>: <?php echo ($orderext["doctor"]); ?> <?php echo ($orderext["doctor_tel"]); ?></p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('DOCOSSINFO');?>: <?php echo ($orderext["doctorass"]); ?> <?php echo ($orderext["doctorass_tel"]); ?></p>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('ADOCINFO');?>: <?php echo ($orderext["doctor1"]); ?> <?php echo ($orderext["doctor1_tel"]); ?></p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('ADOCOSSINFO');?>: <?php echo ($orderext["doctorass1"]); ?> <?php echo ($orderext["doctorass1_tel"]); ?></p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('PAINFO');?></label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('MNAME');?>: <?php echo ($info["pname"]); ?></p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('SEX');?>: <?php if(($info["psex"]) == "1"): echo L('MAN'); else: if(($info["psex"]) == "2"): echo L('WOMAN'); else: echo L('SECRECY'); endif; endif; ?></p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('P_BR');?>: <?php if($orderext['pebirth']): echo (date("Y-m-d H:i",$orderext['pebirth'])); else: ?>-<?php endif; ?></p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('AGE');?>: <?php echo ($orderext["peage"]); ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <p class="form-control-static"><?php echo L('PAZHUSHU');?>:<?php echo ($orderext1["pedesc"]); ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                    	<p class="form-control-static"><?php echo L('JWBS');?>:<?php echo ($orderext1["pehistory"]); ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('REPAIRBODY');?>: <?php echo ($orderext1["xft"]); ?></p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('PERIOD');?>: <?php echo ($orderext1["yzy"]); ?></p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('TOOTHLOOSE');?>: <?php echo ($orderext1["sd"]); ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('FIXTYPE');?>: <?php echo ($orderext1["rt"]); ?></p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <p class="form-control-static"><?php echo L('PLANOPTIME');?>: <?php if($orderext1['surgerytime']): echo (date("Y-m-d H:i",$orderext1['surgerytime'])); else: ?>-<?php endif; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('YWBJ');?></label>
                                            <div class="col-sm-9">
                                                <div class="row iviews-yawei">
                                                    <div class="col-sm-4">
                                                        <img src="" alt="">
                                                        <?php if(is_array($t)): $i = 0; $__LIST__ = $t;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$node): $mod = ($i % 2 );++$i;?><input class="auth_rules rules_all" disabled="disabled" <?php if(($node["h"]) == "1"): ?>checked="checked"<?php endif; ?> type="checkbox"><?php echo ($node["value"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                                                        <span><?php echo L('QSYWBJ');?></span>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <img src="" alt="">
                                                         <?php if(is_array($t1)): $i = 0; $__LIST__ = $t1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$node): $mod = ($i % 2 );++$i;?><input class="auth_rules rules_all" disabled="disabled" <?php if(($node["h"]) == "1"): ?>checked="checked"<?php endif; ?> type="checkbox"><?php echo ($node["value"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                                                        <span><?php echo L('NZYWBJ');?></span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <p class="form-control-static"><?php echo L('ZZBRAND');?>: <?php echo ($orderext1["surgerysystem"]); ?></p>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p class="form-control-static"><?php echo L('OPTOOL');?>: <?php echo ($orderext1["surgerytool"]); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('BLZL');?></label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                    <label class="col-sm-1 control-label"><?php echo L('KNMX');?>:</label>
                                                    <div class="col-sm-11">
                                                        <p class="form-control-static"><?php echo ($orderext1["knmx"]); ?></p>
                                                    </div>
                                                </div>
                                                <div class="row iviews-cbct">
                                                    <label class="col-sm-1 control-label"> <?php echo L('CBCT');?>:</label>
                                                    <div class="col-sm-11">
                                                        <img src="" alt="">
                                                    </div>
                                                </div>
                                                <div class="row iviews-cbct">
                                                    <label class="col-sm-1 control-label"> <?php echo L('KNZP');?>:</label>
                                                    <div class="col-sm-3">
                                                        <img src="<?php echo ($orderext1["pic1"]); ?>" alt="">
                                                    </div>
                                                    <label class="col-sm-1 control-label"> <?php echo L('MBZP');?>:</label>
                                                    <div class="col-sm-3">
                                                        <img src="<?php echo ($orderext1["pic2"]); ?>" alt="">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-1 control-label"> <?php echo L('HGDY');?>:</label>
                                                    <div class="col-sm-1">
                                                        <p class="form-control-static"><?php if(($orderext1["print1"]) == "1"): echo L('YES'); else: echo L('NO'); endif; ?></p>
                                                    </div>
                                                    <label class="col-sm-1 control-label"> <?php echo L('MXDY');?>:</label>
                                                    <div class="col-sm-1">
                                                        <p class="form-control-static"><?php if(($orderext1["print2"]) == "1"): echo L('YES'); else: echo L('NO'); endif; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="wrapper wrapper-content">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="ibox float-e-margins">
                                                        <!-- title -->
                                                        <div class="ibox-title">
                                                            <h5><?php echo L('COST_INFORMATION');?></h5>
                                                        </div>
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

                                        <div class="wrapper wrapper-content">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="ibox float-e-margins">
                                                        <!-- title -->
                                                        <div class="ibox-title">
                                                            <h5><?php echo L('OPERATION_RECORD');?></h5>
                                                        </div>
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

                                    </form>
                                </div>

                            </div></div></div></div>
                </div>
            </div>
        </div>

    </div>
    <!-- content end -->

            </div>
        </div>
    </div>
     <script type="text/javascript">
        //导航高亮
        highlight_subnav("<?php echo U('Tag/index');?>");
    </script> 
</body>

</html>