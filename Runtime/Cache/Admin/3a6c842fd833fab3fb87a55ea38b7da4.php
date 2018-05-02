<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo L('logotitle');?></title>

    <link href="/Admin/css/in/bootstrap.min.css" rel="stylesheet">
    <link href="/Admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/Admin/css/in/animate.css" rel="stylesheet">
    <link href="/Admin/css/in/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/Admin/css/stylesheet.css">

</head>

<body class="white-bg">

    <div id="page">

        <!-- <div id="page-header"></div> -->
        <div id="page-main">
            <div class="form-user clearfix">
                <div class="pull-right form-user-main">

                    <h2><?php echo L('welcomlogoin');?></h2>

                    <form data-action="<?php echo U('login');?>" method="post">
                        <input type="hidden" name="r" value="<?php echo ($r); ?>" />
                        <!-- group -->
                        <div class="form-user-group form-user-user">
                            <label for=""><?php echo L('lusername');?></label>
                            <div class="form-user-control">
                                <input type="text" autocomplete="off" name="username" placeholder="<?php echo L('plusername');?>" autofocus>
                            </div>
                        </div>

                        <!-- group -->
                        <div class="form-user-group form-user-lock">
                            <label for=""><?php echo L('lpassword');?></label>
                            <div class="form-user-control">
                                <input type="password" name="password" placeholder="<?php echo L('plpassword');?>">
                            </div>
                        </div>

                        <div class="form-user-button">
                            <input type="button" class="form-user-submit" value="<?php echo L('dologin');?>">
                        </div>
                    </form>
                </div>
                <div class="pull-right form-user-logo">
                    <h1 class="logo"><img src="Admin/images/logo_red.png" style="width: 50%"></h1>
                    <h2><?php echo L('SYSTITLE');?></h2>
                </div>
            </div>
        </div>

        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

    </div>

    <!-- Mainly scripts -->
    <script src="/Admin/js/in/jquery-2.1.1.js"></script>
    <script src="/Admin/js/in/bootstrap.min.js"></script>
    <script src="/Admin/js/in/base.js"></script>
    <script src="/Admin/js/in/iviews.extend.js"></script>
    <script>
    
        $(function(){

            // 模拟select
            var 
                $form_folder        =       $('.form-user-folder') ,
                $form_user          =       $('.form-user-user') ,
                $form_pass          =       $('.form-user-lock') ,
                $form_select        =       $('.form-user-select') ,
                $form_group         =       $('.form-user-group') ,
                $modal              =       $('#loginModal') ,
                $modal_msg          =       $('#loginModal .modal-body');

            $form_folder.focusin(function(){
                $form_select.slideDown();
            }).focusout(function(){
                $form_select.slideUp();
            })

            // $form_group.focusin(function () {
            //     $(this).closest('.form-user-group').addClass('focus');
            // }).focusout(function () {
            //     $(this).closest('.form-user-group').removeClass('focus');
            // })

            // $form_select.find('li').on('click', function(){
            //     var $this = $(this) ,
            //         $val  = $this.attr('data-value');

            //     $form_folder.find('input').attr('data-value', $val).val($this.text());
            // })

            // $form_group.find('input').keyup(function(){
            //     form.len($form_group, 6);
            // })

            $('.form-user-group').focusout(function () {
                if ($(this).find('input').val().length == '') {
                    $(this).addClass('error');
                    return false
                }
            }).focusin(function () {
                if ($(this).hasClass('error')) {
                    $(this).removeClass('error');
                }
            })

            $('.form-user-submit').on('click', function(){

                $('.form-user-group').trigger('focusout');

                if ( $('.error').length>0 ) {
                    $.alert('提示','请输入正确的用户信息');
                    return false;
                }

                var 
                    $username       =       $form_user.find('input').val() ,
                    $password       =       $form_pass.find('input').val() ,
                    $type           =       $form_folder.find('input').val() ,
                    $typeid         =       $form_folder.find('input').attr('data-value') ,
                    $data           =       {
                        username: $username ,
                        password: $password , 
                        type    : $type ,
                        typeid  : $typeid
                    }
                
                // console.log($(this).closest('form').attr('action'));
                // console.log(base.url + $(this).closest('form').attr('action'))
                // return false;
                $.ajax({
                    url: base.url + $(this).closest('form').attr('data-action') ,
                    type: 'POST' ,
                    data: $data ,
                    dataType: 'json' ,
                    beforeSend: function() {

                    },
                    success: function(res) {
                        // console.log('----success');
                        // console.log(res);
                        if( res.status == 1 ) {
                            window.location.href = res.url;
                        } else {
                            modal.text($modal, res.info);
                            modal.open($modal);
                        }
                    },
                    error: function(err) {
                        // console.log('----error');
                        // console.log(err);
                    }
                    
                })
            })
            
        })

    </script>

</body>

</html>