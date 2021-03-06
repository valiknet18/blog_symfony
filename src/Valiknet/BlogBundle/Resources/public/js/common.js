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
        for(var i = data[0].length - 1; i >= 0 ; i--){

            html += "<li>" +
                        "<div class='comment'>" +
                            "<div class='info-block'>" +
                                "<p>" +
                                    "Додано користувачем: <b>" + data[0][i].author + "</b></br>" +
                                    "Дата створення: <b>" + data[0][i].createdAt + "</b>" +
                                "</p>" +
                            "</div>" +

                            "<div class='text'>" +
                                "<p>" +
                                        data[0][i].text +
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
        document.location.href = Routing.generate('blog_home');
    });
});

$(document).on('keydown', '#addPost_tag', function(){
    var value = $(this).val()
    var result = value.split(",");

    var li = "";
    for (var i = 0; i < result.length; i++) {
        li += "<li>" + result[i] + "</li>";
    }

    $('#list_tag').html(li);
});