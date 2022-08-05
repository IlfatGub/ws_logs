$(function(){
    new Clipboard('.btn-clipboard');


    // $('#logs-count').change(function () {
    //     var val = $(this).val();
    //     $.ajax({
    //         url: '/ajax/example.html',             // указываем URL и
    //         dataType : "json",                     // тип загружаемых данных
    //         success: function (data, textStatus) { // вешаем свой обработчик на функцию success
    //             $.each(data, function(i, val) {    // обрабатываем полученные данные
    //                 /* ... */
    //             });
    //         }
    //     });
    // });



    $(document).on('change', '#logs-count', function () {
        var val = $(this).val();
        jQuery.ajax({
            type: "GET",
            url: "/temp",
            data: { count: val },
            success: function () {
                location.reload();
            }
        });
    });

    $(document).on('change', '#logs-type', function () {
        var val = $(this).val();
        jQuery.ajax({
            type: "GET",
            url: "/temp",
            data: { type: val },
            success: function () {
                location.reload();
            }
        });
    });

});

$(function () {
    $('[data-toggle="tooltip"]').tooltip({ html: true });
});


