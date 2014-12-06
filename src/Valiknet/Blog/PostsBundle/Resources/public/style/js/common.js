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
        console.log(data);

        html = "";
        for(var i = data.length - 1; i >= 0 ; i--){
            html += "<li>" +
                        "<div class='comment'>" +
                            "<div class='info-block'>" +
                                "<p>" +
                                    "Додано користувачем: <b>" + data[i].author + "</b></br>" +
                                    "Дата створення: <b>" + data[i].createdAt + "</b>" +
                                "</p>" +
                            "</div>" +

                            "<div class='text'>" +
                                "<p>" +
                                        data[i].text +
                                "</p>" +
                            "</div>" +
                        "</div>" +
                    "</li>";
        }

        $('#category_list').html(html);
    });
});


$(document).on('click', '#delete_post', function(e){
    e.preventDefault();

    $.ajax({
        url: $(this).attr('href'),
        type: 'DELETE'
    }).done(function(data, status){
        document.location.href = "/";
    });
});