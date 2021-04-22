const requiredInputs = [
    $('.name'),
    $('.email'),
    $('.text'),
]
// const name = $('.name');
// const email = $('.email');
// const text = $('.text');
const addButton = $('#btn-form');
const previewButton = $('#btn-preview');

const handleChange = () => {
    for	(const input of requiredInputs) {
        if (input.val() === "") {
            addButton.attr('disabled', 'disabled');
            previewButton.attr('disabled', 'disabled');
            return;
        }
    }
    addButton.removeAttr('disabled');
    previewButton.removeAttr('disabled');
}

// for (const input of requiredInputs) {
//     input.onkeydown = input.onkeyup = input.onkeypress = input.change = handleChange;
// }

