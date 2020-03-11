$( document ).ready(function() {
    sortPosts();
    console.log(1);
    $('#true_loadmore').click(function () {
        $(this).text('Загружаю...'); // изменяем текст кнопки, вы также можете добавить прелоадер

        if($('#select_brand').val() !== '0'){

            if(loadmore.term_taxonomy_id !== ''){

                var data = {
                    'action': 'loadmore',
                    'tax_marks': $('#select_brand').val(),
                    'tax': loadmore.tax,
                    'term_id':loadmore.term_taxonomy_id,
                    'page': loadmore.current_page
                };
            }else {
                var data = {
                    'action': 'loadmore',
                    'tax': 'tax_marks',
                    'page': loadmore.current_page,
                    'term_id': $('#select_brand').val()
                };
            }
        }else{
            var data = {
                'action': 'loadmore',
                'page': loadmore.current_page,
                'tax': loadmore.tax,
                'term_id':loadmore.term_taxonomy_id
            };
        }
        $.ajax({
            url: loadmore.ajax, // обработчик
            data: data, // данные
            type: 'POST', // тип запроса
            success: function (data) {
                if (data) {
                    $('.pagination_item.new_item').removeClass('new_item');
                    $('#true_loadmore').text('показать следующие 20 товаров').before(data); // вставляем новые посты
                    loadmore.current_page++; // увеличиваем номер страницы на единицу

                    $('body,html').animate({scrollTop:$('#page_'+loadmore.current_page).offset().top-100},0);
                    if (loadmore.current_page == loadmore.max_pages) $("#true_loadmore").remove(); // если последняя страница, удаляем кнопку
                } else {
                    $('#true_loadmore').remove(); // если мы дошли до последней страницы постов, скроем кнопку
                }
            }
        });
    });
});


function sortPosts(){

    var filterTerm = $('#select_brand');

    filterTerm.on('change',function () {

        var posts = $('body').find('.catalog-table__row');

        var target =  $(this).val();

        posts.animate({'opacity':0},400);

        setTimeout(function () {
            posts.remove();

            if(target !== '0'){

                if(loadmore.term_taxonomy_id !== ''){

                    var data = {
                        'action': 'loadmore',
                        'tax_marks': $('#select_brand').val(),
                        'tax': loadmore.tax,
                        'term_id':loadmore.term_taxonomy_id,
                        'page': loadmore.current_page
                    };
                }else{
                    var data = {
                        'action': 'loadmore',
                        'tax': 'tax_marks',
                        'page': loadmore.current_page,
                        'term_id': target
                    };
                }
            }
            else{

                var data = {
                    'action': 'loadmore',
                    // 'tax': 'tax_marks',
                    'page': loadmore.current_page,
                    // 'term_id': target
                };
            }
            $.ajax({
                url: loadmore.ajax, // обработчик
                data: data, // данные
                type: 'POST', // тип запроса
                success: function (data) {
                    if (data) {
                        $('.pagination_item.new_item').removeClass('new_item');
                        $('#true_loadmore').text('показать следующие 20 товаров').before(data); // вставляем новые посты
                        loadmore.current_page++; // увеличиваем номер страницы на единицу
                        if (loadmore.current_page == loadmore.max_pages) $("#true_loadmore").remove(); // если последняя страница, удаляем кнопку

                        $('body,html').animate({scrollTop:$('#page_'+loadmore.current_page).offset().top-100},1500);
                    } else {
                        $('#true_loadmore').remove(); // если мы дошли до последней страницы постов, скроем кнопку
                    }
                }
            });
        },450);





    });
}