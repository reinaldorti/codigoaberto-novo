$(function () {

    //FORMS DATA
    $("form:not('.ajax_off')").submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var action = form.attr("action");
        var data = form.serialize();

        $.ajax({
            url: action,
            data: data,
            type: "post",
            dataType: "json",
            beforeSend: function (load) {
                ajax_load("open");
            },
            success: function (data) {
                ajax_load("close");

                if (data.message) {
                    var view = '<div class="message ' + data.message.type + '">' + data.message.message + '</div>';
                    $(".login_form_callback").html(view);
                    $(".message").effect("bounce");

                    //ANIMATE TOP
                    if (data.message.top) {
                        $("html, body").animate({
                                scrollTop: $("html").position().top
                            }, 1000
                        );
                    }

                    //CLEAR
                    if (data.message.clear) {
                        $(".clear_value").val("");
                    }

                    return;
                }

                if (data.redirect) {
                    window.location.href = data.redirect.url;
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

    //DELETE CONFIRM
    $('html, body').on('click', '.js_delete_action', function (e) {
        var RelTo = $(this).attr('rel');
        $(this).fadeOut(10, function () {
            $('.' + RelTo + '[id="' + $(this).attr('id') + '"] .js_delete_action_confirm:eq(0)').fadeIn(10);
        });

        e.preventDefault();
        e.stopPropagation();
    });

    //GET CEP
    $('.js_getCep').change(function () {
        var user_cep = $(this).val().replace('-', '').replace('.', '');
        if (user_cep.length === 8) {
            $.get("https://viacep.com.br/ws/" + user_cep + "/json", function (data) {
                if (!data.erro) {
                    $('.js_bairro').val(data.bairro);
                    $('.js_complemento').val(data.complemento);
                    $('.js_localidade').val(data.localidade);
                    $('.js_logradouro').val(data.logradouro);
                    $('.js_uf').val(data.uf);
                }
            }, 'json');
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

    // TINYMCE INIT
    tinyMCE.init({
        selector: "textarea.mce",
        language: 'pt_BR',
        menubar: false,
        theme: "modern",
        height: 132,
        skin: 'light',
        entity_encoding: "raw",
        theme_advanced_resizing: true,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor media"
        ],
        toolbar: "styleselect | pastetext | removeformat |  bold | italic | underline | strikethrough | bullist | numlist | alignleft | aligncenter | alignright |  link | unlink | phpimage | code | fullscreen",
        style_formats: [
            {title: 'Normal', block: 'p'},
            {title: 'Titulo 3', block: 'h3'},
            {title: 'Titulo 4', block: 'h4'},
            {title: 'Titulo 5', block: 'h5'},
            {title: 'Código', block: 'pre', classes: 'brush: php;'}
        ],
        link_class_list: [
            {title: 'None', value: ''},
            {title: 'Blue CTA', value: 'btn btn_cta_blue'},
            {title: 'Green CTA', value: 'btn btn_cta_green'},
            {title: 'Yellow CTA', value: 'btn btn_cta_yellow'},
            {title: 'Red CTA', value: 'btn btn_cta_red'}
        ],
        setup: function (editor) {
            editor.addButton('phpimage', {
                title: 'Enviar Imagem',
                icon: 'image',
                onclick: function () {
                    $('.mce_upload').fadeIn(200, function (e) {
                        $("body").click(function (e) {
                            if ($(e.target).attr("class") === "mce_upload") {
                                $('.mce_upload').fadeOut(200);
                            }
                        });
                    }).css("display", "flex");
                }
            });
        },
        link_title: false,
        target_list: false,
        theme_advanced_blockformats: "h1,h2,h3,h4,h5,p,pre",
        media_dimensions: false,
        media_poster: false,
        media_alt_source: false,
        media_embed: false,
        extended_valid_elements: "a[href|target=_blank|rel|class]",
        imagemanager_insert_template: '<img src="{$url}" title="{$title}" alt="{$title}" />',
        image_dimensions: false,
        relative_urls: false,
        remove_script_host: false,
        paste_as_text: true
    });
});