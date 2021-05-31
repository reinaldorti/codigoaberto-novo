$(function () {

    $("form").submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var action = form.attr("action");
        var data = form.serialize();

        if (typeof tinyMCE !== 'undefined') {
            tinyMCE.triggerSave();
        }

        form.ajaxSubmit({
            //url: action,
            url: form.attr("action"),
            data: data,
            type: "post",
            dataType: "json",
            beforeSend: function (load) {
                ajax_load("open");
            },
            uploadProgress: function (event, position, total, completed) {
                var loaded = completed;
                var load_title = $(".ajax_load_box_title");
                load_title.text("Enviando (" + loaded + "%)");

                if (completed >= 100) {
                    load_title.text("Aguarde, carregando...");
                }
            },
            success: function (data) {
                ajax_load("close");

                //REDIRECT
                if (data.redirect) {
                    window.setTimeout(function () {
                        window.location.href = data.redirect.url;
                    }, 1000);
                }

                if (data.message) {
                    var view = '<div class="message ' + data.message.type + '">' + data.message.message + '</div>';
                    $(".login_form_callback").html(view);
                    $(".message").effect("bounce");

                    //CLEAR
                    if (data.message.clear) {
                        $(".clear_value").val("");
                    }

                    return;
                }

                //IMAGE MCE UPLOAD
                if (data.mce_image) {
                    $('.mce_upload').fadeOut(200);
                    tinyMCE.activeEditor.insertContent(data.mce_image);
                }
            }
        });

        function ajax_load(action) {
            ajax_load_div = $(".ajax_load");

            if (action === "open") {
                ajax_load_div.fadeIn(200).css("display", "flex");
            }

            if (action === "close") {
                ajax_load_div.fadeOut(200);
            }
        }
    });
});