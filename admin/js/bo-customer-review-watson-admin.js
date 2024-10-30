(function ($) {
    $(function () {
        $('.connection_type_selector').on('change', function () {
            $('.connection_type_div').addClass('hidden');
            $('.connection_type_'+$(this).val()).removeClass('hidden');
        })
    });
})(jQuery);
