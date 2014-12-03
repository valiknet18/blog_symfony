$(document).on('submit', '#comment_add', function(e){
    e.preventDefault();

    var data = $(this).serialize();

    $(this).find('input[type=text]').val("");
    $(this).find('textarea').val("");

    $.ajax({
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        data: data
    }).done(function(data){
        data = JSON.parse(data);

        switch(data.code){
            case 200: {
                html = "";
                for(var i = data.data.length - 1; i >= 0 ; i--){
                    html += "<li>" +
                                "<div class='comment'>" +
                                    "<div class='info-block'>" +
                                        "<p>" +
                                            "Додано користувачем: <b>" + data.data[i].author + "</b></br>" +
                                            "Дата створення: <b>" + data.data[i].createdAt + "</b>" +
                                        "</p>" +
                                    "</div>" +

                                    "<div class='text'>" +
                                        "<p>" +
                                                data.data[i].text +
                                        "</p>" +
                                    "</div>" +
                                "</div>" +
                            "</li>";
                }
            }
                break;
            case 404: {
                html = "<li><h3>Сталась якась помилка</h3></li>";
            }
        }

        $('#category_list').html(html);
    });
});


$(document).on('click', '#delete_post', function(e){
    e.preventDefault();

    $.ajax({
        url: $(this).attr('href'),
        type: 'DELETE'
    }).done(function(data){
        data = JSON.parse(data);

        switch (data.code){
            case 200: {
                document.location.href = "/app_dev.php/";
            }
                break;
        }
    });
});