var anchor = null;
$("a[data-anchor]").click(function () {
    anchor = $(this).data('anchor')
    var element = $("section.index" + anchor);
    var url = '/' + anchor;
    if (element.length > 0) {
        $('html,body').animate({scrollTop: element.offset().top - getNavHeight()}, 'slow');
        window.history.pushState($(this).text(), $(this).text(), url);
    } else {
        window.location.href = url.replace('#', '?page=');
    }
    return false;
});

function getNavHeight() {
    if ($(window).width() > 768) {
        var height = $('.navbar').first().height();
    } else {
        var height = 50;
    }
    return height;
}

function calcHeight() {
    var height = $(window).height() - getNavHeight();
    $('body').css('margin-top', getNavHeight());
    $("section#home, section#about-us, section#service, section#plans, section#how-it-works").css({
        'min-height': height
    });
}

$(window).resize(calcHeight);
calcHeight();

if (page != null) {
    $(".navbar a[data-anchor='#" + page + "']").trigger('click');
}

$('[id^=carousel-selector-]').click(function () {
    var id = this.id.substr(this.id.lastIndexOf("-") + 1);
    var id = parseInt(id);
    $('#carousel').carousel(id);
});
$('#carousel').on('slide.bs.carousel', function (e) {
    $('section#service.index .bg-service').fadeOut();
}).on('slid.bs.carousel', function (e) {
    var bg = $('section#service.index .bg-service');
    var id = $('.item.active').data('slide-number');
    $('[id^=carousel-selector-].active').removeClass('active');
    $('#carousel-selector-' + id).addClass('active');
    bg.css('background-image', 'url(/img/banner-servico-' + id + '.jpg)').fadeIn();
});

jQuery.extend(jQuery.validator.messages, {
    required: "Este campo &eacute; requerido.",
    remote: "Por favor, corrija este campo.",
    email: "Por favor, forne&ccedil;a um endere&ccedil;o eletr&ocirc;nico v&aacute;lido.",
    url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
    date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
    dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
    number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
    digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
    creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
    equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
    accept: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
    maxlength: jQuery.validator.format("Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres."),
    minlength: jQuery.validator.format("Por favor, forne&ccedil;a ao menos {0} caracteres."),
    rangelength: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento."),
    range: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1}."),
    max: jQuery.validator.format("Por favor, forne&ccedil;a um valor menor ou igual a {0}."),
    min: jQuery.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}.")
});

var setMask;
var setValidate;

