const isCheckboxOrRadio = type => ['radio', 'checkbox'].includes(type);

const {form} = document.forms;
const previewForm = document.getElementById('btn-preview');
const previewContent = document.getElementById('preview');
const editMessage = document.getElementById('btn_edit_message');
const previewMessageContent = document.getElementById('message_content');

previewForm.addEventListener('click', function getFormValues(event) {
    event.preventDefault();
    const values = {};

    for (let field of form) {
        const {name} = field;

        if (name) {
            const {type, checked, value} = field;
            values[name] = isCheckboxOrRadio(type) ? checked : value;
        }
    }
    previewMessageContent.innerHTML = '';
    let elem = document.createElement("td");
    elem.innerHTML = '#';
    previewMessageContent.appendChild(elem);

    for (let key in values) {
        let elem = document.createElement("td");
        elem.innerHTML = values[key];
        previewMessageContent.appendChild(elem);
    }

    previewContent.style.display = 'flex';
});

editMessage.addEventListener('click', function() {
    previewContent.style.display = 'none';
});