
function appletree_eat(form ) {
    var appleId = $(form).find('.apple_id').val();
    console.log(appleId);
    var data = form.serialize();
    $.ajax({
        type: "POST",
        url: "/apple-tree/eat",
        data: data,
        success: function (msg) {
            console.log('success');
            console.log(msg);

            $("#apple_" + appleId).find('.eatForm').html(msg);
        },
        error: function(msg){
            console.log('error');
            console.log(msg);
            $("#apple_" + appleId).find('.eatForm').html(msg);
        }
    });
}

function appletree_drop(appleId) {
    $.ajax({
        type: "POST",
        url: "/apple-tree/drop",
        data: "id=" + appleId,
        success: function (msg) {
            $("#apple_" + appleId).animate({
                marginTop: "-=10"
            }, 10, function () {
                // Animation complete.
            });

            $("#apple_" + appleId).animate({
                marginTop: "670"
            }, 300, function () {
                // Animation complete.
            });
        }
    });
    return false;
}