$(document).ready(function ($) {
    $('form#contact input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_square-orange',
        radioClass: 'iradio_square-orange',
        increaseArea: '30%' // optional
    });

    $('nav li > a').on('click', function () {
        var link = $(this);
        window.history.pushState(link.text(), link.text(), link.data('url'));
    });

    setValidate = function setValidate(el) {
        var $this = $(el),
            opts = {
                rules: {},
                messages: {},
                submitHandler: function (form) {
                    $('ul.errors').remove();
                    var f = $(form);
                    var sendFuncName = f.data('send-form-ajax');
                    if (typeof eval(sendFuncName) != 'undefined') {
                        return eval(sendFuncName)(form)
                    }
                    form.submit();
                }
            },
            $fields = $this.find('[data-validate]');
        $fields.each(function (j, el2) {
            var $field = $(el2),
                name = $field.attr('name'),
                validate = attrDefault($field, 'validate', '').toString(),
                _validate = validate.split(',');

            for (var k in _validate) {
                var rule = _validate[k], params, message;
                if (typeof opts['rules'][name] == 'undefined') {
                    opts['rules'][name] = {};
                    opts['messages'][name] = {};
                }
                if ($.inArray(rule, ['required', 'url', 'email', 'number', 'date', 'dateBR', 'required-group', 'creditcard']) != -1) {
                    opts['rules'][name][rule] = true;
                    message = $field.data('message-' + rule);
                    if (message) {
                        opts['messages'][name][rule] = message;
                    }
                }
                // Parameter Value (#1 parameter)
                else if (params = rule.match(/(\w+)\[(.*?)\]/i)) {
                    if ($.inArray(params[1], ['min', 'max', 'minlength', 'maxlength', 'equalTo']) != -1) {
                        opts['rules'][name][params[1]] = params[2];
                        message = $field.data('message-' + params[1]);
                        if (message) {
                            opts['messages'][name][params[1]] = message;
                        }
                    }
                }
            }
        });
        $this.validate(opts);
    }

    // Form Validation
    if ($.isFunction($.fn.validate)) {
        $("form.validate").each(function (i, el) {
            $(el).on('submit', function () {
                event.preventDefault();
            });
            setValidate(el);
        });
    }

    /**
     * Send form
     * @param form
     */
    function sendForm(form) {
        var form = $(form);
        var btnSubmit = form.find('[type="submit"]');
        var btnDesc = btnSubmit.text();
        btnSubmit.text('Aguarde enviando...').attr('disabled', 'disabled');
        var jqxhr = jQuery.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serializeArray(),
            dataType: "json"
        }).done(function (resp) {
            posAjax(resp, btnSubmit, btnDesc);
        }).fail(function (resp) {
            posAjax(resp, btnSubmit, btnDesc);
        });
    }

    $.formErrors = function (data) {
        $('ul.errors').remove();
        $.each(data, function (element, errors) {
            var ul = $("<ul>").attr("class", "errors");
            $.each(errors, function (name, message) {
                if (typeof message == 'object') {
                    $.each(message, function (name2, message2) {
                        ul.append($("<li>").text(message2));
                    });
                } else {
                    ul.append($("<li>").text(message));
                }
            });
            var input = $("[name='" + element + "']").after(ul);
            input.closest('div.form-group').addClass('validate-has-error');
            input.on('keyup, change', function () {
                $(this)
                    .closest('div.form-group')
                    .removeClass('validate-has-error')
                    .find('ul.errors')
                    .fadeOut('slow');
            });
        });
    }

    var optsToAStr = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-bottom-right",
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    function posAjax(resp, btnSubmit, btnDesc) {
        /**
         * MESSAGE
         */
        if (!jQuery.isEmptyObject(resp.flashMessages)) {
            $(resp.flashMessages).each(function (idx, msg) {
                toastr[msg['type']](msg['message'], msg['title'], optsToAStr);
            });
        }
        /**
         * FORM ERRORS
         */
        if (!jQuery.isEmptyObject(resp.formError)) {
            $.formErrors(resp.formError);
        }
        if (resp.error == '1' || resp.redirectUrl == undefined) {
            btnSubmit.text(btnDesc).removeAttr('disabled');
        }
        /**
         * FANCYBOX CLOSE
         */
        if (resp.error == 0 && (resp.fancyboxClose != undefined && resp.fancyboxClose == 1)) {
            setTimeout(function () {
                try {
                    parent.jQuery.fancybox.close();
                } catch (err) {
                    jQuery.fancybox.close();
                }
            }, 2000);
            return;
        }
        /**
         * REDIRECT
         */
        if (resp.error == '0' && resp.redirectUrl != undefined) {
            setTimeout(function () {
                window.location.href = resp.redirectUrl;
            }, 2000);
        }
    }

    // Input Mask
    setMask = function setMask(el) {
        var $this = $(el),
            mask = $this.data('mask').toString(),
            opts = {
                numericInput: attrDefault($this, 'numeric', false),
                radixPoint: attrDefault($this, 'radixPoint', ''),
                rightAlign: attrDefault($this, 'numericAlign', 'left') == 'right'
            },
            placeholder = attrDefault($this, 'placeholder', ''),
            is_regex = attrDefault($this, 'isRegex', '');

        if (placeholder.length) {
            opts[placeholder] = placeholder;
        }

        switch (mask.toLowerCase()) {
            case "phone":
                var SPMaskBehavior = function (val) {
                        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                    },
                    opts = {
                        onKeyPress: function (val, e, field, options) {
                            field.mask(SPMaskBehavior.apply({}, arguments), options);
                        }
                    };
                mask = SPMaskBehavior;
                break;

            case "bar_code":
                mask = "999999999999";
                break;

            case "int":
                mask = "99";
                break;

            case "currency":
                opts = {
                    radixPoint: ",",
                    groupSeparator: ".",
                    digits: 2,
                    autoGroup: true,
                    prefix: '',
                    rightAlign: false,
                    oncleared: function () {
                        $this.val(0);
                    }
                }
                break;

            case "unit_measurement":
                mask = 'currency';
                opts = {
                    radixPoint: ".",
                    digits: 3,
                    autoGroup: false,
                    prefix: '',
                    rightAlign: false,
                    oncleared: function () {
                        $this.val(0);
                    }
                }
                break;

            case "percent":
                mask = 'currency';
                opts = {
                    radixPoint: ".",
                    digits: 2,
                    autoGroup: false,
                    prefix: '',
                    rightAlign: false,
                    oncleared: function () {
                        $this.val(0);
                    }
                }
                break;

            case "rcurrency":
                var sign = attrDefault($this, 'sign', '$');
                mask = "999,999,999.99";
                if ($this.data('mask').toLowerCase() == 'rcurrency') {
                    mask += ' ' + sign;
                } else {
                    mask = sign + ' ' + mask;
                }
                opts.numericInput = true;
                opts.rightAlignNumerics = false;
                opts.radixPoint = '.';
                break;

            case "email":
                mask = 'Regex';
                opts.regex = "[a-zA-Z0-9._%-]+@[a-zA-Z0-9-]+\\.[a-zA-Z]{2,4}";
                break;

            case "fdecimal":
                mask = 'decimal';
                $.extend(opts, {
                    autoGroup: true,
                    groupSize: 3,
                    radixPoint: attrDefault($this, 'rad', '.'),
                    groupSeparator: attrDefault($this, 'dec', ',')
                });
        }

        if (is_regex) {
            opts.regex = mask;
            mask = 'Regex';
        }
        $this.inputmask(mask, opts);
    }

    if ($.isFunction($.fn.inputmask)) {
        $("[data-mask]").each(function (i, el) {
            setMask(el);
        });
    }

    function attrDefault($el, data_var, default_val) {
        if (typeof $el.data(data_var) != 'undefined') {
            return $el.data(data_var);
        }

        return default_val;
    }

    // Date Range Picker
    if ($.isFunction($.fn.daterangepicker)) {
        $(".daterange").each(function (i, el) {
            // Change the range as you desire
            var ranges = {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            };

            var $this = $(el),
                opts = {
                    format: attrDefault($this, 'format', 'MM/DD/YYYY'),
                    timePicker: attrDefault($this, 'timePicker', false),
                    timePickerIncrement: attrDefault($this, 'timePickerIncrement', false),
                    separator: attrDefault($this, 'separator', ' - '),
                },
                min_date = attrDefault($this, 'minDate', ''),
                max_date = attrDefault($this, 'maxDate', ''),
                start_date = attrDefault($this, 'startDate', ''),
                end_date = attrDefault($this, 'endDate', '');

            if ($this.hasClass('add-ranges')) {
                opts['ranges'] = ranges;
            }

            if (min_date.length) {
                opts['minDate'] = min_date;
            }

            if (max_date.length) {
                opts['maxDate'] = max_date;
            }

            if (start_date.length) {
                opts['startDate'] = start_date;
            }

            if (end_date.length) {
                opts['endDate'] = end_date;
            }

            $this.daterangepicker(opts, function (start, end) {
                var drp = $this.data('daterangepicker');

                if ($this.is('[data-callback]')) {
                    callback_test(start, end);
                }

                if ($this.hasClass('daterange-inline')) {
                    $this.find('span').html(start.format(drp.format) + drp.separator + end.format(drp.format));
                }
            });

            if (typeof opts['ranges'] == 'object') {
                $this.data('daterangepicker').container.removeClass('show-calendar');
            }
        });
    }

    // if ($.isFunction($.fn.select2)) {
    //     $(".select2").each(function (i, el) {
    //         var $this = $(el),
    //             opts = {
    //                 allowClear: attrDefault($this, 'allowClear', false)
    //             };
    //
    //         $this.select2(opts);
    //         $this.addClass('visible');
    //
    //         //$this.select2("open");
    //     });
    //
    //
    //     if ($.isFunction($.fn.niceScroll)) {
    //         $(".select2-results").niceScroll({
    //             cursorcolor: '#d4d4d4',
    //             cursorborder: '1px solid #ccc',
    //             railpadding: {right: 3}
    //         });
    //     }
    // }

    $(".fancybox").fancybox({
        openEffect: 'none',
        closeEffect: 'none'
    });

    $.fn.datepicker.dates['pt-Br'] = {
        days: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
        daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
        daysMin: ["Do", "Se", "Te", "Q", "Q", "S", "S"],
        months: ["Janeiro", "Fevereiro", "Marcio", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
        today: "Hoje",
        clear: "Limpar",
        format: "dd/mm/yyyy",
        titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
        weekStart: 0
    };

    $(".datepicker").datepicker({
        language: 'pt-Br'
    });
});
