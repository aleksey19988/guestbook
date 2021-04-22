let myForm = $('#my-form').get(0);
let files = $('#formFile').get(0).files;
let infoMessages = $('.info-messages');

function submitHandler(formData) {
    fetch('foo.php', {
        method: 'POST',
        body: formData,
    })
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            let infoMessages = $('.info-messages');
            let btn = $('#btn-form');
            console.log(json);
            if (json.result === 'success') {
                infoMessages.html('<div class="alert alert-success popup">Сообщение отправлено!</div>');
                btn.removeClass('progress-bar-striped progress-bar-animated');
                $('#my-form').trigger("reset");
            } else if (json.result === 'failed') {
                infoMessages.html('<div class="alert alert-danger popup">Сообщение не отправлено! (введён уже существующий e-mail или используется некорректный домен)</div>');
                btn.removeClass('progress-bar-striped progress-bar-animated');
            } else {
                infoMessages.html(`<div class="alert alert-danger popup">${json.result}</div>`);
                btn.removeClass('progress-bar-striped progress-bar-animated');
            }
        });
};

$('.my-form').submit(function (event) {
    event.preventDefault();
    let btn = $('#btn-form');
    btn.addClass('progress-bar-striped progress-bar-animated');
    let formData = new FormData(myForm);

    if (files.length > 0) {
        formData.append(files[0].name, files[0]);
    }

    submitHandler(formData);
});

function displayPopup(popup) {
    return popup;
}