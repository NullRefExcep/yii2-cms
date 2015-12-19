
String.prototype.replaceAll = function (find, replace) {
    var str = this;
    return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
};
var pageItemsList = jQuery('#pageItemsList');
var pageItemTmpl = jQuery('#pageItemTmpl');
var blocksList = jQuery('#blocksList');
var idCounter = 1;


blocksList.on('click','[data-action="add-block"]', function(e) {
    addBlock(jQuery(this).data());
    e.preventDefault(e);
    return false;
});

pageItemsList.on('click','[data-action="remove-block"]', function(e) {
    jQuery(this).parents('.list-group-item').remove();
    e.preventDefault(e);
    return false;
});


pageItemsList.sortable({
    stop: function () {
        pageItemsList.find('[name$="[order]"]').each(function(index) {
            jQuery(this).val(index);
        });
    }
});

pageItemsList.disableSelection();

function addBlock(data) {
    var item = pageItemTmpl.clone();
    item.removeAttr('id');
    var html = item.html()
        .replaceAll(':id','new_'+(idCounter++))
        .replaceAll(':block_id',data.id)
        .replaceAll(':name',data.name)
        .replaceAll(':order',pageItemsList.find('li').length);
    item.html(html);
    pageItemsList.append(item);
    pageItemsList.sortable( "refresh" );
}