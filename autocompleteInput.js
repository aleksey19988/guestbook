import getCookiesInObj from "./cookiesInObj.js";

const autocompleteNameBtn = $('#btn-autocomplete-name');
const autocompleteEmailBtn = $('#btn-autocomplete-email');
let nameInput = $('.name');
let emailInput = $('.email');


if (document.cookie !== '') {
    let cookies = getCookiesInObj(document.cookie);

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