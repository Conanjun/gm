$.extend({
    menu: function () {
        return $('#side-menu li > ul > li.active').closest('ul').addClass('in').parent().closest('li').addClass('active');
    },

    mask: {
        open: function (e) {
            var $mask = '<div class="modal-backdrop fade in"><div class="loader-inner pacman"><div></div><div></div><div></div><div></div><div></div></div></div>';
            return $('body').append($mask);
        },
        close: function () {
            return $('body').find('.modal-backdrop').fadeOut(function(){
                $(this).remove();
            })
        }
    }
})