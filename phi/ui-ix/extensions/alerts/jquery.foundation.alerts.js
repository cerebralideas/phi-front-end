;(function ($, window, undefined) {
  'use strict';

  $.fn.foundationAlerts = function (options) {
    var settings = $.extend({
      callback: $.noop
    }, options);

    $(document).on("click", ".js_closeAlert", function (e) {
      e.preventDefault();
      $(this).closest(".alert-box").fadeOut(function () {
        $(this).remove();
        // Do something else after the alert closes
        settings.callback();
      });
    });
  };

})(jQuery, this);
