form($("form"));
function form(forms) {
    forms.find("[data-prototype]").each(function() {
        enableFormCollection($(this));
    });
    forms.find(".formCollectionSortable").each(function() {
        makeFormElementsSortable($(this));
    });
}
function enableFormCollection($collectionHolder) {
    var $addCreateNew = $('<input type="button" value="Tilføj"/>');

    var children = $collectionHolder.children();
    if ($collectionHolder.is("table")) {
        children = children.filter("tbody");
    }

    children.each(function(){
        addFormCollectionDeleteLink($(this));
    });

    $addCreateNew.insertAfter($collectionHolder);

    $collectionHolder.data('index', $collectionHolder.children().length);

    $addCreateNew.on('click', function(e) {
        e.preventDefault();
        addCollectionItem($collectionHolder);
    });
}

function addCollectionItem($collectionHolder) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');

    var names = prototype.match(/__name([0-9]+)?__/);

    if (names.length > 0) {
        var regex = new RegExp(names[0],'g');
        prototype = prototype.replace(regex, index);
    }

    var newItem = $(prototype);
    $collectionHolder.data('index', index + 1);

    $collectionHolder.append(newItem);

    if ($collectionHolder.hasClass("formCollectionSortable")) {
        var positionInputs = newItem.find("input[name$='[position]']");
        positionInputs.each(function() {
            var positionInput = $(this);
            if (positionInput.closest(".formCollectionSortable").is($collectionHolder)) {
                positionInput.val(newItem.prevAll().length);
            }
        });
    }

    addFormCollectionDeleteLink(newItem)

    newItem.find("[data-prototype]").each(function() {
        enableFormCollection($(this));
    });
    newItem.find(".formCollectionSortable").each(function() {
        makeFormElementsSortable($(this));
    });
}

function addFormCollectionDeleteLink($collectionItem) {
    var $removeFormButton = $('<input type="button" value="Fjern"/>');

    var added = false;
    var controlContainers = $collectionItem.find(".collectionControls");
    if (controlContainers.length > 0) {
        controlContainers.each(function() {
            var controls = $(this);
            if (controls.parentsUntil($collectionItem,"[data-prototype]").length == 0) {
                controls.append($removeFormButton);
                added = true;
            }
        });
    }
    if (!added) {
        $collectionItem.append($removeFormButton);
    }

    $removeFormButton.on('click', function(e) {
        var parent = $collectionItem.closest("[data-prototype]");
        if (parent.hasClass("formCollectionSortable")) {
            parent.sortable("refresh");
        }

        $collectionItem.remove();
    });
}

function makeFormElementsSortable($collection) {
    $collection.sortable({
        update: function() {
            $collection.children().each(function(index) {
                var item = $(this);
                var positionInputs = item.find("input[name$='[position]']");
                positionInputs.each(function() {
                    var positionInput = $(this);
                    if (positionInput.closest(".formCollectionSortable").is($collection)) {
                        positionInput.val(index);
                    }
                });
            });
        }
    });
}