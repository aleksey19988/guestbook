let signInForm = $('.sign-in-form');

function loginUser(data) {
    fetch('signIn-script.php', {
        method: 'POST',
        body: data,
    })
        .then(function(response) {
            return response.json();
        }).then(function(json) {
        let infoMessages = $('.info-messages');
        let btn = $('.btn-sign-in');
        if (json.result === 'success') {
            let alert = '<div class="alert alert-success popup">Привет, ' + `${json.name}` + '</div>';
            infoMessages.html(alert);
            btn.removeClass('progress-bar-striped progress-bar-animated');
        } else if (json.result === 'failed') {
            let alert = '<div class="alert alert-danger popup">' + `${json.error}! Ты точно всё проверил?` + '</div>';
            infoMessages.html(alert);
            btn.removeClass('progress-bar-striped progress-bar-animated');
        }
    })
}

signInForm.submit(function(event) {
   event.preventDefault();

    let btn = $('.btn-register');
    btn.addClass('progress-bar-striped progress-bar-animated');

    let formData = new FormData(signInForm.get(0));
    loginUser(formData);
});


