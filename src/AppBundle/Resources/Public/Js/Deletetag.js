jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.tags');

    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // ... the rest of the block from above
});

function addTagForm() {
    // ...

    // add a delete link to the new form
    addTagFormDeleteLink($newFormLi);
}
function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#">delete this tag</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });
}