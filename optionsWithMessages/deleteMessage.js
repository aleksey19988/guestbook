const deleteMessageButton = $('.delete-message-button');
const cancelDeleteMessageButton = $('.cancel-delete-message-button');
const deleteMessageWindow = $('.delete-message-window-container');
const agreeDeleteMessageButton = $('.agree-delete-message-button');
let dateAndTimeCreateMessage = null;

function submitDeleteMessage(formData) {
    fetch('./optionsWithMessages/deleteMessage.php', {
        method: 'POST',
        body: formData,
    }).then(function(response) {
        return response.json();
    }).then(function(json) {
        if (json.result === 'success') {
            $('.delete-message-content').css('display', 'none');
            $('.delete-message-status-success').css('display', 'block');
        } else {
            $('.delete-message-content').css('display', 'none');
            $('.delete-message-status-failed').css('display', 'none');
        }
    })
}

deleteMessageButton.on('click', function() {
    deleteMessageWindow.css('display', 'flex');
    dateAndTimeCreateMessage = $(this).closest('tr').get(0).children[5].innerHTML.trim();//Получаем дату и время создания редактируемого сообщения пока через одно место..
});

cancelDeleteMessageButton.on('click', function() {
    deleteMessageWindow.css('display', 'none');
});

agreeDeleteMessageButton.on('click', function() {
    let formData = new FormData();
    formData.append('dateAndTime', dateAndTimeCreateMessage);//добавляем в запрос поле с датой и временем создания сообщения, чтобы найти и отредактировать нужное в таблице (должны найти по первичному ключу, но как его увидеть без отображения в разметке - не знаю)

    submitDeleteMessage(formData);
})
