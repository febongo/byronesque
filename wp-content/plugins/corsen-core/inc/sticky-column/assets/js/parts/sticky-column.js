(function ($) {
    "use strict";

    $(window).on('load', function () {
        qodefStickyColumn.init('init');
    });

    $(window).resize(function () {
        qodefStickyColumn.init('resize');
    });

    $( document ).on(
        'corsen_trigger_get_new_posts',
        function () {
        }
    );

    var qodefStickyColumn = {
        init: function () {
            var stickyColumnHolder = $( '.qodef-sticky-column--yes' );

            if ( stickyColumnHolder.length ) {
                stickyColumnHolder.each(
                    function () {

                        $( this ).closest( '#qodef-page-wrapper' ).css(
                            'overflow',
                            'visible'
                        );

                        var height = $( this ).height();
                        var width  = $( this ).css( 'width' );

                        // $( this ).css(
                        //     'top',
                        //     'calc(50% - ' + (height / 2) + 'px )'
                        // );
                    }
                );
            }
        }
    };

    window.qodefStickyColumn       = qodefStickyColumn;
})(jQuery);
