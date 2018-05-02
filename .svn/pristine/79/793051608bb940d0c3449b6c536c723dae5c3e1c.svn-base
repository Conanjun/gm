$.extend({
    menu: function () {
        return $('#side-menu li > ul > li.active').closest('ul').addClass('in').parent().closest('li').addClass('active');
    },

    mask: {
        open: function (e) {
            var $mask = '<div class="modal-backdrop fade in mask-loading"><div class="loader-inner pacman"><div></div><div></div><div></div><div></div><div></div></div></div>';
            return $('body').append($mask);
        },
        close: function () {
            return $('body').find('.modal-loading').fadeOut(function(){
                $(this).remove();
            })
        }
    },

    full: {
        open: function() {
            $('.iviews-order-mask').css({
                'width': $(window).width(),
                'height': $(window).height(),
                'left': -($('.navbar-default').width() + 17),
                'top': $(window).scrollTop() - 60
                // 'top': -$('#page-wrapper > .border-bottom').eq(0).height()
            })
            $('body').addClass('hasMask');
            $('#page-wrapper > .border-bottom').eq(0).addClass('hasMask');
            $('#page-wrapper > .wrapper').eq(0).addClass('hasMask');
        },
        close: function() {
            $('body').removeClass('hasMask');
            $('#page-wrapper > .border-bottom').eq(0).removeClass('hasMask');
            $('#page-wrapper > .wrapper').eq(0).removeClass('hasMask');
        },
        resize: function() {
            var _this = this;
            if( $('body').hasClass('hasMask') ) {
                $(window).resize(function () {
                    _this.open();
                })
            }
        }
    },

    del: {

        arr: function (ele) {
            var delArr = [];
            
            $(ele).find('input[name="check"]:checked').each(function () {
                delArr.push($(this).val());
            });
            
            return delArr;
        },

        all: function (ele, url) {
            console.log(this.arr(ele))
            $.ajax({
                url: url,
                method: 'post',
                type: 'json',
                data: {
                    id: this.arr(ele)
                },
                success: function(res) {
                    if ( res.done ) {
                        // $.modal.show('#result');
                        // alert(res.url);
                        // window.location.reload;
                        $('body').append('<div class="modal-backdrop" style="background: rgba(0,0,0,.3)"></div><div class="modal fade in" style="display: block">' +
                                            '<div class="modal-dialog">' +
                                            '<div class="modal-content">' +
                                            '<div class="modal-header">' +
                                            '<a class="close" href="#" data-dismiss="modal">×</a>' +
                                            '<h3>删除提示</h3>' +
                                            '</div>' +
                                            '<div class="modal-body inner">'+res.msg+'</div>' +
                                            '</div>' +
                        '</div>');

                        $('.close').on('click', function(){
                            window.location.reload();
                            return false;
                        })
                    }
                    // if ( res.done || res.status ) {
                    //     var fail = res.data.fail ,
                    //         succ = [];
                        
                    //     if (res.data.succ.constructor == Array ) {
                    //         succ = res.data.succ;
                    //     } else if (res.data.succ.constructor == Object ) {
                    //         for ( x in res.data.succ ) {
                    //             succ.push(res.data.succ[x]);
                    //         }

                    //         for ( var i = 0; i < succ.length; i++ ) {
                                
                    //         }

                    //     } else {
                    //         alert(typeof res.data.succ, res.data.succ.constructor);
                    //     }
                        
                    //     console.log(succ);
                    // } else {
                    //     console.log(res);
                    // }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        },

        sin: function () {

        }

    },

    alert: function( title , content ) {

        var title   =   title || '提示' ,
            content =   content || '错误提示' ;

        var modal = '<div class="modal modal-alert" style="background-color: rgba(0,0,0,.5)">' +
                        '<div class="modal-dialog">' +
                            '<div class="modal-content">' +
                            '<div class="modal-header">' +
                                '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<h4 class="modal-title">' +title + '</h4>' +
                            '</div>' +
                            '<div class="modal-body inner">' + content + '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
        
        $('body').append(modal);
        $('.modal-alert').fadeIn();

        $('.modal .close').on('click', function(){
            $(this).closest('.modal-alert').fadeOut(function(){
                $(this).remove();
            })
        })
    }
})