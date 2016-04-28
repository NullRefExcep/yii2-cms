/**
 * @author    Yaroslav Velychko
 */
jQuery(function () {
    var tree = jQuery("#fancyree_blocksTree");
    app.initTree = function () {
        tree.fancytree("getTree").generateFormElements("Generator[blocks][]");
    };
    app.selectTreeNode = app.initTree;
});