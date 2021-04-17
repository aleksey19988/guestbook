$('.my-form').submit(function (e) {
    e.preventDefault();
    let form = $(this);
    let infoMessages = $('.info-messages');
    let btn = form.find('#btn-form');
    btn.addClass('progress-bar-striped progress-bar-animated');

    $.ajax('foo.php',
        {
            type: "POST",
            url: "foo.php",
            data: $(this).serialize(),
            success: function(response) {
                let jsonData = JSON.parse(response);
                if (jsonData.success === 1) {
                    infoMessages.html('<div class="alert alert-success">Сообщение отправлено!</div>');
                    btn.removeClass('progress-bar-striped progress-bar-animated');
                    form.trigger("reset");
                } else {
                    infoMessages.html('<div class="alert alert-danger">Сообщение не отправлено! (введён уже существующий e-mail или используется некорректный домен)</div>');
                    btn.removeClass('progress-bar-striped progress-bar-animated');
                    return false;
                }
            },
    })
});