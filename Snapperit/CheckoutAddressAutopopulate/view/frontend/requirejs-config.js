var config = {
    map: {
        '*': {
            checkoutAddressAutofill: 'Snapperit_CheckoutAddressAutopopulate/js/checkout-address-autofill'
        }
    },
   config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Snapperit_CheckoutAddressAutopopulate/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/set-billing-address': {
                'Snapperit_CheckoutAddressAutopopulate/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-shipping-address': {
                'Snapperit_CheckoutAddressAutopopulate/js/action/create-shipping-address-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Snapperit_CheckoutAddressAutopopulate/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-billing-address': {
                'Snapperit_CheckoutAddressAutopopulate/js/action/set-billing-address-mixin': true
            }
        }
    }
};
