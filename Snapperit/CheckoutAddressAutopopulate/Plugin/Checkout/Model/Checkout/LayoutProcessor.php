<?php

namespace Snapperit\CheckoutAddressAutopopulate\Plugin\Checkout\Model\Checkout;

class LayoutProcessor
{

    protected $_session;

    public function __construct(
        \Magento\Customer\Model\Session $session
    ) {
        $this->_session = $session;
    }

    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {

        if ($this->_session->isLoggedIn()) {
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children']['firstname']['visible'] = 0;

            

            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children']['lastname']['visible'] = 0;

            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['firstname']['visible'] = 0;


            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['lastname']['visible'] = 0;
        } else {
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children']['firstname']['visible'] = 1;

            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children']['lastname']['visible'] = 1;

            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['firstname']['visible'] = 1;


            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['lastname']['visible'] = 1;
        }

        

        
        $customAttributeCode = 'delivery_address_attribute';

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['ship_to_location'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/checkbox'
            ],
            'dataScope' => 'shippingAddress.ship_to_location',
            'label' => '',
            'description' => 'Ship to different location',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 49,
            'id' => 'ship_to_location'
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['delivery_address_attribute'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            //'dataScope' => 'shippingAddress.custom_attributes' . '.' . $customAttributeCode,
            'dataScope' => 'shippingAddress.custom_attributes.delivery_address_attribute',
            'label' => 'Delivery Address',
            'placeholder' => 'Delivery Address',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 52
        ];

        //print_r($jsLayout['components']['checkout']['children']['steps']['children']); die;

        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['country_id']['sortOrder'] = 50;
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['delivery_address_attribute'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'billingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            //'dataScope' => 'billingAddress.delivery_address_attribute',
            'dataScope' => 'billingAddress.custom_attributes' . '.' . $customAttributeCode,
            'label' => 'Delivery Address',
            'placeholder' => 'Delivery Address',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 52
        ];

        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['bill_to_location'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'billingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/checkbox',
                'options' => [],
                'id' => 'bill_to_location'
            ],
            'dataScope' => 'billingAddress.bill_to_location',
            'label' => '',
            'description' => 'Bill to different location',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 49,
            'id' => 'bill_to_location'
        ];

        return $jsLayout;
    }

}