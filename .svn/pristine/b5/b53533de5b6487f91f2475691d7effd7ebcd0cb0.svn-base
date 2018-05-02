/* 多级选择相关函数，如地区选择，分类选择
 * multi-level selection
 */

/* 地区选择函数 */
function regionInit(divId)
{
    $("#" + divId + " > select").change(regionChange); // select的onchange事件

   if(grid!=undefined&&grid>0){
   	regionload(grid);
   }
}

var r1=0;
var r2=0;
var r3=0;
var REAL_SITE_URL="__ROOT__";

function regionload(id){
    //var url = REAL_SITE_URL + '/index.php?app=mlselection&type=regionload';
    var url = '/index.php?s=/Admin/Mlselection/index&type=regionload';
    $.getJSON(url, {'pid':id}, function(data){
        if (data.done)
        {
            if (data.retval!=undefined&&data.retval.length > 0)
            {
                r1=data.retval[0];
                r2=data.retval[1];
                r3=data.retval[2];

                if(r1>0){
                    $("#region").find("select").val(r1);
                    $("#region").find("select").trigger("change");
                    r1=0;
                }
            }
        }
    });
}


function regionChange()
{
    // 删除后面的select
    $(this).nextAll("select").remove();

    // 计算当前选中到id和拼起来的name
    var selects = $(this).siblings("select").andSelf();
    var id = 0;
    var names = new Array();
    var ids = new Array();
    for (i = 0; i < selects.length; i++)
    {
        sel = selects[i];
        if (sel.value > 0)
        {
            id = sel.value;
            name = sel.options[sel.selectedIndex].text;
            names.push(name);
            ids.push(id);
        }
    }
    $(".mls_id").val(id);
    $(".mls_name").val(name);
    $(".mls_names").val(names.join("\t"));
    $(".mls_ids").val(ids.join(','));


    // ajax请求下级地区
    if (this.value > 0)
    {
        var _self = this;
        var url = '/index.php?s=/Admin/Mlselection/index&type=region';
        $.getJSON(url, {'pid':this.value}, function(data){
            if (data.done)
            {
                if (data.retval!=undefined&&data.retval.length > 0)
                {
                    $("<select class=\"form-control\"><option>" + "请选择..." + "</option></select>").change(regionChange).insertAfter(_self);
                    var data  = data.retval;
                    for (i = 0; i < data.length; i++)
                    {
                        $(_self).next("select").append("<option value='" + data[i].region_id + "'>" + data[i].region_name + "</option>");
                    }

                    if(selects.length==1&&r2>0){
                        $(_self).next("select").val(r2);
                        $(_self).next("select").trigger("change");
                        r2=0;
                    }
                    if(selects.length==2&&r3>0){
                        $(_self).next("select").val(r3);
                        $(_self).next("select").trigger("change");
                        r3=0;
                    }

                }
            }
            else
            {
                alert(data.msg);
            }
        });
    }
}
