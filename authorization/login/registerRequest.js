let registerForm = $('#registerForm').get(0);

function addUser(data) {
    fetch('register.php', {
        method: 'POST',
        body: data,
    })
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            let infoMessages = $('.info-messages');
            let btn = $('.btn-register');
            if (json.result === 'success') {
                infoMessages.html('<div class="alert alert-success popup">Вы успешно зарегистрировались!</div>');
                btn.removeClass('progress-bar-striped progress-bar-animated');
                $('#registerForm').trigger("reset");
            } else if (json.result === 'failed') {
                infoMessages.html('<div class="alert alert-danger popup">Регистрация не удалась</div>');
                btn.removeClass('progress-bar-striped progress-bar-animated');
            }
    });
}

$('.register-form').submit(function(event) {
    event.preventDefault();
    let btn = $('.btn-register');
    btn.addClass('progress-bar-striped progress-bar-animated');

    let formData = new FormData(registerForm);

    addUser(formData);
});