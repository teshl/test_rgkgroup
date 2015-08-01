$(document).ready(function () {

    var tableBooks = $("#table_books");
    var modalView = $("#modal_books_view");
    var contentView = modalView.find('div.modal-body');
    var titleView = modalView.find('h4.modal-title');

    tableBooks.find("a[href*='books/view']").click(function (event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr('href'),
            dataType: 'json',
            success: function (json) {
                titleView.html(json.title);
                contentView.html(json.html);
                modalView.modal();
            },
            error: function () {
                alert("Произошла ошибка ajax, сообщите о ней разработчикам.");
            }
        });
    });

    // показ картинок
    tableBooks.find("img.books-img").click(function(event){
        var src_img = $(this).attr('src');

        titleView.html('');
        contentView.html('<img class="books-img-modal" src="'+src_img+'" />');
        modalView.modal();
    });

});