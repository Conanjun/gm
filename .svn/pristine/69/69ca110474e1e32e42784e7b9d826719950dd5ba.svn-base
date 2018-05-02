'use strice';

var base = {
    url: 'http://site.gm.com:8010'
    // url: 'http:127.0.0.1'
}

var form = {

    // 必填提醒
    must: function () {
        $(":input.required").each(function () {
            var $required = $("<strong class='must'> *</strong>");
            $(this).parent().append($required);
        });
    },

    // 非空验证
    required: function () {
        $(':input.required').blur(function () {
            var $parent = $(this).closest('.form-group');
            if ($(this).val().length !== 0) {
                $parent.removeClass('form-status-error');
            } else {
                $parent.addClass('form-status-error');
            }
        }).keyup(function () {
            $(this).triggerHandler("blur");
        }).focus(function () {
            $(this).triggerHandler("blur");
        });
    },

    // 长度
    len: function (ele, len) {
        $(ele).blur(function () {
            var $this = $(this);
            if ($this.val() == "" || $this.val().length < len) {
                $this.closest('.form-group').addClass('form-status-error').attr('msg', '请输入正确的密码');
            } else {
                $this.closest('.form-group').removeClass('form-status-error');
            }
        }).keyup(function () {
            $(this).triggerHandler("blur");
        }).focus(function () {
            $(this).triggerHandler("blur");
        });
    },

    // 邮箱
    email: function (ele) {
        this.init(ele, /\w+[@]{1}\w+[.]\w+/, '请输入正确的邮箱');
    },

    // 手机
    phone: function (ele) {
        this.init(ele, /^1[34578]\d{9}$/, '请输入正确的手机号');
    },

    // 身份证
    sfcard: function (ele) {
        this.init(ele, /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/, '请输入正确的身份证号');
    },

    // 军官证
    // 百度来的..还没见过军官证
    jcard: function (ele) {
        this.init(ele, /南字第(\d{8})号|北字第(\d{8})号|沈字第(\d{8})号|兰字第(\d{8})号|成字第(\d{8})号|济字第(\d{8})号|广字第(\d{8})号|海字第(\d{8})号|空字第(\d{8})号|参字第(\d{8})号|政字第(\d{8})号|后字第(\d{8})号|装字第(\d{8})号/, '请输入正确的军官证');
    },

    // 护照
    pcard: function (ele) {
        this.init(ele, /^[a-zA-Z0-9]{5,17}$/, '请输入正确的护照号');
    },

    // 港澳通行证
    gcard: function (ele) {
        this.init(ele, /^[HMhm]{1}([0-9]{10}|[0-9]{8})$/, '请填写正确的港澳通行证编号');
    },

    // 银行卡
    // 这里....银行卡号的正则怎么写
    mcard: function (ele) {
        this.init(ele, /^[0-9]{16,19}$/, '请输入正确的银行卡号');
    },

    // 网址 
    site: function (ele) {
        this.init(ele, /^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*[\.。])+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&]*)?)?(#[a-z][a-z0-9_]*)?$/, '网址错误');
    },

    // 基础
    init: function (ele, reg, msg) {
        $(ele).blur(function () {
            var $this = $(this),
                $val = reg;
            // 稍微弥补效率上的过失 当验证的长度大于5的时候在执行判断
            // 这样做是因为所有应用this.init()验证的方法 不存在短位数的可能性
            if ($this.val().length > 5) {
                if ($val.test($this.val()) == false) {
                    $this.closest('.form-user-group').addClass('error').attr('msg', msg);
                } else {
                    $this.closest('.form-user-group').removeClass('error').attr('msg', '');
                }
            } else {
                $this.closest('.form-user-group').addClass('form-status-error').attr('msg', '长度不足');
            }
        }).keyup(function () {
            $(this).triggerHandler("blur");
        }).focus(function () {
            $(this).triggerHandler("blur");
        });
        // keyup跟focus太影响效率了..
    },

    // 重置
    remove: function () {
        $('.form-group').removeClass('form-status-error');
    },

    // 触发
    send: function () {
        $(":input.required").trigger('blur');
        if ($('.form-status-error').length >= 1) {
            return false;
        }
        console.log("验证通过");
    }

}

var modal = {
    open: function (ele) {
        $(ele).modal('show');
    },
    close: function (ele) {
        $(ele).modal('hide');
    },
    text: function (ele, msg) {
        $(ele).find('.modal-body').empty().text(msg);
    }
}

$(function(){

    // 全选

    // 全选 反选

    $('.check-all').on('click', function () {
        var _this = $(this),
            _table = _this.closest('table');
        
        console.log($(this).prop('checked'));
        _table.find('.check , .check-all').prop('checked',$(this).prop('checked'));
        _table.find('.icheckbox_square-green').addClass('checked');
    })

    $('td .check').on('click', function(){
        var _this   =   $(this),
            _table  =   _this.closest('table');

        if ( _table.find('.check:checked').length != _table.find('.check').length ){
            _table.find('.check-all').prop('checked', false);
        } else {
            _table.find('.check-all').prop('checked', true);
        }
    })

    // $('.check-all').on('ifChecked', function (event) {
    //     $('input').iCheck('check');
    // });  

    // $('.check-all').on('ifUnchecked', function (event) {
    //     $('input').iCheck('uncheck');
    // });  

    function getIcheckVals() {
        var checkBoxArr = [];
        $('input[name="check"]:checked').each(function () {
            checkBoxArr.push($(this).val());
            $('#checkBoxArr').val(checkBoxArr);
        });
        console.log(checkBoxArr);
    }
    
    $('#del').on('click', function(){
        getIcheckVals();
    })

    $('td .icheckbox_square-green')

    // 切换选中状态
    $('.fa-check-circle').on('click', function(){
        $(this).toggleClass('active');
    })

    // 排序状态
    $('th .fa').on('click', function(){
        // $('th .fa').removeClass('active');
        // $(this).addClass('active');
    })
    
    // 下拉菜单切值
    $('.dropdown-menu li').on('click', function(){
        //$(this).parent().prev().find('span').eq(0).text($(this).text());
    })
})