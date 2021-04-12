const isCheckboxOrRadio = (type) => ['radio', 'checkbox'].includes(type);

const {form} = document.forms;
const previewForm = document.getElementById('btn-preview');
const previewContent = document.getElementById('preview');
const editMessage = document.getElementById('btn_edit_message');
const previewMessageContent = document.getElementById('message_content');
const previewWithoutRequiredFields = document.getElementById('preview_without_required_fields');
const addRequireedValues = document.getElementById('btn_add_required_values');
const closeButtonPreview = document.getElementById('close_button_preview');
const closeButton = document.getElementById('close_button');

const requiredFields = {
    name: '',
    email: '',
    message: '',
};

const isRequiredFieldsInput = function(requiredFields, fields) {
    let result = '';
    for (let key in requiredFields) {
        if (fields[key] === '') {
            result = false;
            return;
        } else {
            result = true;
        }
    }
    return result;
};

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

    if (isRequiredFieldsInput(requiredFields, values)) {
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
    } else {
        previewWithoutRequiredFields.style.display = 'flex';
    };
});

editMessage.addEventListener('click', function() {
    previewContent.style.display = 'none';
});

addRequireedValues.addEventListener('click', function() {
    previewWithoutRequiredFields.style.display = 'none';
});

closeButton.addEventListener('click', function() {
    previewWithoutRequiredFields.style.display = 'none';
});
closeButtonPreview.addEventListener('click', function() {
    previewContent.style.display = 'none';
});