$("input.route").each(function() { var input = $(this); input.data("originalRoute", input.val()); }).change(function() {
    var input = $(this);
    var route = input.val();
    var originalRoute = input.data("originalRoute");
    var formGroup = input.closest(".form-group");
    if (route != originalRoute) {
        $.get(route, function() {
            formGroup.addClass("has-error").removeClass("has-success");
        }).fail(function() {
            formGroup.addClass("has-success").removeClass("has-error");
        });
    } else {
        formGroup.addClass("has-success").removeClass("has-error");
    }
});