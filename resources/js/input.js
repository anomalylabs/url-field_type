+(function (window, document) {
  document.addEventListener('DOMContentLoaded', function () {
    var
      inputs = document.querySelectorAll('[data-provides="anomaly.field_type.url"]'),
      scheme = window.location.protocol + '//';

    inputs.forEach(function (input) {
      input.placeholder = scheme;

      input.addEventListener('keyup', function (ev) {
        if (ev.target.value) {
          if (!ev.target.value.match(/^https?:\/\//)) {
            ev.target.value = scheme + ev.target.value;
          }
        }
      });

      input.addEventListener('blur', function (ev) {
        if (ev.target.value) {
          if (['http://', 'https://'].includes(ev.target.value)) {
            ev.target.value = '';
          }
        }
      });

      input.addEventListener('focus', function (ev) {
        if (!ev.target.value) {
          ev.target.value = scheme;
        }
      });
    });
  });
})(window, document);
