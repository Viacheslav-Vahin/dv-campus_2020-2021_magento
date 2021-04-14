define([
    'jquery',
    'jquery/ui',
    'mage/translate'
], function ($) {
    'use strict';

    $.widget('RegularCustomer.button', {

        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(this.element).click(this.openRegistrationForm.bind(this));
            $(document).on('viacheslav_regular_customers_hide_button', this.hideButton.bind(this));
        },

        /**
         * Generate event to open the form
         */
        openRegistrationForm: function () {
            $(document).trigger('viacheslav_loyalty_form_open');
        },

        hideButton: function () {
            $(this.element).hide();
        }
    });

    return $.RegularCustomer.button;
});
