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
            success: function (su) {
                ajax_load("close");

                if (su.message) {
                    var view = '<div class="message ' + su.message.type + '">' + su.message.message + '</div>';
                    $(".login_form_callback").html(view);
                    $(".message").effect("bounce");

                    //DATA REORDER
                    if (su.order) {
                        $('.j_drag_active').removeClass('btn_yellow');
                        $('.j_draganddrop').removeAttr('draggable');
                    }

                    if (su.message.clear) {
                        $('form').each(function () {
                            this.reset();
                        });
                    }
                    return;
                }

                //REDIRECT
                if (su.redirect) {
                    window.location.href = su.redirect.url;
                }

                //IMAGE MCE UPLOAD
                if (su.mce_image) {
                    $('.mce_upload').fadeOut(200);
                    tinyMCE.activeEditor.insertContent(su.mce_image);
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