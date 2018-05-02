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
                                                	 <?php if($vo['addtime']): echo (date("Y-m-d H:i:s",$vo['addtime'])); else: ?>-<?php endif; ?>
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
                
    <!--编辑器-->
    <script src="Admin/jsnew/ckeditor/ckeditor.js"></script>
    <script src="Admin/jsnew/ckeditor/adapters/jquery.js"></script>
    <!--上传-->
    <script src="Admin/jsnew/all.fine-uploader/all.fine-uploader.min.js"></script>
    <link href="Admin/jsnew/all.fine-uploader/fine-uploader-gallery.min.css" rel="stylesheet"/>
    <link href="Admin/jsnew/all.fine-uploader/fine-uploader-new.min.css" rel="stylesheet"/>
    <!--验正-->
    <script src='Admin/jsnew/jquery.validate.min.js' type='text/javascript'></script>
    <!--时间插件-->
    <script src='Admin/jsnew/jquery.datetimepicker.full.js' type='text/javascript'></script>
    <link href="Admin/css/jquery.datetimepicker.css" rel="stylesheet"  type="text/css" />
    <script src="Admin/js/in/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="Admin/js/in/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="Admin/js/in/iviews.extend.js"></script>
    <link href="Admin/css/n.css" rel="stylesheet"  type="text/css" />

    <link href="Admin/css/in/iviews-order.css" rel="stylesheet">
    <link href="Admin/css/in/piezas_dentales.css" rel="stylesheet">
    <!-- plugin -->
    <link href="Admin/css/in/plugins/iCheck/custom.css" rel="stylesheet">

    <link href="Admin/css/in/iviews-order.css" rel="stylesheet">

    <script src="Admin/jsnew/jquery.form.js" type="text/javascript"></script>

    <!--抓取局部截图-->
    <script src="Admin/js/in/plugins/html2canvas/html2canvas.js"></script>
    <!--数据渲染模板-->
    <script src="Admin/js/in/vue.js"></script>
    
    <link href="Admin/css/in/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="Admin/css/in/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">

    <link href="Admin/css/in/stylesheet.css" rel="stylesheet">
    <link href="Admin/css/in/iviews-order.css" rel="stylesheet">

    <link href="Admin/css/in/piezas_dentales.css" rel="stylesheet">
    <style>
        #tt_3,#tt_2,#tt_4,#tt_5,#tt_6{display: none}
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
        .iviews-order-load > a {
            position: absolute;
            right: 0;
            top: 0;
        }
        [v-cloak] {
            display: none !important;
        }

        body.hasMask { overflow: hidden; height: 100%; }
        #page-wrapper > .border-bottom { position: relative; z-index: 1; }
        #page-wrapper > .wrapper { position: relative; z-index: 2; }
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
        #name4 > div { position: relative; }
        #name4 > div > ul { position: absolute; z-index: 11; top: 34px; left: 15px; max-height: 160px; overflow: auto; right: 15px; border: solid #e5e6e7; border-width: 0 1px 1px 1px; background: #fff; }
        #name4 > div > ul li { height: 32px; line-height: 32px;  padding: 0 15px; transition: all .3s; cursor: pointer; }
        #name4 > div > ul li:hover { color: #1ab394; background: #f7f7f7; }
        .order_amount em { display: inline-block; width: 24px; text-align: center; font-style: normal; }
    </style>
    <script>
        $(function(){
            $("[name='birthday']").datetimepicker({
                step:10,
                lang:'ch',
                timepicker:false,
                format:'Y/m/d',
                onGenerate: function(ct,$i){
                    // console.log($i[0].value);
                    order.step4.patient.birthday  = $i[0].value;
                    setage();
                }
            });
            $("[name='surgery_time']").datetimepicker({
                step:10,
                lang:'ch',
                timepicker:true,
                format:'Y/m/d H:i',
                onGenerate: function (ct, $i) {
                    // console.log($i[0].value);
                    order.step4.date = $i[0].value;
                }
            });
        });
        /*根据出生日期算出年龄*/
        function setage(){
            var returnAge;
            var $time = $("[name='birthday']").val();
            if($time == '' || $time ==undefined  || $time == null  ){
                return false;
            }
            var strBirthdayArr=$time.split("/");
            var birthYear = strBirthdayArr[0];
            var birthMonth = strBirthdayArr[1];
            var birthDay = strBirthdayArr[2];

            var d = new Date();
            var nowYear = d.getFullYear();
            var nowMonth = d.getMonth() + 1;
            var nowDay = d.getDate();

            if (nowYear == birthYear) {
                returnAge = '';//同年 则为0岁
            }else {
                var ageDiff = nowYear - birthYear; //年之差
                if (ageDiff > 0) {
                    if (nowMonth == birthMonth) {
                        var dayDiff = nowDay - birthDay;//日之差
                        if (dayDiff < 0) {
                            returnAge = ageDiff - 1;
                        }else {
                            returnAge = ageDiff;
                        }
                    } else {
                        var monthDiff = nowMonth - birthMonth;//月之差
                        if (monthDiff < 0) {
                            returnAge = ageDiff - 1;
                        }else {
                            returnAge = ageDiff;
                        }
                    }
                }else {
                    returnAge = '';//返回-1 表示出生日期输入错误 晚于今天
                }
            }
            if(returnAge == 0){
                returnAge = 0;
            }
            $("#age").html(returnAge);
            $("input[name='age']").val(returnAge);
            order.step4.patient.age = returnAge;
        }

    </script>
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
                            <small><?php echo L('ADD');?> <?php echo ($sn); ?></small>
                        </h5>
                        <div class="ibox-button">
                            <a href="javascript:history.go(-1);" class="btn btn-primary btn-sm" type="button"><?php echo L('BACK');?></a>
                        </div>

                    </div>
                    <!-- content -->
                    <div class="iviews-order ibox-content">

                        <div class="row iviews-steps steps">
                            <ul>
                                <li v-cloak v-for="( item , $index ) in stepArr" :index="$index" :data-index="$index" :class="{ active: stepArr[$index].active , error: stepArr[$index].error }" @click="tab($index)">
                                    {{ item.name }}
                                </li>
                            </ul>
                        </div>
                        <!-- <div id="tt_1">
                             <?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="ser_type" val="<?php echo ($vo["sid"]); ?>" style="width: 120px;height: 120px;border: 1px solid red">
                                     <?php echo (l($vo['d_value'])); ?>
                                 </div><?php endforeach; endif; else: echo "" ;endif; ?>
                             <input type="hidden" name="sid" value="">
                         </div>-->
                        <!-- step2// -->
                        <div class="iviews-order-content iviews-order-step2" v-show="stepArr[0].show">

                            <div class="iviews-order-form">

                                <form method="get" class="form-horizontal">
                                    <div class="form-group" >
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l">
                                            <?php echo L('PROCESSING_MODE');?>
                                        </label>
                                        <?php if(is_array($processing_modem)): $key = 0; $__LIST__ = $processing_modem;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><div class="col-sm-2">
                                                <div class="i-checks">
                                                    <label class="control-label">
                                                        <input type="checkbox" name="step2type" data-key="<?php echo ($key); ?>" value="<?php echo ($vo["d_key"]); ?>" data-lang="<?php echo (l($vo["d_value"])); ?>">
                                                        <i></i> <?php echo (l($vo["d_value"])); ?>
                                                    </label>
                                                </div>
                                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l">
                                            <?php echo L('NORMALS');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <select name="" class="form-control" @change="step2Server">
                                                <option value=""><?php echo L('PLEASE_SELECT');?></option>
                                                <option v-cloak :value="item.planid"  :index="$index" v-for="(item , $index) in step2.serverArr">{{ item.pname }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l">
                                            <?php echo L('OTHERS');?>
                                        </label>
                                        <div class="col-sm-6">
                                            <ul class="iviews-type clearfix">
                                                <li v-cloak v-for="(item , $index) in step2.otherArr" :value="item.planid" :index="$index">{{ item.pname }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l">
                                            <?php echo L('ORDER_UG');?>
                                        </label>
                                        <div class="col-sm-2">
                                            <div class="i-checks inline">
                                                <label class="control-label">
                                                    <input type="radio" name="step2Urgent" value="1" data-lang="<?php echo L('YES');?>" :checked="step2.urgent.key == 1">
                                                    <i></i> <?php echo L('YES');?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="i-checks">
                                                <label class="control-label">
                                                    <input type="radio" name="step2Urgent" value="0" data-lang="<?php echo L('NO');?>" :checked="step2.urgent.key == 0">
                                                    <i></i><?php echo L('NO');?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group iviews-actions">
                                        <div class="col-sm-3 col-sm-offset-1">
                                            <button type="button" @click="step2submit" class="btn btn-primary btn-block"><?php echo L('NEXT');?></button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>

                        <!-- step3// -->
                        <div class="iviews-order-content iviews-order-step3" v-cloak v-show="stepArr[1].show">
                            <div class="ibox-content iviews-order-form">

                                <form method="get" class="form-horizontal">

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l">
                                            <?php echo L('C_NAME');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <p class="form-control-static" v-cloak>{{ step3.clinic.name }}</p>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label">
                                            <?php echo L('CLINICADDRESS');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <p class="form-control-static" v-cloak>{{ step3.clinic.address }}</p>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label">
                                            <?php echo L('SHIPINFO');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <p class="form-control-static" v-cloak><i class="fa fa-map-marker"></i>  {{ step3.mailing.name }} &emsp; {{ step3.mailing.phone }}</p>
                                            <p class="form-control-static">
                                                <span v-show="step3.mailing.address !== ''" v-cloak> {{ step3.mailing.address }}</span>
                                                <a data-trigger="modal" data-title="<?php echo L('EDIT_ADDRESS');?>" data-width="800PX" href="<?php echo U('Addess/index');?>" v-if="step3.mailing.address != '' ">重新选择</a>
                                                <a data-trigger="modal" data-title="<?php echo L('ADD_ADDRESS');?>" data-width="800PX" href="<?php echo U('Addess/add');?>" ><?php echo L('ADD');?></a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l">
                                            <?php echo L('DOCINFO');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="doctor" @keydown="rclass" value="" v-model="step3.team.doctor">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label">
                                            <?php echo L('DOCINFO_TEL');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="doctor_tel" @keydown="rclass" value="" v-model="step3.team.doctorTel">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label">
                                            <?php echo L('DOCOSSINFO');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="doctorAssistant" @keydown="rclass" value="" v-model="step3.team.doctorAssistant">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label">
                                            <?php echo L('DOCOSSINFO_TEL');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="doctorAssistantTel" @keydown="rclass" value="" v-model="step3.team.doctorAssistantTel">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label">
                                            <?php echo L('ADOCINFO');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="referralDoctor"  value="" v-model="step3.team.referralDoctor">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label">
                                            <?php echo L('ADOCINFO_TEL');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="referralDoctorTel"  value="" v-model="step3.team.referralDoctorTel">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label">
                                            <?php echo L('ADOCOSSINFO');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="referralAssistant" value="" v-model="step3.team.referralAssistant">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label">
                                            <?php echo L('ADOCOSSINFO_TEL');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="referralAssistantTel"  value="" v-model="step3.team.referralAssistantTel">
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <!-- <div class="form-group iviews-actions">
                                        <div class="col-sm-3 col-sm-offset-1">
                                            <button type="button" class="btn btn-primary btn-block" @click="step3submit"> <?php echo L('NEXT');?></button>
                                        </div>
                                    </div> -->

                                    <div class="form-group" id="name4">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('P_NAME');?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="name4" @keyup="rclass" v-model="step4.patient.name">
                                            <ul>
                                                <!-- <li class="nodata">暂无数据</li>
                                                <li>数据1</li>
                                                <li>数据2</li> -->
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label">
                                            <?php echo L('SEX');?>
                                        </label>
                                        <div class="col-sm-1">
                                            <div class="i-checks inline">
                                                <label class="control-label">
                                                    <input type="radio" name="sex" value="1" data-lang="<?php echo L('MAN');?>" :checked="step4.patient.sex.key == 1">
                                                    <i></i>  <?php echo L('MAN');?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="i-checks">
                                                <label class="control-label">
                                                    <input type="radio" name="sex" value="2" data-lang="<?php echo L('WOMAN');?>" :checked="step4.patient.sex.key == 2">
                                                    <i></i> <?php echo L('WOMAN');?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="birthday">
                                        <label class="col-sm-2 col-sm-offset-1 control-label"><?php echo L('P_BR');?></label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                <input type="text" class="form-control " name="birthday" v-model="step4.patient.birthday">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label "><?php echo L('AGE');?></label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <span id="age"></span>
                                                <input type="hidden" name="age"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-11 col-sm-offset-1 control-label border-l"><?php echo L('PAZHUSHU');?></label>
                                        <div class="col-sm-11 col-sm-offset-1">
                                            <br>
                                            <div class="summernote">
                                                <textarea name="note1"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('REPAIRBODY');?></label>
                                        <?php if(is_array($isxft)): $i = 0; $__LIST__ = $isxft;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-sm-1">
                                                <div class="i-checks">
                                                    <label class="control-label">
                                                        <input type="radio" name="xiufu" data-lang="<?php echo (l($vo["d_value"])); ?>" value="<?php echo ($vo["d_key"]); ?>" checked >
                                                        <i></i> <?php echo (l($vo["d_value"])); ?>
                                                    </label>
                                                </div>
                                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label"><?php echo L('PERIOD');?></label>
                                        <?php if(is_array($isyzy)): $i = 0; $__LIST__ = $isyzy;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-sm-1">
                                                <div class="i-checks">
                                                    <label class="control-label">
                                                        <input type="radio" name="yan" data-lang="<?php echo (l($vo["d_value"])); ?>" value="<?php echo ($vo["d_key"]); ?>" checked >
                                                        <i></i> <?php echo (l($vo["d_value"])); ?>
                                                    </label>
                                                </div>
                                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label"><?php echo L('TOOTHLOOSE');?></label>
                                        <?php if(is_array($issd)): $i = 0; $__LIST__ = $issd;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-sm-1">
                                                <div class="i-checks">
                                                    <label class="control-label">
                                                        <input type="radio" name="song" data-lang="<?php echo (l($vo["d_value"])); ?>" value="<?php echo ($vo["d_key"]); ?>" checked >
                                                        <i></i> <?php echo (l($vo["d_value"])); ?>
                                                    </label>
                                                </div>
                                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label"><?php echo L('FIXTYPE');?></label>
                                        <div class="col-sm-4">
                                            <select name="" @change="step4repairtype" class="form-control">
                                                <option value=""><?php echo L('PLEASE_SELECT');?></option>
                                                <option :value="item.d_key" v-for="(item , $index) in step4.repairtypeArr" :index="$index" v-cloak>{{ item.d_value }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group" id="surgery">
                                        <label class="col-sm-2 col-sm-offset-1 control-label"><?php echo L('PLANOPTIME');?></label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                <input type="text" class="form-control" onchange="time_change()" name="surgery_time" v-model="step4.date">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group iviews-actions">
                                        <div class="col-sm-3 col-sm-offset-1">
                                            <button type="button" class="btn btn-primary btn-block" @click="step3submit"><?php echo L('NEXT');?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- step5// -->
                        <div class="iviews-order-content iviews-order-step5" v-cloak v-show="stepArr[2].show">

                            <div class="iviews-order-form">
                                <form method="" class="form-horizontal">
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
                                    <div class="hr-line-dashed"></div>

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
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l">
                                            <?php echo L('SURGERYSYSTEM');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <select name="" id="step5brand" class=" form-control ui-select">
                                                <option value=""><?php echo L('PLEASE_SELECT');?></option>
                                                <option :value="item.id" v-for="(item , $index) in step5.brandArr" :index="$index">{{ item.pname }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l">
                                            <?php echo L('OPTOOL');?>
                                        </label>
                                        <div class="col-sm-4">
                                            <select name="" id="step5tool" class=" form-control  ui-select">
                                                <option value=""><?php echo L('PLEASE_SELECT');?></option>
                                                <option :value="item.id" v-for="(item , $index) in step5.toolArr" :index="$index">{{ item.pname }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group iviews-actions">
                                        <div class="col-sm-3 col-sm-offset-1">
                                            <button type="button" class="btn btn-primary btn-block" @click="step5submit"><?php echo L('NEXT');?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- step6// -->
                        <div class="iviews-order-content iviews-order-step6" v-cloak v-show="stepArr[3].show">

                            <div class="iviews-order-form">
                                <div class="form-horizontal">

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('KNMX');?></label>
                                        <div class="col-sm-4">
                                            <select name="" class="form-control" @change="step6modal">
                                                <option value=""><?php echo L('PLEASE_SELECT');?></option>
                                                <option :value="item.d_key" :index="$index" v-for="(item , $index) in step6.modalArr">{{ item.d_value }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="knmx_pic" style="display: none">
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-3">
                                                <div style="position: relative;width: 200px;display: inline-block;margin-right: 10px;" id="pic_div3">
                                                    <div class="form-item" style="border: 0; line-height: 52px;">
                                                        <input type="hidden" id="pic3" name="pic3" />
                                                        <div class="fl ">
                                                            <script type="text/template" id="qq-template-validation-license3">
                                                                <div class="qq-uploader-selector">
                                                                    <ul class="qq-upload-list-selector" aria-live="polite"
                                                                        aria-relevant="additions removals">
                                                                        <li class="pli">
                                                                            <img class="qq-thumbnail-selector" qq-max-size="200" qq-server-scale style="">
                                                                            <div class="pdel">
                                                                                <button type="button"
                                                                                        style="background: none;border: 0;height:20px;width:20px;margin-top: -30px;" class="qq-btn qq-upload-cancel-selector qq-upload-cancel" id="license_cance3">
                                                                                </button>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                    <div class="qq-upload-button-selector qq-upload-button-news" id="license_button3">
                                                                        <div>上传图片</div>
                                                                    </div>

                                                                </div>
                                                            </script>
                                                            <div id="fine-uploader-license3">
                                                            </div>
                                                        </div>
                                                        <div class="cl"></div>
                                                        <i class="i-status"></i>
                                                    </div>
                                                    <div class="input-tip">
                                                        <span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-3">
                                                <small>
                                                    *GuideMia口内模型数据采集标准
                                                    <a href="<?php echo U('Order/file_download');?>" target="_blank">[文件下载]</a>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('PCBCTD');?> 
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="form-group-cbct" id="drop-zone">
                                                <!-- <div class="col-sm-12"> -->
                                                    <div class="form-group-cbct-file">
                                                        上传文件夹
                                                        <input type="file" name="filesToUpload[]" id="filesToUpload" multiple="multiple" accept="*.dcm" webkitdirectory="" directory="" />
                                                    </div>
                                                    <div class="row" id="drop-show">
                                                        <div class="col-sm-12 form-group-cbct-item" v-for="(item,$index) in step6.folder" :index="$index">
                                                            <span class="folder-name" v-cloak>{{ item.id }}</span>
                                                            <span class="folder-length" v-cloak>{{ item.file.length }}个文件</span>
                                                            <span class="folder-size" v-cloak>{{ item.total | sizeFilter }}</span>
                                                            <span class="folder-see" @click="step6FolderSee" :data-index="$index">[查看]</span>
                                                            <span class="folder-del" @click="step6FolderDel($index)">[删除]</span>
                                                        </div>
                                                    </div>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-3">
                                            <small>
                                                *各品牌CT机CBCT导出流程
                                                <a href="<?php echo U('Order/file_download');?>" target="_blank">[文件下载]</a>
                                            </small>
                                        </div>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label class="col-sm-11 col-sm-offset-1 control-label ">描述</label>
                                        <div class="col-sm-11 col-sm-offset-1">
                                            <br>
                                            <div class="summernote">
                                                <textarea name="note2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('KNZP');?></label>
                                        <div class="col-sm-4">
                                            <div style="position: relative;width: 200px;display: inline-block;margin-right: 10px;" id="pic_div">
                                                <div class="form-item" style="border: 0; line-height: 52px;">
                                                    <input type="hidden" id="pic1" name="pic2" />
                                                    <div class="fl ">
                                                        <script type="text/template" id="qq-template-validation-license">
                                                            <div class="qq-uploader-selector">
                                                                <ul class="qq-upload-list-selector" aria-live="polite"
                                                                    aria-relevant="additions removals">
                                                                    <li class="pli">
                                                                        <img class="qq-thumbnail-selector" qq-max-size="200" qq-server-scale style="">
                                                                        <div class="pdel">
                                                                            <button type="button"
                                                                                    style="background: none;border: 0;height:20px;width:20px;margin-top: -30px;" class="qq-btn qq-upload-cancel-selector qq-upload-cancel" id="license_cancel">
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                                <div class="qq-upload-button-selector iviews-file-box iviews-file-kn" id="license_button">
                                                                    <div></div>
                                                                </div>

                                                            </div>
                                                        </script>
                                                        <div id="fine-uploader-license">
                                                        </div>
                                                    </div>
                                                    <div class="cl"></div>
                                                    <i class="i-status"></i>
                                                </div>
                                                <div class="input-tip">
                                                    <span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('MBZP');?></label>
                                        <div class="col-sm-4">
                                            <div style="position: relative;width: 200px;display: inline-block;margin-right: 10px;" id="pic_div2">
                                                <div class="form-item" style="border: 0; line-height: 52px;">
                                                    <input type="hidden" id="pic2" name="pic2" />
                                                    <div class="fl ">
                                                        <script type="text/template" id="qq-template-validation-license2">
                                                            <div class="qq-uploader-selector">
                                                                <ul class="qq-upload-list-selector" aria-live="polite"
                                                                    aria-relevant="additions removals">
                                                                    <li class="pli">
                                                                        <img class="qq-thumbnail-selector" qq-max-size="200" qq-server-scale style="">
                                                                        <div class="pdel">
                                                                            <button type="button"
                                                                                    style="background: none;border: 0;height:20px;width:20px;margin-top: -30px;" class="qq-btn qq-upload-cancel-selector qq-upload-cancel" id="license_cance2">
                                                                            </button>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                                <div class="qq-upload-button-selector iviews-file-box iviews-file-mb" id="license_button2">
                                                                    <div></div>
                                                                </div>

                                                            </div>
                                                        </script>
                                                        <div id="fine-uploader-license2">
                                                        </div>
                                                    </div>
                                                    <div class="cl"></div>
                                                    <i class="i-status"></i>
                                                </div>
                                                <div class="input-tip">
                                                    <span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('HGDY');?></label>
                                        <div class="col-sm-1">
                                            <div class="i-checks">
                                                <label class="control-label">
                                                    <input type="radio" name="hegu" data-lang="<?php echo L('YES');?>" value="1" :checked="step6.hegu.key == 1">
                                                    <i></i> <?php echo L('YES');?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="i-checks">
                                                <label class="control-label">
                                                    <input type="radio" name="hegu" data-lang=<?php echo L('NO');?>"" value="0" :checked="step6.hegu.key == 0">
                                                    <i></i> <?php echo L('NO');?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('MXDY');?></label>
                                        <div class="col-sm-1">
                                            <div class="i-checks">
                                                <label class="control-label">
                                                    <input type="radio" name="moxing" value="1" data-lang="<?php echo L('YES');?>" :checked="step6.moxing.key == 1">
                                                    <i></i> <?php echo L('YES');?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="i-checks">
                                                <label class="control-label">
                                                    <input type="radio" name="moxing" value="0" data-lang="<?php echo L('NO');?>" checked="step6.moxing.key == 0">
                                                    <i></i> <?php echo L('NO');?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group iviews-actions">
                                        <div class="col-sm-3 col-sm-offset-1">
                                            <button type="button" class="btn btn-primary btn-block" @click="step6submit"><?php echo L('NEXT');?></button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- step7// -->
                        <div class="iviews-order-content iviews-order-step7" v-cloak v-show="stepArr[4].show">

                            <div class="iviews-order-form">
                                <form method="" class="form-horizontal">

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('ORDER_STYPE');?></label>
                                        <div class="col-sm-1">
                                            <p class="form-control-static" v-cloak>{{ step1.type | servetype }}</p>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('SERVICE_NAME');?></label>
                                        <div class="col-sm-4">
                                            <p class="form-control-static">
                                                <span class="control-span"><?php echo L('PROSCH');?>:</span>
                                                <span v-for="(item , $index) in step2.type" :index="$index" v-cloak>{{ item.value }} &emsp;</span>
                                            </p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="form-control-static" v-cloak>
                                                <span class="control-span"><?php echo L('NORMALS');?>:</span>
                                                {{ step2.server.value }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-3">
                                            <p class="form-control-static">
                                                <span class="control-span"><?php echo L('OTHERS');?>:</span>
                                                <span v-for="(item , $index) in step2.other" :index="$index" v-cloak>{{ item.value }} &emsp;</span>
                                            </p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="form-control-static" v-cloak>
                                                <span class="control-span"><?php echo L('ORDER_UG');?>:</span> {{ step2.urgent.value }}</p>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('CUSTOMERINFO');?></label>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p class="form-control-static"><span class="control-span"><?php echo L('SHIPINFO');?>:</span> {{ step3.clinic.name }} &emsp; {{ step3.clinic.address }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <p class="form-control-static"><span class="control-span"><?php echo L('DEINFO');?>:</span> {{step3.mailing.name}} &emsp; {{step3.mailing.phone}} &emsp; {{step3.mailing.address}}</p>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('DOCINFO');?>:</span> {{step3.team.doctor}}
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('DOCOSSINFO');?>:</span> {{step3.team.doctorAssistant}}
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>  <span class="control-span"><?php echo L('ADOCINFO');?>:</span> {{step3.team.referralDoctor}}</p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>   <span class="control-span"><?php echo L('ADOCOSSINFO');?>:</span> {{step3.team.referralAssistant}}</p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('DOCINFO_TEL');?>:</span> {{step3.team.doctorTel}}
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('DOCOSSINFO_TEL');?>:</span> {{step3.team.doctorAssistantTel}}
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>  <span class="control-span"><?php echo L('ADOCINFO_TEL');?>:</span> {{step3.team.referralDoctorTel}}</p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak> <span class="control-span"><?php echo L('ADOCOSSINFO_TEL');?>:</span> {{step3.team.referralAssistantTel}}</p>
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
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('P_NAME');?>:</span> {{ step4.patient.name }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('SEX');?>:</span> {{ step4.patient.sex.value }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('P_BR');?>:</span> {{ step4.patient.birthday }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('AGE');?>:</span> {{ step4.patient.age }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <span class="control-span"><?php echo L('PAZHUSHU');?>:</span>
                                                </div>
                                                <div class="col-sm-12" v-html="step4.note.patient"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('REPAIRBODY');?>:</span> {{ step4.repair.value }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('PERIOD');?>:</span> {{ step4.inflammation.value }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('TOOTHLOOSE');?>:</span> {{ step4.pine.value }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('FIXTYPE');?>:</span> {{ step4.repairtype.value }}
                                                    </p>
                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="form-control-static" v-cloak>
                                                        <span class="control-span"><?php echo L('PLANOPTIME');?>:</span> {{ step4.date }}
                                                    </p>
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
                                                    <img :src="step5.lackBase64" alt="">
                                                    <span><?php echo L('MISSTOOTH');?></span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <img :src="step5.plantBase64" alt="">
                                                    <span><?php echo L('SEEDTOOTH');?></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <p class="form-control-static" v-cloak>  <span class="control-span"><?php echo L('SURGERYSYSTEM');?>:</span> {{ step5.brand.value }}</p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <p class="form-control-static" v-cloak>  <span class="control-span"><?php echo L('OPTOOL');?>:</span> {{ step5.tool.value }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group form-group-cbct" style="padding-left: 20px">
                                        <label class="col-sm-2 col-sm-offset-1 control-label border-l"><?php echo L('BLZL');?></label>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <label class="col-sm-label control-label"><?php echo L('KNMX');?>:</label>
                                                <div class="col-sm-11">
                                                    <p class="form-control-static" v-cloak>{{ step6.modal.value }}</p>
                                                </div>
                                            </div>
                                            <div class="row iviews-cbct knmx_pic" style="display: none">
                                                <label class="col-sm-label control-label"> <?php echo L('KXZP');?>:</label>
                                                <div class="col-sm-3">
                                                    <!-- dd -->
                                                    <img :src="step6.pic3" > 
                                                </div>
                                            </div>
                                            <div class="row iviews-cbct">
                                                <label class="col-sm-label control-label" style="padding-top: 0;">CBCT:</label>
                                                <div class="col-sm-8 form-group-cbct-item" v-for="(item,$index) in step6.folder" :index="$index">
                                                    <span class="folder-name" v-cloak>{{ item.id }}</span>
                                                    <span class="folder-length" v-cloak>{{ item.file.length }}个文件</span>
                                                    <span class="folder-size" v-cloak>{{ item.total | sizeFilter}}</span>
                                                    <span class="folder-see" v-cloak @click="step6FolderSee" :data-index="$index">[<?php echo L('INFO');?>]</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12" style="padding-left: 0;">
                                                    <span class="control-span"><?php echo L('PAZHUSHU');?>:</span>
                                                </div>
                                                <div class="col-sm-12" style="padding-left: 0;">
                                                    <p class="form-control-static" v-html="step6.note"></p>
                                                </div>
                                            </div>
                                            <div class="row iviews-cbct">
                                                <label class="col-sm-label control-label"> <?php echo L('KNZP');?>:</label>
                                                <div class="col-sm-3">
                                                    <img :src="step6.photo" >
                                                </div>
                                                <label class="col-sm-label control-label"> <?php echo L('MBZP');?>:</label>
                                                <div class="col-sm-3">
                                                    <img :src="step6.face" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-label control-label"> <?php echo L('HGDY');?>:</label>
                                                <div class="col-sm-1">
                                                    <p class="form-control-static" v-cloak>{{ step6.hegu.value }}</p>
                                                </div>
                                                <label class="col-sm-1 control-label"> <?php echo L('MXDY');?>:</label>
                                                <div class="col-sm-label">
                                                    <p class="form-control-static" v-cloak>{{ step6.moxing.value }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    <div class="form-group iviews-actions">
                                        <strong class="col-sm-11 col-sm-offset-1 order_amount">

                                        </strong>
                                        <div class="col-sm-3 col-sm-offset-1">
                                            <button type="button" class="btn btn-primary btn-block" id="save"><?php echo L('SUBMIT_ORDER1');?></button>
                                        </div>
                                    </div>
                                </form>
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
    <!-- fixed -->
    
    <script>

        function format_bytes($size)
        {
            var $units =   ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
            for (var $i =0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
            return  $size.toFixed(2) + $units[$i];
        }

        function order_choose(param){
            // debugger
            order.step3.clinic.addr_id = param.addr_id;
            order.step3.mailing.address = param.regionname;
            order.step3.mailing.name = param.snee;
            order.step3.mailing.phone = param.snee_tel;
            // debugger
            $('.modal').hide();
            // debugger
            $('.modal-backdrop').remove();
        }

        // jquery
        // 算高
        $(function(){

            // plugin init
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'icheckbox_square-green',
            });
            $.full.resize();

            $.mask.close();

            $('.full-height-scroll').slimscroll({
                height: '480px'
            })

            var $minHeight = 0,
                $winHeight = $(window).height(),
                $navHeight = $('.navbar').height(),
                $fooHeight = $('.footer').height(),
                $padHeight = 120,
                $pahHeight = $('.page-heading').height();

            $('#page-wrapper').css('min-height', $winHeight);
            $('.iviews-order').css('min-height', $winHeight - $navHeight - $fooHeight - $padHeight - $pahHeight);
            
            // $('#step5brand_chosen').change(function () {
            //     alert('s');
            // })
            $('#app').on('change','#step5brand', function(e){
                var obj = {
                    key: 1, 
                    value: ''
                }
                obj.key = $(this).find('option:selected').val();
                obj.value = $(this).find('option:selected').text();
                order.step5.brand = obj;
            })
            
            $('#app').on('change', '#step5tool', function (e) {
                var obj = {
                    key: 1,
                    value: ''
                }
                obj.key = $(this).find('option:selected').val();
                obj.value = $(this).find('option:selected').text();
                order.step5.tool = obj;
            })

            function removeByValue(arr, val) {
                for (var i = 0; i < arr.length; i++) {
                    if (arr[i] == val) {
                        arr.splice(i, 1);
                        break;
                    }
                }
            }

            $('.iviews-order-step2 input[name="step2type"]').on('ifChecked', function () {
                $(this).closest('.form-group').removeClass('has-error');
                var obj = { key: $(this).val() , value: $(this).attr('data-lang') }
                order.step2.type.push(obj);
            })

            $('.iviews-order-step2 input[name="step2type"]').on('ifUnchecked', function () {
                var key = $(this).val();

                order.step2.type.map( (item,index) => {
                    if ( key == item.key ) {
                        order.step2.type.splice(index,1);
                    }
                })
            })

            $('.iviews-order-step2 input[name="step2Urgent"]').on('ifChecked', function () {
                let obj = { key: $(this).val() , value: $(this).attr('data-lang') }
                order.step2.urgent = obj;
            })

            $('.iviews-order-step6 input[name="hegu"]').on('ifChecked', function () {
                let obj = { key: $(this).val(), value: $(this).attr('data-lang') }
                order.step6.hegu = obj;
            })

            $('.iviews-order-step6 input[name="moxing"]').on('ifChecked', function () {
                let obj = { key: $(this).val(), value: $(this).attr('data-lang') }
                order.step6.moxing = obj;
            })

            $('.iviews-order-step3 input[name="sex"]').on('ifChecked', function () {
                let obj = { key: $(this).val() , value: $(this).attr('data-lang') }
                order.step4.patient.sex = obj;
            })

            $('.iviews-order-step3 input[name="xiufu"]').on('ifChecked', function () {
                let obj = { key: $(this).val(), value: $(this).attr('data-lang') }
                order.step4.repair = obj;
            })

            $('.iviews-order-step3 input[name="yan"]').on('ifChecked', function () {
                let obj = { key: $(this).val(), value: $(this).attr('data-lang') }
                order.step4.inflammation = obj;
            })

            $('.iviews-order-step3 input[name="song"]').on('ifChecked', function () {
                let obj = { key: $(this).val(), value: $(this).attr('data-lang') }
                order.step4.pine = obj;
            })

            // $('.iviews-order-step2 .iviews-type li').on('click', function(){
                // $(this).addClass('active').siblings().removeClass('active');
                // order.step2.other = $(this).text();
            // })
            // order.step3.mailing.address='ssss'


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
                                    var url = "<?php echo U('Dentist/Order/uploadFile',array('code'=>$code,'sn'=>$sn));?>";
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
                    console.log(folderObj);
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
                                var url1 = "<?php echo U('Dentist/Order/uploadFile',array('code'=>$code,'sn'=>$sn));?>";
                                $.ajax({

                                    url: url1,
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
            // $("#ok").click(function (e) {
            //     e.preventDefault();

            //     $("#autoform").ajaxSubmit({
            //         url: "<?php echo U('Dentist/Order/uploadFile');?>",
            //         type: 'POST',
            //         dataType: 'json',
            //         success: function (data) {
            //             console.log(data);
            //         },
            //         error: function (data) {
            //         }
            //     });
            // });

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

            $('.iviews-order-step3 .iviews-actions .btn').on('click', function () {
                order.step4.note.patient = CKEDITOR.instances.note1.getData();
            })

            $('.iviews-order-step6 .iviews-actions .btn').on('click', function () {
                order.step6.note = CKEDITOR.instances.note2.getData();
            })

            
            // step5 chosen 取值
            // $('#step5brand_chosen').on('change', function (evt, params) {
            //     console.log(evt);
            //     console.log(params);
            // });
        });
        // E1205525
        var data = {};

        // data.step1Type = order.step4.note.patient;
        // vue
        var $serverArr = <?php echo ($costplan); ?>;
        var $repairtype = <?php echo ($repairtype); ?>;
        var $dentist = <?php echo ($dentist); ?>;
        var $addr = <?php echo ($addr); ?>;
        var  $addr_id = 0;
        var  $addr_name = '';
        var  $addr_phone = '';
        var  $address = '';
        if($addr != null){
             $address = $addr.regionname+' '+$addr.addr;
             $addr_id = $addr.addr_id;
             $addr_name = $addr['snee'];
             $addr_phone = $addr['snee_tel'];
        }
        var $clinic_address='';
        var $clinic_name='';
        var $clinic_phone ='';
        if($dentist != null){
             $clinic_address = $dentist['regionname']+' '+$dentist['addr'];
            $clinic_name = $dentist['name'];
        }
        var order = new Vue({
            el: '#app',
            data () {
                return {
                    stepArr: [
                        { name: "<?php echo L('SERVICE_CONTENT');?>", show: true, error: false, active: true },
                        { name: "<?php echo L('PATIENT_INFO');?>", show: false, error: false, active: true },
                        { name: "<?php echo L('TOOTH');?>", show: false, error: false, active: true },
                        { name: "<?php echo L('DATUM');?>", show: false, error: false, active: true },
                        { name: "<?php echo L('SUBMIT_ORDER');?>", show: false, error: false, active: true }
                    ],
                    stepIndex: 1,
                    step1: {
                        type: 10          // 1.种植  2.固定正畸  3.隐形正畸
                    },
                    step2: {
                        type: [],         // true 设计方案 false 模型方案
                        urgent: {
                            key: 0 ,
                            value: "<?php echo L('NO');?>"
                        },       // true 加急  false 未加急
                        server: { key: '', value: '' }, // 普通服务内容 默认值可以取serverArr[0]
                        serverArr: $serverArr,
                        other: [], // 其他服务内容 默认值可以取otherArr[0]
                        otherArr: <?php echo ($costplan1); ?> // 其他服务内容选项
                    },
                    step3: {
                        clinic: {
                            name: $clinic_name,       //  诊所名字
                            address: $clinic_address,     //  诊所地址
                            addr_id:$addr_id,
                        },
                        mailing: {
                            name: $addr_name,         //  医生名字
                            phone: $addr_phone,  //  医生电话
                            address: $address     //  医生地址
                        },
                        team: {
                            doctor: '',            //  主治医师
                            doctorAssistant: '',   //  医生助理
                            referralDoctor: '',    //  转诊医生
                            referralAssistant: '',  //  转诊助理
                            doctorTel: '',            //  主治医师
                            doctorAssistantTel: '',   //  医生助理
                            referralDoctorTel: '',    //  转诊医生
                            referralAssistantTel: ''  //  转诊助理
                        }
                    },
                    step4: {
                        patient: {
                            name: '',            //  患者姓名
                            sex: { key: 1, value: "<?php echo L('MAN');?>" },              //  1. 男  2. 女
                            age: '',             //  年龄
                            birthday: '' //  生日
                        },
                        note: {
                            patient: '',        //  患者主诉
                        },
                        repair: { key: 2, value: "<?php echo l('WU');?>" },              //  修复体
                        inflammation: { key: 3, value: "<?php echo L('WU');?>" },                //  牙周炎
                        pine: { key: 4, value: "<?php echo L('WU');?>" },                                //  牙齿松动
                        repairtype: { key: '', value: '' },       //  普通服务内容
                        repairtypeArr: $repairtype,       //  普通服务内容
                        date: ''      //  预计手术时间
                    },
                    step5: {
                        brand: {key: '', value: ''},                 //  种植体品牌及型号 默认可以为brandArr[0]
                        brandArr: <?php echo ($plants); ?>,    //  种植体品牌型号选项
                        tool: { key: '', value: '' },                  //  手术工具 默认可以为tooArr[0]
                        toolArr: <?php echo ($tools); ?>,     //  手术工具备选项
                        lack: [],                      //   缺失牙位标记 目前存的是name 例如sup9=> 上面第九  inf3 下面第三
                        plant: [],                     //  拟种植牙位标记 存的数据同上
                        lackBase64: '',                //  缺失牙位的jpg图 base64格式
                        plantBase64: ''                //  拟种植牙位的jpg图 base64格式
                    },
                    step6: {
                        modal: { key: '', value: '' },              //  口内模型
                        modalArr: <?php echo ($mmodel); ?>, // 口内模型备选项
                        folder: [] ,
                        fileStatus: false,
                        flagStatus: false,
                        loadStatus: false,
                        photo: '',     // 口内图片
                        face: '',      // 脸部图片
                        pic3: '',      // 口扫照片
                        hegu: { key: 0, value: "<?php echo L('NO');?>" },     // 颌骨打印
                        moxing: { key: 0, value: "<?php echo L('NO');?>" } ,     // 模型打印
                        note:''
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
                    console.log(val);
                    var $units =   ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
                    for (var $i =0; val >= 1024 && $i < 5; $i++) val /= 1024;
                    return  val.toFixed(2) + $units[$i];
                },
                servetype (val) {
                    switch (val) {
                        case 10:
                            return "<?php echo L('PLANT');?>";
                            break;
                        case 20:
                            return "<?php echo L('GINGIVITIS');?>";
                            break
                        case 30:
                            return "<?php echo L('IROK');?>";
                            break;
                    }
                },
            },
            mounted () {
                $('.full-height-scroll').slimscroll({
                    height: '480px'
                })

                this.step2.type.map((item,index)=>{
                    if ( $('input[name="step2type"]').val() == item.key ) {
                        $('input[name="step2type"]').prop('checked',true);
                    }
                })
                function removeByValue(arr, val) {
                    for (var i = 0; i < arr.length; i++) {
                        if (arr[i] == val) {
                            arr.splice(i, 1);
                            break;
                        }
                    }
                }
                $('.iviews-order-step2 .iviews-type li').on('click', function(){
                    $(this).toggleClass('active');

                    let obj = { key: $(this).attr('value') , value: $(this).text() }
                    
                    if ( $(this).hasClass('active') ) {
                        order.step2.other.push(obj)
                    } else {
                        order.step2.other.map((item, index) => {
                            if ($(this).attr('value') == item.key) {
                                order.step2.other.splice(index, 1);
                            }
                        })
                        // order.step2.other.splice( order.step2.other.indexOf(obj),1 ); 
                    }
                })

                // ckeditor
                CKEDITOR.replace('note1');
                CKEDITOR.replace('note2');

            },
            methods: {
                tab(index) {
                    // if ( index === 0 ) {
                    //     return false;
                    // }
                    if (this.stepArr[index].active) {
                        this.stepArr.map((item, $index) => {
                            item.show = false;
                        })
                        this.stepArr[index].show = true;
                    }
                },
                rclass (ele) {
                    if ( $('input[name="' + ele.target.name + '"]').val().length >= 1 ) {
                        $('input[name="'+ele.target.name+'"]').closest('.form-group').removeClass('has-error');
                    }
                },
                // step2
                step2Server (ele) {
                    if ( $('.iviews-order-step2 select').closest('.form-group').hasClass('has-error') ) {
                        $('.iviews-order-step2 select').closest('.form-group').removeClass('has-error')
                    }
                    let obj = {
                        key: ele.target.value,
                        value: ele.target.selectedOptions[0].text
                    }
                    this.step2.server = obj;
                    // this.step2.server.key = ele.target.selectedOptions[0].text;
                    // this.step2.server.value = ele.target.value;
                },
                step2submit () {
                    if ( this.step2.type == '' ) {
                        $(".iviews-order-step2 [name='step2type']").closest('.form-group').addClass('has-error');
                        return false;
                    }
                    if ( this.step2.server.key == '' ) {
                        $('.iviews-order-step2 select').closest('.form-group').addClass('has-error');
                        return false;
                    }
                    this.stepArr[0].show = false;
                    this.stepArr[1].show = true;
                    this.stepArr[1].active = true;
                },
                // step3
                step3submit() {
                    if(this.step3.mailing.addr_id ==''){
                        $.scojs_message("<?php echo L('PMADDRESS');?>", $.scojs_message.TYPE_ERROR);
                    }
                    if ( this.step3.team.doctor === '' ) {
                        $('.iviews-order-step3 input[name="doctor"]').closest('.form-group').addClass('has-error');
                        return false;
                    }
                    if ( this.step3.team.doctorTel === '' ) {
                        $('.iviews-order-step3 input[name="doctor_tel"]').closest('.form-group').addClass('has-error');
                        return false;
                    }
                    if (this.step3.team.doctorAssistant === '') {
                        $('.iviews-order-step3 input[name="doctorAssistant"]').closest('.form-group').addClass('has-error');
                        return false;
                    }
                    if (this.step3.team.doctorAssistantTel === '') {
                        $('.iviews-order-step3 input[name="doctorAssistantTel"]').closest('.form-group').addClass('has-error');
                        return false;
                    }

                    
                    let surgery = $('#surgery');
                    let birthday = $('#birthday');
                    if ($('#name4').find('input').val() == '') {
                        $('#name4').addClass('has-error');
                        return false;
                    }
                    if (birthday.find('input').val() == '') {
                        birthday.addClass('has-error');
                        return false;
                    }
                    if (surgery.find('input').val() == '') {
                        surgery.addClass('has-error');
                        return false;
                    }

                    this.stepArr[1].show = false;
                    this.stepArr[2].show = true;
                    this.stepArr[2].active = true;
                },
                // step4
                step4repairtype(ele) {
                    // this.step4.repairtype = ele.target.value;
                    let obj = {
                        key: ele.target.value,
                        value: ele.target.selectedOptions[0].text
                    }
                    this.step4.repairtype = obj;
                },
                step4submit() {
                    let surgery     =   $('#surgery');
                    let birthday    =   $('#birthday');
                    if ( $('#name4').find('input').val() == '' ) {
                        $('#name4').addClass('has-error');
                        return false;
                    }
                    if ( birthday.find('input').val() == '' ) {
                        birthday.addClass('has-error');
                        return false;
                    }
                    if ( surgery.find('input').val() == '' ) {
                        surgery.addClass('has-error');
                        return false;
                    }
                    // this.step4.note.patient = $('textarea[name="note1"]').val();
                    // this.step4.note.case = $('textarea[name="note2"]').val();
                    this.stepArr[2].show = false;
                    this.stepArr[3].show = true;
                    this.stepArr[3].active = true;
                },
                // step5
                // step5brand(ele) {
                //     let obj = {
                //         key: ele.target.value,
                //         value: ele.target.selectedOptions[0].text
                //     }
                //     this.step5.brand = obj;
                // },
                // step5tool(ele) {
                //     let obj = {
                //         key: ele.target.value,
                //         value: ele.target.selectedOptions[0].text
                //     }
                //     this.step5.tool = obj;
                // },
                step5submit() {
                    $('.canvas1 , .canvas2').remove();
                    let dom1 = $('#pz_dentales').clone();
                    let dom2 = $('#pz_dentales_2').clone();
                    dom1.addClass('canvas1');
                    dom2.addClass('canvas2');
                    dom1.css({
                        'position': 'fixed',
                        'right': '0',
                        'bottom': '0',
                        'z-index': '-1'
                    })
                    dom2.css({
                        'position': 'fixed',
                        'right': '0',
                        'bottom': '0',
                        'z-index': '-1'
                    })
                    $('body').append(dom1);
                    $('body').append(dom2);

                    for ( let i = 0; i < $('#img_pz input[type="checkbox"]:checked').length; i++ ) {
                        this.step5.lack.push($('#img_pz input[type="checkbox"]:checked').eq(i).attr('name'));
                    }
                    for (let i = 0; i < $('#img_pz_2 input[type="checkbox"]:checked').length; i++) {
                        this.step5.plant.push($('#img_pz_2 input[type="checkbox"]:checked').eq(i).attr('name'));
                    }
                    let s5 = this.step5;
                    html2canvas($('.canvas1'),{
                        allowTaint: true,
                        taintTest: false,
                        onrendered: function (canvas) {
                            s5.lackBase64 = canvas.toDataURL("image/jpeg", 1.0);
                        }
                    });
                    html2canvas($('.canvas2'), {
                        allowTaint: true,
                        taintTest: false,
                        onrendered: function (canvas) {
                            s5.plantBase64 = canvas.toDataURL("image/jpeg", 1.0);
                        }
                    });

                    if(order.step5.plant.length <1){

                        $.scojs_message('<?php echo L("SELECTDTOOTH");?>', $.scojs_message.TYPE_ERROR);
                        return false;
                    }
                    console.log(order.step5.plant);
                    // html2canvas(document.getElementById('pz_dentales_2')).then(function (canvas) {
                    //     s5.plantBase64 = canvas.toDataURL();
                    //     console.log(canvas.toDataURL());
                    // });
                    this.stepArr[2].show = false;
                    this.stepArr[3].show = true;
                    this.stepArr[3].active = true;
                },
                // step6
                step6modal(ele) {
                    let obj = {
                        key: ele.target.value,
                        value: ele.target.selectedOptions[0].text
                    }
                    this.step6.modal = obj;
                    if(ele.target.value == 'mouth_scan'){
                        $(".knmx_pic").show();
                    }else{
                        $(".knmx_pic").hide();
                    }
                    if ( $('.iviews-order-step6 select').closest('.form-group').hasClass('has-error') ) {
                        $('.iviews-order-step6 select').closest('.form-group').removeClass('has-error')
                    }
                },
                step6submit() {
                    if ( order.step6.modal.key == '' ) {
                        $('.iviews-order-step6 select').closest('.form-group').addClass('has-error');
                        return false;
                    }
                    // my-awesome-dropzone
                    if(order.step6.modal.key == 'mouth_scan' && order.step6.pic3 == ''){
                        $.scojs_message('<?php echo L("PKXZP");?>', $.scojs_message.TYPE_ERROR);
                        return false;
                    }
                    if ( order.step6.folder.length != 1 ) {
                        $.scojs_message('<?php echo L("PCBCTD");?>', $.scojs_message.TYPE_ERROR);
                        return false;
                    }
                    if(order.step6.photo == ''){
                        $.scojs_message('<?php echo L("PKNZP");?>', $.scojs_message.TYPE_ERROR);
                        return false;
                    }
                    if(order.step6.face == ''){
                        $.scojs_message('<?php echo L("PMBZP");?>', $.scojs_message.TYPE_ERROR);
                        return false;
                    }
                    get_order_amount();

                    this.stepArr[3].show = false;
                    this.stepArr[4].show = true;
                    this.stepArr[4].active = true;
                },
                step6FolderDel(index) {
                    delete_file(index);
                },
                step6FolderSee() {
                    // $('.iviews-order-mask').css({
                    //     'width': $(window).width(),
                    //     'height': $(window).height(),
                    //     'left': -$('.navbar-default').width(),
                    //     'top': -$('#page-wrapper > .border-bottom').eq(0).height()
                    // })
                    // $('body').addClass('hasMask');
                    // $('#page-wrapper > .border-bottom').eq(0).addClass('hasMask');
                    // $('#page-wrapper > .wrapper').eq(0).addClass('hasMask');
                    //
                    // $.full.open();
                    this.step6.fileStatus = true;
                }
            }
        });
        var restrictedUploader = new qq.FineUploader({
            element: document.getElementById("fine-uploader-license3"),
            template: 'qq-template-validation-license3',
            request: {
                endpoint: "<?php echo U('Order/uploadPic');?>",
                method: 'POST' // Only for the gh-pages demo website due to Github Pages limitations
            },
            thumbnails: {
                placeholders: {
                    waitingPath: 'Admin/jsnew/all.fine-uploader/placeholders/waiting-generic.png',
                    notAvailablePath: 'Admin/jsnew/all.fine-uploader/placeholders/not_available-generic.png'
                }
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'png','gif'],
                itemLimit: 1,
            },
            debug: false,
            callbacks: {
                onSubmit: function(id, fileName) {
                    $("#license_button3").hide();
                    $("#fine-uploader-license3").parent().parent().removeClass("form-item-error");
                    $("#fine-uploader-license3").parent().parent().addClass("form-item-valid");
                    $("#license-error").text("");
                    $("#license-error").attr("id","");
                },
                onCancel: function(id, fileName) {
                    $("#license_button3").show();
                    $("#lpic3").val("");
                },
                onComplete:  function(id,  fileName,  responseJSON)  {
                    if(responseJSON.success){
                        $("#license_cance3").show();
                        order.step6.pic3 = responseJSON.uploadName;
                    }else{
                        $("#license_button3").click();
                    }
                }
            }
        });
        var restrictedUploader = new qq.FineUploader({
            element: document.getElementById("fine-uploader-license2"),
            template: 'qq-template-validation-license2',
            request: {
                endpoint: "<?php echo U('Order/uploadPic');?>",
                method: 'POST' // Only for the gh-pages demo website due to Github Pages limitations
            },
            thumbnails: {
                placeholders: {
                    waitingPath: 'Admin/jsnew/all.fine-uploader/placeholders/waiting-generic.png',
                    notAvailablePath: 'Admin/jsnew/all.fine-uploader/placeholders/not_available-generic.png'
                }
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'png','gif'],
                itemLimit: 1,
            },
            debug: false,
            callbacks: {
                onSubmit: function(id, fileName) {
                    $("#license_button2").hide();
                    $("#fine-uploader-license2").parent().parent().removeClass("form-item-error");
                    $("#fine-uploader-license2").parent().parent().addClass("form-item-valid");
                    $("#license-error").text("");
                    $("#license-error").attr("id","");
                },
                onCancel: function(id, fileName) {
                    $("#license_button2").show();
                    $("#lpic2").val("");
                },
                onComplete:  function(id,  fileName,  responseJSON)  {
                    if(responseJSON.success){

                        $("#license_cance2").show();
                        order.step6.face = responseJSON.uploadName;
                    }else{
                        $("#license_button2").click();
                    }
                }
            }
        });
        var restrictedUploader = new qq.FineUploader({
            element: document.getElementById("fine-uploader-license"),
            template: 'qq-template-validation-license',
            request: {
                endpoint: "<?php echo U('Order/uploadPic');?>",
                method: 'POST' // Only for the gh-pages demo website due to Github Pages limitations
            },
            thumbnails: {
                placeholders: {
                    waitingPath: 'Admin/jsnew/all.fine-uploader/placeholders/waiting-generic.png',
                    notAvailablePath: 'Admin/jsnew/all.fine-uploader/placeholders/not_available-generic.png'
                }
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'png','gif'],
                itemLimit: 1,
            },
            debug: false,
            callbacks: {
                onSubmit: function(id, fileName) {
                    $("#license_button").hide();
                    $("#fine-uploader-license").parent().parent().removeClass("form-item-error");
                    $("#fine-uploader-license").parent().parent().addClass("form-item-valid");
                    $("#license-error").text("");
                    $("#license-error").attr("id","");
                },
                onCancel: function(id, fileName) {
                    $("#license_button").show();
                    $("#pic1").val("");
                },
                onComplete:  function(id,  fileName,  responseJSON)  {
                    if(responseJSON.success){
                        $("#license_cancel").show();
                        order.step6.photo = responseJSON.uploadName;
                    }else{
                        $("#license_button").click();
                    }
                }
            }
        });
        $("[name='name4']").on('propertychange input',function(event){
            var code = event.which;
            var val=$(this).val();
            var lis = '';
            var ret = null;
            var lock = true;
            
            if (val != '' && val.length >= 1 ) {
                $.ajax({
                    url: "<?php echo U('Order/get_pname');?>",
                    async: false ,
                    data : {
                        pname: val
                    },
                    success: function(data) {
                        if (typeof data == 'string') {
                            data = JSON.parse(data);
                        }
                        if (data.done) {
                            // 如果名字相同 直接带出
                            // if( val == data.retval[0].realname && data.retval.length == 1 ) {
                            //     $("[name='birthday']").val(data.retval.birthday);
                            //     var obj = { name: val, sex: { key: data.retval.gender, value: $("[name='sex'][value='" + data.retval.gender + "']").attr('data-lang') }, birthday: data.retval.birthday }
                            //     order.step4.patient = obj;
                            //     $('[name="sex"][value="' + obj.sex.key + '"]').iCheck('check');
                            //     setage();
                            // }
                            ret = data.retval;
                            if ( ret.length > 0 ) {
                                for ( var i = 0; i < ret.length; i++ ) {
                                    lis += '<li data-gender="'+ret[i].gender+'" data-date="'+ret[i].birthday+'">'+ ret[i].realname +'</li>'
                                }
                            }
                            $('#name4 ul').empty().append(lis).show();
                        } else {
                            $('#name4 ul').empty();
                        }
                    },
                    error: function(err) {
                    }
                })
            }
        });

        $('body').on('click','#name4 li',function(){
            
            var _this = $(this),
                _date = _this.attr('data-date'),
                _sex  = _this.attr('data-gender'),
                _name = _this.text(); 
            console.log()
            $("[name='name4']").val(_name);
            $("[name='birthday']").val(_date);
            var obj = { 
                name: _name, 
                sex: { 
                    key: _sex, 
                    value: $("[name='sex'][value='" + _sex + "']").attr('data-lang') 
                }, 
                birthday: _date
            }
            $('#name4 ul').empty().hide();
            order.step4.patient = obj;
            $('[name="sex"][value="' + obj.sex.key + '"]').iCheck('check');
            setage();
        })
        function get_order_amount(){
            $.ajax({
                url: "<?php echo U('Order/get_order_amount');?>",
                method: 'post',
                data: {  processing_modem:order.step2.type,mmodel:order.step6.modal.key, costplan:order.step2.server.key,costplan1:order.step2.other,},
                dataType:'json',
                success: function(data) {
                    if(data.done){
                        $('.order_amount').html('<div class="row">' +
                            '   <label class="col-sm-2 text-right"><?php echo L("TOTAL_AMOUNT");?>：</label>' +
                            '   <div class="col-sm-10">' +
                            '       <p><em>￥</em>'+data.msg.price+'</p>' +
                            '       <p><em>$</em>'+data.msg.price1+'</p>' +
                            '   </div>' +
                            '</div>');
                    }
                },
            });
        }
        $(function(){
            $("#save").click(function(){
                // console.log(order._data);
                var order_date = {
                    sid:order.step1.type,
                    processing_modem:order.step2.type,
                    costplan:order.step2.server.key,
                    costplan1:order.step2.other,
                    isurgents:order.step2.urgent.key,
                    addr_id:order.step3.addr_id,
                    doctor:order.step3.team.doctor,
                    doctorass:order.step3.team.doctorAssistant,
                    doctor1:order.step3.team.referralDoctor,
                    doctorass1:order.step3.team.referralAssistant,
                    doctor_tel:order.step3.team.doctorTel,
                    doctor1_tel:order.step3.team.doctorAssistantTel,
                    doctorass_tel:order.step3.team.referralDoctorTel,
                    doctorass1_tel:order.step3.team.referralAssistantTel,
                    pname:order.step4.patient.name,
                    birthday:order.step4.patient.birthday,
                    sex:order.step4.patient.sex.key,
                    age:order.step4.patient.age,
                    pedesc:order.step4.note.patient,
                    isxft:order.step4.repair.key,
                    isyzy:order.step4.inflammation.key,
                    issd:order.step4.pine.key,
                    repairtype:order.step4.repairtype.key,
                    surgerytime:order.step4.date,
                    toothposition:order.step5.lack,
                    toothposition1:order.step5.plant,
                    surgerysystem:order.step5.brand.key,
                    surgerytool:order.step5.tool.key,
                    mmodel:order.step6.modal.key,
                    pic1:order.step6.photo,
                    pic2:order.step6.face,
                    pic3:order.step6.pic3,
                    print1:order.step6.hegu.key,
                    print2:order.step6.moxing.key,
                    note:order.step6.note,
                }
                $.ajax({
                    url: "<?php echo U('Order/add',array('sn'=>$sn));?>",
                    method: 'post',
                    data: order_date,
                    dataType:'json',
                    success: function(data) {
                        if(data.done === false){
                            $.scojs_message(data.msg, $.scojs_message.TYPE_ERROR);
                        } else {
                            window.location.href = data.msg;
                        }
                    },
                    error: function(err){
                        console.log(err)
                    }
                });
            });
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
        function time_change(){
            if ($("#birthday").hasClass('has-error')) {
                $("#birthday").removeClass('has-error');
                return false;
            }
            if ($("#surgery").hasClass('has-error')) {
                $("#surgery").removeClass('has-error');
                return false;
            }
            if($("[name='birthday']").value !='' && $("[name='birthday']").value != undefined ){
                setage();
                order.step4.patient.birthday = $("[name='birthday']").value;
            }
            if($("[name='surgery']").value !='' && $("[name='surgery']").value != undefined ) {
                order.step4.date = $("[name='surgery']").value;
            }
        }
    </script>

            </div>
        </div>
    </div>
    
</body>

</html>