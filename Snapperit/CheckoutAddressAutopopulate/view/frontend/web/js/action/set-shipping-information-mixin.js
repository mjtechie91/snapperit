define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper,quote) {
    'use strict';

    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction, messageContainer) {

            var shippingAddress = quote.shippingAddress();

            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }

            if (shippingAddress.customAttributes != undefined) {
                $.each(shippingAddress.customAttributes , function( key, value ) {
                    console.log(value);
                    if($.isPlainObject(value)){
                         shippingAddress['extension_attributes'][value['attribute_code']] = value['value'];
                    }

                });
            }
            console.log(shippingAddress);
            return originalAction(messageContainer);
        });
    };
});