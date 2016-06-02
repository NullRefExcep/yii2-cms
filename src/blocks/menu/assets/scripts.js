jQuery(function () {


    app.menuEditor = new MenuEditor(jQuery("#fancyree_menuTree"), jQuery('#nodeForm'));
});

function MenuEditor(tree, form) {
    var parentForm = tree.parents('form');
    var itemsInput = parentForm.find('#itemsInput');
    var titleInput = form.find('#titleInput');
    var urlInput = form.find('#urlInput');
    var linkManger = jQuery('#linkManger');
    var activeNode;

    function selectItem(event, data) {
        activeNode = data.node;
        openForm(data.node);
    }

    function openForm(node) {
        if ((node.data)) {
            if (node.data.type) {
                urlInput.parents('.form-group').hide();
            } else {
                urlInput.parents('.form-group').show();
            }
            titleInput.val(node.title);
            titleInput.attr('readonly', false);
            removeBtn.attr('disabled', false);
            saveBtn.attr('disabled', false);
            urlInput.val((node.data && node.data.url) || '');
        }
    }

    jQuery('#addSelectedItems').on('click', function (e) {

        linkManger.find('input[type="checkbox"]:checked').each(function (index, item) {
            var input = jQuery(item);
            addItem({
                title: input.parent().text().trim(),
                url: input.val(),
                type: input.parents('.link-section').data('type')
            });
        });
        e.preventDefault(e);
        return false;
    });

    var removeBtn = jQuery('#removeItem');
    removeBtn.attr('disabled', true);
    removeBtn.on('click', function (e) {
        if (activeNode) {
            activeNode.remove();
            urlInput.parents('.form-group').hide();
            titleInput.val('');
            activeNode = null;
            titleInput.attr('readonly', true);
            removeBtn.attr('disabled', true);
            saveBtn.attr('disabled', true);
        }
        e.preventDefault(e);
        return false;
    });

    var saveBtn = jQuery('#saveItem');
    saveBtn.attr('disabled', true);
    saveBtn.on('click', function (e) {
        var activeNode = tree.fancytree('getActiveNode');
        if (activeNode) {
            activeNode.setSelected(true);
            activeNode.title = titleInput.val();
            activeNode.data.url = urlInput.val();
            activeNode.selected = true;
            activeNode.render(true);
        }
        e.preventDefault(e);
        return false;
    });

    jQuery('#addItem').on('click', function (e) {
        addItem({title: 'New Node', url: '/'});
        e.preventDefault(e);
        return false;
    });


    parentForm.on('beforeSubmit', function () {
        var d = tree.fancytree('getRootNode').toDict(true, function (dict) {
            delete dict.key;
            delete dict.expanded;
        });
        itemsInput.val(JSON.stringify(d.children));
    });

    tree.bind('fancytreeactivate', selectItem);

    function addItem(data) {
        var rootNode = tree.fancytree('getRootNode');
        rootNode.addChildren({
            title: data.title,
            url: data.url,
            type: data.type
        });
    }

    return {
        addItem: addItem
    }
}

app = {};

app.menuTreeDnd = {
    autoExpandMS: 400,
    focusOnClick: true,
    preventVoidMoves: true,
    preventRecursiveMoves: true,
    dragStart: function (node, data) {
        return true;
    },
    dragEnter: function (node, data) {
        return true;
    },
    dragDrop: function (node, data) {
        data.otherNode.moveTo(node, data.hitMode);
    }
};