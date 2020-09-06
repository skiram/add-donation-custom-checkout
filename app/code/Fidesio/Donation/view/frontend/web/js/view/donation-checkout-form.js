/*global define*/
define([
    'jquery',
    'Magento_Ui/js/form/form',
    'Magento_Checkout/js/view/summary/abstract-total',
    'Magento_Checkout/js/model/quote',
    'Magento_Catalog/js/price-utils',
    'Magento_Checkout/js/model/totals',
    'Magento_Checkout/js/model/cart/totals-processor/default',
    'Magento_Checkout/js/model/cart/cache',
    'mage/storage',
    'uiComponent',
    'ko',
    'mage/translate'
], function ($, Form, Component, quote, priceUtils, totals, totalsProcessor, cartCache, storage, uiComponent, ko, $t) {
    'use strict';
    return uiComponent.extend({
        defaults: {
            isFullTaxSummaryDisplayed: window.checkoutConfig.isFullTaxSummaryDisplayed || false,
            template: 'Fidesio_Donation/donation-checkout-form'
        },
        initialize: function () {
            this._super();
            return this;
        },
        totals: quote.getTotals(),
        isTaxDisplayedInGrandTotal: window.checkoutConfig.includeTaxInGrandTotal || false,

        isDisplayed: function () {
            return this.isFullMode();
        },
        /**
         * Form submit handler
         *
         * This method can have any name.
         */
        onSubmit: function () {
            // trigger form validation
            //this.source.set('params.invalid', false);
            // this.source.trigger('donationCheckoutFormScope.data.validate');
            var seleced_value = $('select[name="donation_select"]').children("option:selected").val();
            this.validateDon(seleced_value);
            /* if (!this.source.get('params.invalid')) {
                 // data is retrieved from data provider by value of the customScope property
                 var formData = this.source.get('donationCheckoutFormScope');
                 this.validateDon(formData.donation_select);
             }*/
        },
        validateDon: function (don_value) {
            var serviceUrl = 'rest/V1/donation/save';
            totals.isLoading(true);
            storage.post(
                serviceUrl,
                JSON.stringify({
                    don_value: don_value
                })
            ).done(function (response) {
                cartCache.set('totals', null);
                totalsProcessor.estimateTotals(don_value);
            }).fail(function (response) {

            });
        },
        /**
         *
         */
        getImage: function () {
            return window.checkoutConfig.donation.image;
        },
        /**
         *
         */
        getText: function () {
            return window.checkoutConfig.donation.text;
        },
        /**
         *
         */
        getDonationValues: function () {
            return window.checkoutConfig.donation.donation_values;
        },
        enabled: function () {
            if ($("#enable_disable_don").is(":checked")) {
                $('#select_don_value').prop('disabled', false);
            } else {
                $('#select_don_value').prop('disabled', 'disabled');
                $('#select_don_value').val(0);
                this.validateDon(0);
            }
        },
    });
});
