const editButton = $('.edit-message-button');
const cancelEditMessageButton = $('.cancel-button');
const editMessageWindow = $('.edit-message-window-container');
let editMessageInput = $('.edit-message-input');

editButton.on('click', function(btn) {
    let textMessage = $(this).closest('tr').get(0).children[4].innerHTML.trim();//Да, 4 - магическое число, но я не понял как ещё добраться до одного из группы элементов с одинаковыми селекторами
    editMessageInput.val(`${textMessage}`);
    editMessageWindow.css('display', 'flex');
    console.log(textMessage);
});

cancelEditMessageButton.on('click', function() {
    editMessageWindow.css('display', 'none');
});