define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('viacheslav.regularCustomerMessage', {
        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(document).on('viacheslav_regular_customers_show_message', this.showMessage.bind(this));
        },

        /**
         * Generate event to show message
         */
        showMessage: function () {
            $(this.element).css('display', 'inline-block');
        }
    });

    return $.viacheslav.regularCustomerMessage;
});
