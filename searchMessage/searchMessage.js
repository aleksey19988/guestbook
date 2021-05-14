import getCookiesInObj from "../cookiesInObj.js";

const searchButton = $('.table-search__button');
let searchForm = $('.table-search__form').get(0);
let isLoadScript = false;
let requestAddress = './searchMessage/searchMessageRequest.php';

function loadingScript() {
    $.getScript('./optionsWithMessages/editMessage.js');//Подгружаем скрипт для редактирования сообщения
    $.getScript('./optionsWithMessages/deleteMessage.js');//Подгружаем скрипт для возможности удаления сообщения
    $.getScript('./pages.js');
}

function getUrlVars() {
    let vars = {};
    let parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}


function searchMessage(formData) {
    fetch(`${requestAddress}`, {
        method: 'POST',
        body: formData,
    }).then(function(response) {  //этот then для получения контента таблицы в виде json
        return response.json();
    }).then(function(json) {  //этот then для генерации контента таблицы
        $('#table-content').children().remove();//Перед каждым поиском очищаем тело таблицы (шапка остаётся)
        let cookies = getCookiesInObj(document.cookie);//Получаем куки, чтобы понимать авторизован ли пользователь (в последующем смотрим, отрисовывать значки редактирования/удаления или нет)
        let pages = json['pages'];
        delete json['pages'];
        let firstCount = json['page'] * 25;//Получаю порядковый номер первой строки в таблице
        delete json['page'];//Удаляем из объекта значене с ключом page, так как дальше ориентируюсь на его длину и в нём должно быть 25 записей

        let stringsInArray = [];
        for (let key in json) {
            stringsInArray.push(json[key]);
        }
        if (stringsInArray.length > 0) {  //Если в массиве есть хоть одна запись - отрисовываем контент таблицы
            for (let i = 0; i < stringsInArray.length; i++) {
                let string = document.createElement('tr');//Создаём строку и потом в неё добавляем контент

                let serialNum = document.createElement('th');
                serialNum.innerHTML = `${firstCount + 1}`;
                serialNum.setAttribute('scope', 'row');
                string.appendChild(serialNum);//Добавляем в строку порядковый номер
                firstCount++;

                let name = document.createElement('td');
                name.innerHTML = stringsInArray[i].name;
                string.appendChild(name);//Добавляем в строку имя

                let email = document.createElement('td');
                email.innerHTML = stringsInArray[i].email;
                string.appendChild(email);//Добавляем в строку email

                if (stringsInArray[i].homepage !== '') {
                    let homepage = document.createElement('td');
                    homepage.innerHTML = stringsInArray[i].homepage;
                    string.appendChild(homepage);//Добавляем в строку homepage
                } else {
                    let homepage = document.createElement('td');
                    homepage.innerHTML = '-';
                    string.appendChild(homepage);//Добавляем в строку прочерк если homepage в таблице пустой
                }

                let text = document.createElement('td');
                text.innerHTML = stringsInArray[i].text;
                string.appendChild(text);//Добавляем в строку текст сообщения из таблицы

                let dateAndTime = document.createElement('td');
                dateAndTime.innerHTML = stringsInArray[i].datetime;
                string.appendChild(dateAndTime);//Добавляем в строку дату и время создания сообщения

                if (stringsInArray[i].editDateAndTime !== null) {
                    let editDateAndTime = document.createElement('td');
                    editDateAndTime.innerHTML = stringsInArray[i].editDateAndTime;
                    string.appendChild(editDateAndTime);//Добавляем в строку дату и время последнего редактирования сообщения
                } else {
                    let editDateAndTime = document.createElement('td');
                    editDateAndTime.innerHTML = '-';
                    string.appendChild(editDateAndTime);//Добавляем в строку прочерк если сообщение ни разу не редактировалось
                }

                let tableOptions = document.createElement('td');
                tableOptions.classList.add('table-options');
                string.appendChild(tableOptions);//Добавляем блок с операциями над сообщением (редактирование/удаление)

                if (stringsInArray[i].user_id === cookies.userId) {

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
                document.getElementById('table-content').appendChild(string);
            }
        } else {
            let string = document.createElement('tr');//Создаём строку для отображения предупреждения о том, что ничего не найдено
            let alertMessage = document.createElement('td');
            if (cookies.userName !== undefined) {
                alertMessage.innerHTML = `${cookies.userName}, Ты уверен, что всё правильно ввёл? Ничего не найдено &#128532;<br> Нужно очистить строку поиска и снова нажать <b>Search</b>`;
            } else {
                alertMessage.innerHTML = `Ты уверен, что всё правильно ввёл? Ничего не найдено &#128532;<br> Нужно очистить строку поиска и снова нажать <b>Search</b>`;
            }
            alertMessage.setAttribute('colspan', '8');
            alertMessage.style.textAlign = 'center';
            string.appendChild(alertMessage);
            document.getElementById('table-content').appendChild(string);
        }
        return pages;
    }).then(function(pages) {  //Этот then для отображения кнопок с номерами страниц
        $('.pages').children().remove();//Каждый раз удаляем номера страниц, чтобы они не задваивались
        let pagesContainer = document.getElementsByClassName('pages')[0];
        for (let i = 0; i < pages; i++) {
            let page = document.createElement('a');
            page.setAttribute('href', `?page=${i}`);
            page.setAttribute('id', `${i}`);
            page.classList.add('page_link');
            page.innerHTML = `${i + 1}`;
            pagesContainer.appendChild(page);
        }
    }).then(function() {
        if (!isLoadScript) {
            loadingScript();
            isLoadScript = true;
        }
    });
}

searchButton.on('click', function(event) {
    event.preventDefault();
    let formData = new FormData(searchForm);
    searchMessage(formData);
});

document.addEventListener('DOMContentLoaded', function() {//Выполняем эту функцию при загрузке страницы, чтобы отобразить таблицу без параметров поиска
    let formData = new FormData(searchForm);
    let parameters = getUrlVars();
    for (let key in parameters) {
        requestAddress += `?${key}=${parameters[key]}`;
    }
    searchMessage(formData);

});