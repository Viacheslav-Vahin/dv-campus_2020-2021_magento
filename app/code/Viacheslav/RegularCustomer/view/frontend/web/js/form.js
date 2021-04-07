define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal',
    'mage/translate',
    'mage/cookies'
], function ($, alert) {
    'use strict';

    $.widget('RegularCustomer.form', {
        options: {
            action: '',
            productId: '',
            productName: ''
        },

        /**
         * @private
         */
        _create: function () {
            $(this.element).modal({
                buttons: []
            });

            $(document).on('viacheslav_loyalty_form_open', this.openModal.bind(this));
            $(this.element).on('submit.viacheslav_loyalty_form', this.sendRequest.bind(this));
        },

        /**
         * Open modal dialog
         */
        openModal: function () {
            $(this.element).modal('openModal');
        },

        /**
         * Validate form and send request
         */
        sendRequest: function () {
            if (!this.validateForm()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return $(this.element).validation().valid();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            let formData = new FormData($(this.element).get(0));

            formData.append('productId', this.options.productId);
            formData.append('productName', this.options.productName);
            formData.append('form_key', $.mage.cookies.get('form_key'));
            formData.append('isAjax', 1);

            $.ajax({
                url: this.options.action,
                data: formData,
                processData: false,
                contentType: false,
                type: 'post',
                dataType: 'json',
                context: this,

                /** @inheritdoc */
                beforeSend: function () {
                    $('body').trigger('processStart');
                },

                /** @inheritdoc */
                success: function (response) {
                    $(this.element).modal('closeModal');
                    alert({
                        title: $.mage.__('Success'),
                        content: response.message
                    });
                },

                /** @inheritdoc */
                error: function () {
                    alert({
                        title: $.mage.__('Error'),
                        /*eslint max-len: ["error", { "ignoreStrings": true }]*/
                        content: $.mage.__('Your request can\'t be sent. Please, contact us if you see this message.')
                    });
                },

                /** @inheritdoc */
                complete: function () {
                    $('body').trigger('processStop');
                }
            });
        }
    });

    return $.RegularCustomer.form;
});
