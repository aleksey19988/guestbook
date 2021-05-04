const editButton = $('.edit-message-button');
const cancelEditMessageButton = $('.cancel-edit-message-button');
const editMessageWindow = $('.edit-message-window-container');
const saveNewMessage = $('.save-edit-message-button');
let editMessageInput = $('.edit-message-input');
let editMessageForm = $('.edit-message-form').get(0);
let dateAndTime = null;
let updatePageButton = $('.update-page-button-after-edit-message');

function submitEditMessage(formData) {
    fetch('./optionsWithMessages/editMessage.php', {
        method: 'POST',
        body: formData,
    }).then(function(response) {
        return response.json();
    }).then(function(json) {
        if (json.result === 'success') {
            $('.edit-form').css('display', 'none');//скрываем форму для ввода нового сообщения
            $('.edit-status-success').css('display', 'block');//Отображаем успешный статус записи нового сообщения в таблицу
        } else {
            $('.edit-form').css('display', 'none');//скрываем форму для ввода нового сообщения
            $('.edit-status-failed').css('display', 'block');//Отображаем ошибочный статус записи нового сообщения в таблицу
        }
    });
}

editButton.on('click', function(btn) {
    let textMessage = $(this).closest('tr').get(0).children[4].innerHTML.trim();//Да, 4 - магическое число, но я не понял как ещё добраться до одного из группы элементов с одинаковыми селекторами
    editMessageInput.val(`${textMessage}`);
    editMessageWindow.css('display', 'flex');
    dateAndTime = $(this).closest('tr').get(0).children[5].innerHTML.trim();//Получаем дату и время создания редактируемого сообщения
});

saveNewMessage.on('click', function(event) {
    event.preventDefault();
    let formData = new FormData(editMessageForm);
    formData.append('dateAndTime', dateAndTime);//добавляем в запрос поле с датой и временем создания сообщения, чтобы найти и отредактировать нужное в таблице (должны найти по первичному ключу, но как его увидеть без отображения в разметке - не знаю)
    submitEditMessage(formData);
});

cancelEditMessageButton.on('click', function() {
    editMessageWindow.css('display', 'none');
});

updatePageButton.on('click', function() {
   location.reload();
});