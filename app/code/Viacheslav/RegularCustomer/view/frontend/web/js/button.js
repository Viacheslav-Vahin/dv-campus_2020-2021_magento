define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('RegularCustomer.button', {
        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(this.element).click(this.openRequestForm.bind(this));
        },

        /**
         * Generate event to open the form
         */
        openRequestForm: function () {
            $(document).trigger('viacheslav_loyalty_form_open');
        }
    });

    return $.RegularCustomer.button;
});
