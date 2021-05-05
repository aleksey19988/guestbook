import getCookiesInObj from "../cookiesInObj.js";

const searchButton = $('.table-search__button');
let searchForm = $('.table-search__form').get(0);

function searchMessage(formData) {
    fetch('./searchMessage/searchMessageRequest.php', {
        method: 'POST',
        body: formData,
    }).then(function(response) {
        return response.json();
    }).then(function(array) {
        let cookies = getCookiesInObj(document.cookie);
        console.log(cookies);
        console.log(array);
        $('#table').children().slice(1).remove();//Перед каждым поиском очищаем таблицу (кроме шапки)
        for (let i = 0; i < array.length; i++) {
            let string = document.createElement('tr');

            let serialNum = document.createElement('td');
            serialNum.innerHTML = `${i + 1}`;
            serialNum.setAttribute('scope', 'row');
            string.appendChild(serialNum);

            let name = document.createElement('td');
            name.innerHTML = array[i].name;
            string.appendChild(name);

            let email = document.createElement('td');
            email.innerHTML = array[i].email;
            string.appendChild(email);

            if (array[i].homepage !== '') {
                let homepage = document.createElement('td');
                homepage.innerHTML = array[i].homepage;
                string.appendChild(homepage);
            } else {
                let homepage = document.createElement('td');
                homepage.innerHTML = '-';
                string.appendChild(homepage);
            }

            let text = document.createElement('td');
            text.innerHTML = array[i].text;
            string.appendChild(text);

            let dateAndTime = document.createElement('td');
            dateAndTime.innerHTML = array[i].datetime;
            string.appendChild(dateAndTime);

            if (array[i].editDateAndTime !== null) {
                let editDateAndTime = document.createElement('td');
                editDateAndTime.innerHTML = array[i].editDateAndTime;
                string.appendChild(editDateAndTime);
            } else {
                let editDateAndTime = document.createElement('td');
                editDateAndTime.innerHTML = '-';
                string.appendChild(editDateAndTime);
            }

            let tableOptions = document.createElement('td');
            tableOptions.classList.add('table-options');
            string.appendChild(tableOptions);

            if (array[i].user_id === cookies.userId) {

                let editMessageBtn = document.createElement('div');
                editMessageBtn.innerHTML = '&#9998;';
                editMessageBtn.classList.add('edit-message-button');
                tableOptions.appendChild(editMessageBtn);

                let deleteMessageBtn = document.createElement('div');
                deleteMessageBtn.innerHTML = '&#215;';
                deleteMessageBtn.classList.add('delete-message-button');
                tableOptions.appendChild(deleteMessageBtn);
            } else {
                tableOptions.innerHTML = '-';
            }
            document.getElementById('table').appendChild(string);
        }
        $.getScript('./optionsWithMessages/editMessage.js');//Подгружаем скрипт для редактирования сообщения
        $.getScript('./optionsWithMessages/deleteMessage.js');//Подгружаем скрипт для возможности удаления сообщения
    });
}

searchButton.on('click', function(event) {
    event.preventDefault();
    let formData = new FormData(searchForm);
    searchMessage(formData);
});

document.addEventListener('DOMContentLoaded', function() {//Выполняем эту функцию при загрузке страницы
    let formData = new FormData(searchForm);
    searchMessage(formData);
});