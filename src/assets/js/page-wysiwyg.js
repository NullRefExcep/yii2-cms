var pageItemsList = jQuery('#pageItemsList');

pageItemsList.sortable({
    stop: function () {
        pageItemsList.find('[name$="[order]"]').each(function (index) {
            jQuery(this).val(index);
        });
    }
});

pageItemsList.disableSelection();
