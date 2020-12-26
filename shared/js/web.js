$(function () {

    //COOKIE POLICY
    $("[data-cookie]").click(function (e) {
        e.preventDefault();
        var cookiePolicy = $("#cookiePolicy");
        var route = $(this).data("route");
        var dataset = $(this).data();

        $(".main_footer").css("margin-bottom", 0);
        cookiePolicy.fadeOut();

        $.post(route, dataset, function (response) {
            //agree
            if (response.agree) {
                window.location.reload();
            }
        }, "json");
    });

    var cookiePolicy = $("#cookiePolicy");
    if (!cookiePolicy.hasClass("ds-none")) {
        $(".main_footer").css("margin-bottom", cookiePolicy.outerHeight());
    }

    $("form:not('.ajax_off')").submit(function (e) {
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

                //ANIMATE TOP
                if (data.message.top) {
                    $('html, body').animate({
                            scrollTop: $('html').position().top
                        },
                        1000
                    );
                }

                if (data.message.clear) {
                    $('form').each(function () {
                        this.reset();
                    });
                }

                //REDIRECT
                if (data.message.redirect) {
                    window.location.href = data.redirect.url;
                }

                if (data.message) {
                    var view = '<div class="message ' + data.message.type + '">' + data.message.message + '</div>';
                    $(".login_form_callback").html(view);
                    $(".message").effect("bounce");

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

    //MASK INPUT
    if ($('.formDate').length || $('.formTime').length || $('.formCep').length || $('.formCpf').length || $('.formPhone').length) {
        $(".formDate").mask("99/99/9999");
        $(".formTime").mask("99/99/9999 99:99");
        $(".formCep").mask("99999-999");
        $(".formCpf").mask("999.999.999-99");
        $(".formCnpj").mask("00.000.000/0000-00");

        var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
        $('.formPhone').mask(SPMaskBehavior, spOptions);
    }
});