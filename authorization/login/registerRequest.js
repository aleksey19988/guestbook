let registerForm = $('#registerForm').get(0);
let logInBtn = $('.log-in-btn');

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
                let linkSignIn = '<a href="../signIn/sign-in.php" class="log-in-btn__text">войдём</a>';
                let alert = '<div class="alert alert-success popup">' + `Это было классно, ${json.name}!<br><br>Может быть ${linkSignIn}?` + '</div>';
                infoMessages.html(alert);
                $('#registerForm').trigger("reset");
            } else if (json.result === 'failed') {
                let alert = '<div class="alert alert-danger popup">' + `${json.details}` + '</div>';
                infoMessages.html(alert);
                btn.removeClass('progress-bar-striped progress-bar-animated');
            } else {
                let linkSignIn = '<a href="../signIn/sign-in.php" class="log-in-btn__text">войдём</a>';
                let alert = '<div class="alert alert-danger popup">' + `${json.details}. <br><br>Может быть ${linkSignIn}?` + '</div>';
                infoMessages.html(alert);
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
    $('.log-in-btn__text').css({'color': '#002cdb', 'text-decoration': 'underline'});
});