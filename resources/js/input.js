$(document).on('ajaxComplete ready', function () {

    var
        $inputs = $('[data-provides="anomaly.field_type.url"]:not([data-initialized])'),
        scheme = window.location.protocol + '//';

    $inputs.data('initialized', '');

    $inputs.on('keyup', function (e) {
        var
            $target = $(e.target),
            value = $target.val();

        if (value && !value.match(/^https?:\/\//)) {
            $target.val(scheme + value);
        }
    });

    $inputs.on('blur', function (e) {
        var
            $target = $(e.target),
            value = $target.val();

        if (value && ['http://', 'https://'].includes(value)) {
            $target.val('');
        }
    });

    $inputs.on('focus', function (e) {
        var
            $target = $(e.target),
            value = $target.val();

        if (!value) {
            $target.val(scheme);
        }
    });
});
