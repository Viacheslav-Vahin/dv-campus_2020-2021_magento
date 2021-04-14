define([
    'jquery',
    'Magento_Customer/js/customer-data',
    'Magento_Ui/js/modal/alert',
    'Magento_Ui/js/modal/modal',
    'mage/translate'
], function ($, customerData, alert) {
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
                buttons: [],
                closed: function () {
                    $('#viacheslav-regular-customer-form')[0].reset();
                }
            });

            $(document).on('viacheslav_loyalty_form_open', this.openModal.bind(this));
            $(this.element).on('submit.viacheslav_loyalty_form', this.sendRequest.bind(this));
            this.updateCustomerData(customerData.get('loyalty-program')());
            customerData.get('loyalty-program').subscribe(this.updateCustomerData.bind(this));
        },

        /**
         * Autocomplete form inputs and hide button
         */
        updateCustomerData: function (value) {
            if (!!value.name) {
                $(this.element).find('input[name="name"]').val(value.name);
            }

            if (!!value.email) {
                $(this.element).find('input[name="email"]').val(value.email);
            }

            if (!!value.productList && value.productList.includes(this.options.productId)) {
                $(document).trigger('viacheslav_regular_customers_show_message');
                $(document).trigger('viacheslav_regular_customers_hide_button');
            }
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
