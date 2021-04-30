const autocompleteNameBtn = $('#btn-autocomplete-name');
const autocompleteEmailBtn = $('#btn-autocomplete-email');
let nameInput = $('.name');
let emailInput = $('.email');


if (document.cookie !== '') {
    let cookies = {};
    let arrayCookies = document.cookie.split(';');

    for (let i = 0; i < arrayCookies.length; i++) {
        let property = arrayCookies[i].split('=')[0].trim();
        let value = decodeURIComponent(arrayCookies[i].split('=')[1].trim());
        cookies[property] = value;
    }

    if (cookies.userName !== undefined) {
        autocompleteNameBtn.css('display', 'block');
    }
    if (cookies.userEmail !== undefined) {
        autocompleteEmailBtn.css('display', 'block');
    }

    autocompleteNameBtn.on('click', function() {
        nameInput.val(cookies.userName);
    });
    autocompleteEmailBtn.on('click', function() {
        emailInput.val(cookies.userEmail);
    });
}