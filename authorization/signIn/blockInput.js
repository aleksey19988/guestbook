let emailInput = $('#exampleInputEmail1');
let nicknameInput = $('#nickname');

function blockInput() {
    if (emailInput.val() !== '') {
        nicknameInput.attr('disabled', 'disabled');
        return;
    } else if (nicknameInput.val() !== '') {
        emailInput.attr('disabled', 'disabled');
        return;
    }
    nicknameInput.removeAttr('disabled');
    emailInput.removeAttr('disabled');
}