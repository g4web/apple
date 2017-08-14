function apple_eat(form) {
    var appleId = $(form).find('.apple_id').val();
    var data = form.serialize();
    $.ajax({
        type: "POST",
        url: "/apple-tree/eat",
        data: data,
        success: function (msg) {
            if (msg === 'done') {
                $("#apple_" + appleId).hide();
            }
            $("#apple_" + appleId).find('.dropdown-menu').html(msg);
        }
    });
}

function apple_drop(appleId) {
    $.ajax({
        type: "POST",
        url: "/apple-tree/drop",
        data: "id=" + appleId,
        success: function (msg) {
            $("#apple_" + appleId).find('.dropdown-menu').html(msg);

            $("#apple_" + appleId).animate({
                marginTop: "670"
            }, 300);
        }
    });
    return false;
}