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
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
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
        .checkmod{background: #f0f0f0;}
        .rule_check{
            border-bottom: 1px dashed  #ccc;
            padding: 5px;
        }
    </style>
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
                    title: {
                        required: true,
                        remote: {
                            url: "<?php echo U('AuthRule/check_title');?>",
                            type: 'post',
                            data: {
                                title: function () {
                                    return $('#title').val();
                                }
                            }
                        }
                    },
                },
                messages: {
                    title: {
                        required : "<?php echo L('PLATFORM_NAME_NOT_EMPTY');?>",
                        remote: "<?php echo L('ROLENAME_EXISTED');?>" //角色名称已被占用
                    },
                }
            });
            $("[id^='node_']").click(function(){
                var id=$(this).attr("item");
                if($(this).is(':checked')) {
                    $("[item^='c_"+id+"']").prop("checked",true);
                }else{
                    $("[item^='c_"+id+"']").prop("checked",false);
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
                            <?php echo L('STUDIO_ROLE');?>
                            <small><?php echo L('ADD');?></small>
                        </h5>
                        <div class="ibox-button">
                            <a href="javascript:history.go(-1);" class="btn btn-primary btn-sm" type="button"><?php echo L('BACK');?></a>
                        </div>
                    </div>
                    <!-- content -->
                    <div class="ibox-content">

                        <form action="<?php echo U('AuthRule/add');?>" method='post' id="form" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('NAME');?><span class="required"></span></label>
                                <div class="col-sm-3">
                                    <input type="text" id="title" name="title" value="" class="form-control" autocomplete="off" placeholder="<?php echo L('PLATFORM_NAME_NOT_EMPTY');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('DESCRIPTION');?></label>
                                <div class="col-sm-4">
                                    <textarea id="description" name="description" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><?php echo L('ORDER');?></label>
                                <div class="col-sm-3">
                                    <input type="text" name="sort_order" value="" class="form-control" autocomplete="off" placeholder="">
                                </div>
                            </div>


                            <table
                                    class="table table-hover table-striped table-bordered table-form">
                                <thead>
                                <tr>
                                    <th style="width: 200px"><?php echo L('MOD');?></th>
                                    <th><?php echo L('FUNC');?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($node_list)): $i = 0; $__LIST__ = $node_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$node): $mod = ($i % 2 );++$i;?><tr class="main_row">
                                        <th><label><?php echo L($node['title']);?> <input
                                                item="<?php echo ($node["id"]); ?>" id="node_<?php echo ($node["id"]); ?>"
                                                class="auth_rules rules_all" type="checkbox" name="rules[]"
                                                value="<?php echo $main_rules[$node['url']] ?>">
                                        </label>
                                        </th>
                                        <td style="margin: 0; padding: 0; border-bottom: 0px"><?php if(isset($node['child'])): if(is_array($node['child'])): $i = 0; $__LIST__ = $node['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><div class="rule_check">
                                                <div style="font-weight: bold;">
                                                    <label>
                                                        <input item="c_<?php echo ($node["id"]); ?>"
                                                               class="auth_rules rules_row parent_node" type="checkbox"
                                                               name="rules[]"
                                                               value="<?php echo $auth_rules[$child['url']] ?>"
                                                        <?php if(in_array( $auth_rules[$child['url']],$rules_list)): ?>checked='checked'<?php endif; ?>
                                                        /> <?php echo L($child['title']);?> </label>
                                                </div>
                                                <?php if(!empty($child['operator'])): ?><span
                                                        class="child_row" style="margin-left: 30px; display: block;">
											<?php if(is_array($child['operator'])): $i = 0; $__LIST__ = $child['operator'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$op): $mod = ($i % 2 );++$i;?><label
                                                    style="width: 126px; color: #666"<?php if(!empty($op['tip'])): ?>title='<?php echo ($op["tip"]); ?>'<?php endif; ?>> <input
                                                    class="auth_rules child_node" type="checkbox" name="rules[]"
                                                    value="<?php echo $auth_rules[$op['url']] ?>" />
												<?php echo L($op['title']);?> </label><?php endforeach; endif; else: echo "" ;endif; ?> </span><?php endif; ?>
                                            </div><?php endforeach; endif; else: echo "" ;endif; endif; ?></td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>

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
    
    <script type="text/javascript" charset="utf-8">
        $(function(){
            var rules = [<?php echo ($this_group["rules"]); ?>];

            $('.auth_rules').each(function(){
                if( $.inArray( parseInt(this.value,10),rules )>-1 ){
                    $(this).prop('checked',true);
                }
                if(this.value==''){
                    $(this).closest('span').remove();
                }
            });

            //全选节点
            $('.rules_all').on('change',function(){
                $(this).closest('.main_row').find('input').prop('checked',this.checked);
            });
            $('.rules_row').on('change',function(){

                $(this).closest('.rule_check').find('.child_row').find('input').prop('checked',this.checked);
            });

            $('.checkbox').each(function(){
                $(this).qtip({
                    content: {
                        text: $(this).attr('title'),
                        title: $(this).text()
                    },
                    position: {
                        my: 'bottom center',
                        at: 'top center',
                        target: $(this)
                    },
                    style: {
                        classes: 'qtip-dark',
                        tip: {
                            corner: true,
                            mimic: false,
                            width: 10,
                            height: 10
                        }
                    }
                });
            });

            $('select[name=group]').change(function(){
                location.href = this.value;
            });
        });
        $('.child_node').on('click',function(){
            if(this.checked){
                $(this).closest('.main_row').find('.rules_all')[0].checked=true;
            }
        });
        $('.parent_node').on('click',function(){
            if(this.checked){
                $(this).closest('.main_row').find('.rules_all')[0].checked=true;
            }
        });
    </script>

</body>

</html>