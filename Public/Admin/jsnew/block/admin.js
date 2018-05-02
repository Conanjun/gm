/**
 * Get all blocks.
 * 
 * @param  string|int $moduleID 
 * @access public
 * @return void
 */
function getBlocks(moduleID)
{
    var moduleBlock = $('#modules').parent().parent().next();
    $(moduleBlock).hide();

    $('#blockParam').empty();
    if(moduleID == '') return false;

    if(moduleID.indexOf('hiddenBlock') != -1)
    {
        getNotSourceParams('html', moduleID.replace('hiddenBlock', ''));
        return true;
    }
    if(moduleID == 'html' || moduleID == 'dynamic' || moduleID == 'flowchart')
    {
        getNotSourceParams(moduleID, blockID);
        return true;
    }

    $.get(createLink('block', 'main', 'module=' + moduleID + '&id=' + blockID), {mode:'getblocklist'}, function(data)
    {
        $(moduleBlock).html(data);
        $(moduleBlock).show();
       $.ajustModalPosition();
    })
}

/**
 * Get rss and html params.
 * 
 * @param  string $type 
 * @access public
 * @return void
 */
function getNotSourceParams(type, blockID)
{
    blockID = typeof(blockID) == 'undefined' ? 0 : blockID;
    $.get(createLink('block', 'set', 'id=' + blockID + '&type=' + type), function(data)
    {
        $('#blockParam').html(data);
        $.ajustModalPosition();
    });
}

/**
 * Get block params.
 * 
 * @param  string $type 
 * @param  int    $moduleID 
 * @access public
 * @return void
 */
function getBlockParams(type,blockID)
{
    $('#blockParam').empty();
	if(blockID==undefined){
		blockID='';
	}
    if(type == '') return;
    var url="index.php?s=Admin/index/set&id="+blockID+ '&type=' + type;
    $.get(url, function(data)
    {
        $('#blockParam').html(data);
        $.ajustModalPosition();
    });
}

$(function()
{
    if($('#moduleBlock').size() > 0) getBlockParams($('#moduleBlock').val(),blockID);

    $(document).on('click', '.dropdown-menu.buttons .btn', function()
    {
        var $this = $(this);
        var group = $this.closest('.input-group-btn');
        group.find('.dropdown-toggle').removeClass().addClass('btn dropdown-toggle btn-' + $this.data('id'));
        group.find('input[name^="params[color]"]').val($this.data('id'));
    });
})
