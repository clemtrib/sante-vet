$(function () {
    $(".productLink").on("click", function (event) {
        var id = $(this).attr('id').substring(2, $(this).attr('id').length);
        if (readCookie('lbc' + id) == 1) {
            return true;
        }
        event.preventDefault();
        var href = $(this).attr('href');
        $.ajax({
            url: "/app_dev.php/ajax/visit/" + id,
            context: document.body,
            success: function (code_html, statut) {
                writeCookie('lbc' + id, 1, 180, function () {
                    window.location = href;
                });
            },
            failure: function (code_html, statut) {
                window.location = href;
            }
        });
    });
});

function writeCookie(name, value, days, fnCallback) {
    var date, expires;
    if (days) {
        date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
    fnCallback();
}

function readCookie(name) {
    var i, c, ca, nameEQ = name + "=";
    ca = document.cookie.split(';');
    for (i = 0; i < ca.length; i++) {
        c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1, c.length);
        }
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
    return '';
}