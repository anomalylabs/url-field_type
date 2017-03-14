$(function () {
    var
        $inputs = $('[data-provides="anomaly.field_type.url"]'),
        scheme = window.location.protocol + '//';

    $inputs.attr('placeholder', scheme);

    $inputs.on('keyup', function (event) {
        var
            $target = $(event.target),
            value = $target.val();

        if (value && !value.match(/^https?:\/\//)) {
            $target.val(scheme + value);
        }
    });

    $inputs.on('blur', function (event) {
        var
            $target = $(event.target),
            value = $target.val();

        if (value && ['http://', 'https://'].includes(value)) {
            $target.val('');
        }
    });

    $inputs.on('focus', function (event) {
        var
            $target = $(event.target),
            value = $target.val();

        if (!value) {
            $target.val(scheme);
        }
    });
});
