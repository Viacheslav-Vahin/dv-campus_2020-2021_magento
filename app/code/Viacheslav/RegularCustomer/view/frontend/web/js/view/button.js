define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function ($, ko, Component, customerData) {
    'use strict';

    return Component.extend({
        defaults: {
            productId: 0,
            requestAlreadySent: false,
            template: 'Viacheslav_RegularCustomer/button'
        },

        /**
         * Init observable
         */
        initObservable: function () {
            this._super();
            this.observe('requestAlreadySent');

            this.checkRequestedProduct(customerData.get('loyalty-program')());
            customerData.get('loyalty-program').subscribe(this.checkRequestedProduct.bind(this));

            return this;
        },

        /**
         * Generate event to open the form
         */
        openRegistrationForm: function () {
            $(document).trigger('viacheslav_regular_customer_form_open');
        },

        /**
         * Check if the product has already been requested by the customer
         */
        checkRequestedProduct: function (value) {
            if (!!value.productList && value.productList.includes(this.productId)) {
                this.requestAlreadySent(true);
            }
        }
    });
});
