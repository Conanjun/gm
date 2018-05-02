$(function(){	
$(".item-name > i").click(function(){
    $(this).parent().parent().toggleClass("unfold");
    $(this).parent().parent().find("ul:first").slideToggle(500);
    $(this).toggleClass("unfold");
    $(this).parent().children(".filename").toggleClass("filename-open");
});

$("div[id^='check_']").click(function (){
    var t = $(this);
    var prent_key = t.attr('item');

    if(t.hasClass("c-selected")){
        if(!($('#s_check_'+prent_key).hasClass("c-selected"))){

            t.removeClass("c-selected");
            count();

        }else if($('#s_check_'+prent_key).hasClass("c-selected") && t.attr('filter')==0){

            var obj_o = $("div[id^='check_"+prent_key+"_'][group='"+group+"']");

            var count = 0;

            $.each(obj_o,function (i,q) {
                if(t.hasClass("c-selected")){
                    count = count+1;
                }
            });

            if(count>1){
                t.removeClass("c-selected");
                count();
            }
        }

    }else{
        var group = $(this).attr("group");
        var add_class = 1;
        if(group!=''){
            var obj_o = $("div[id^='check_"+prent_key+"_'][group='"+group+"']");
            $.each(obj_o,function (i,q) {
                if($(this).hasClass("c-selected")){
                    $("div[id^='check_"+prent_key+"_'][group='"+group+"']").removeClass("c-selected");
                    add_class = 0;
                    count();
                }
            });
        }
        if(add_class==1){
            t.addClass("c-selected");
            change(t,prent_key);
            count();
        }else{
            t.addClass("c-selected");
            count();
        }

    }
});
$("div[id^='s_check_']").click(function (){
    var t = $(this);
    var prent_key = t.attr('item');
    var next_key = t.attr('next');
    t.toggleClass("c-selected");
    var sg = t.attr('sg');
    var obj = sg.split(",");
    if($(this).hasClass("c-selected")){
        $("div[id^='check_"+next_key+"_'][group='']").addClass("c-selected");
        $.each(obj,function(i,d){
            $("div[id^='check_"+next_key+"_'][group='"+d+"']").first().addClass("c-selected");
        });
        count();
    }else{
        $("div[id^='check_"+next_key+"_']").removeClass("c-selected");
        count();
    }
});
$("div[id^='all_check_']").click(function (){
    var t = $(this);
    t.toggleClass("c-selected");
    var prent_key = t.attr('item');
    var s_obj = $("div[id^='s_check_"+prent_key+"_']");
    if(t.hasClass("c-selected")){
        s_obj.addClass("c-selected");
        $.each(s_obj,function (i,d) {
            var next_key = $(this).attr('next');
            $("div[id^='check_"+next_key+"_'][group='']").addClass("c-selected");
            var sg = $(this).attr('sg');
            var g_obj = sg.split(",");
            $.each(g_obj,function(a,b){
                $("div[id^='check_"+next_key+"_'][group='"+b+"']").first().addClass("c-selected");
            });
        });
        count();
    }else{
        $("div[id^='s_check_"+prent_key+"_']").removeClass("c-selected");
        $.each(s_obj,function (i,d) {
            var next_key = $(this).attr('next');
            $("div[id^='check_"+next_key+"_']").removeClass("c-selected");
        });
        count();
    }
});
});
function change(t,prent_key) {
    if(!$('#s_check_'+prent_key).hasClass("c-selected")){
        //父级选上
        $('#s_check_'+prent_key).addClass("c-selected");
        //必选的选上
        $("div[id^='check_"+prent_key+"_'][group=''][filter='1']").addClass("c-selected");
        //二选一的是否选择
        var sg = $('#s_check_'+prent_key).attr('sg');
        var obj = sg.split(",");
        $.each(obj,function(i,d){
            var is_b = 1;
            var obj_co = $("div[id^='check_"+prent_key+"_'][group='"+d+"']");
            $.each(obj_co,function (i,q) {
                if($(this).hasClass("c-selected")){
                    is_b=0;
                    return false;
                }
            });
            if(is_b==1){
                $("div[id^='check_"+prent_key+"_'][group='"+d+"']").first().addClass("c-selected");
            }
        });
    }
}

function count() {
    var obj_m = $("div[id^='s_check_']");
    var mids = [];
    obj_m.each(function(i){
        var t = $(this);
        if(t.hasClass("c-selected")){
            var mid = t.find('input').val();
            var next_key = t.attr('next');
            var option = $("div[id^='check_"+next_key+"_']");
            var ids = [];
            option.each(function(i){
                if($(this).hasClass("c-selected")){
                    var id = $(this).find('input').val();
                    ids.push(id);
                }
            });
            mids.push({"id":mid,"sub":ids});
        }
    });

    var mids = JSON.stringify(mids);
    $('#mids').val(mids);
    var param = $("#config_form").serialize();
    var ajaxurl = '/index.php?s=/Admin/OfferTools/count';
    $.ajax({
        type: 'post',
        url: ajaxurl,
        data: param,
        error: function () {
            alert('网络繁忙，请稍后再试');
        },
        success: function (response) {
            if (response.done==true) {
                $("#amount_show").show();
                $("#all_amount").html(response.retval.all_amount);
                $("#all_discount").html(response.retval.all_discount);
                $("#all_surplus").html(response.retval.all_surplus);
            }else{
                alert(response.msg);
            }
        }
    });
}