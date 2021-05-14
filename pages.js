$('#1').on('click', function() {
    $.ajax({
        url: 'searchMessage/searchMessageRequest.php',
        type: 'GET',
        headers: 'page=1',
        success: function(data) {
            alert('Прибыли данные' + data);
        }
    })
})