<?php if (!defined('THINK_PATH')) exit();?>

    <script>
        var grid = 0;
        $(function(){
            regionInit("region");
        });
    </script>
    <!-- content begin -->
    <div class="wrapper wrapper-content">
        <div id="form" class="form-horizontal" >
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo L('REGION');?></label>
                <div id="region" class="col-sm-10">
                    <input type="hidden" name="regionid"  class="mls_ids" />
                    <input type="hidden" name="regionname"  class="mls_names" />
                    <select class="form-control" name="regid">
                        <option value=""><?php echo L('PLEASE_SELECT');?></option>
                        <?php if(is_array($regions)): $i = 0; $__LIST__ = $regions;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["region_id"]); ?>" <?php if($vo["region_id"] == $Think.get.regionid): ?>selected<?php endif; ?>><?php echo ($vo["region_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <?php if($_GET['regionid']> 0): ?><script>
                            grid=<?php echo ($_GET['regionid']); ?>;
                        </script><?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo L('ADDR');?></label>
                <div class="col-sm-10">
                    <input type="text" name="addr" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo L('SNEE');?></label>
                <div class="col-sm-10">
                    <input type="text" name="snee" class="form-control" value="<?php echo ($list["snee"]); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo L('TEL');?></label>
                <div class="col-sm-10">
                    <input type="text" name="snee_tel" class="form-control" value="<?php echo ($list["snee_tel"]); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo L('ISDEFAULT');?></label>
                <div class="col-sm-10">
                    <div class="radio  radio-inline"><input type="radio" value="1" name="isdefault" checked id="enabled1"> <label for="enabled1"><?php echo L('YES');?></label></div>
                    <div class="radio  radio-inline"><input type="radio" value="0" name="isdefault" id="enabled2"> <label for="enabled2"><?php echo L('NO');?></label></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <button class="btn btn-primary" name="add_save"><?php echo L('SAVE');?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- content end -->
    <script>
        $(function(){
            $(document).on('click',"[name='add_save']", function(){
            // $("[name='save']").click(function(){
                var  regionid =  $("[name='regionid']").val();
                var  regionname =  $("[name='regionname']").val();
                var  addr =  $("[name='addr']").val();
                var  snee =  $("[name='snee']").val();
                var  snee_tel =  $("[name='snee_tel']").val();
                if(regionid == '' || regionid == null || regionid == undefined){
                    $("[name='regid']").parent().addClass('error');
                    return false;
                }
                if(addr == null || addr == '' || addr == undefined){
                    $("[name='addr']").parent().addClass('error');
                    return false;
                }
                if(snee == null || snee == '' || snee == undefined){
                    $("[name='snee']").parent().addClass('error');
                    return false;
                }
                if(snee_tel == null || snee_tel == '' || snee_tel == undefined){
                    $("[name='snee_tel']").parent().addClass('error');
                    return false;
                }
                var isdefault = $("[name='isdefault']:checked").val();
                $.post(
                    "<?php echo U('Addess/add');?>",
                    { regionid:regionid,regionname:regionname,addr:addr,isdefault:isdefault,snee:snee,snee_tel:snee_tel},
                    function(data){
                        if(data.done){
                            order_choose({addr_id:data.addr_id,regionname:regionname+' '+addr,snee:snee,snee_tel:snee_tel});
                        }else{
                            alert(data.msg);
                        }
                    },'json'
                );
            });
        });
    </script>