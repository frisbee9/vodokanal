   $( document ).ready(function() {
        $('#s-h-pass').click(function(){
            var type = $('#password').attr('type') == "text" ? "password" : 'text',
             c = $(this).text() == "Скрыть пароль" ? "Показать пароль" : "Скрыть пароль";
            $(this).text(c);
            $('#password').prop('type', type);
        });
    });