<?php

namespace Snapperit\CheckoutAddressAutopopulate\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const GOOGLE_API_KEY = 'google_address_autocomplete/general/api_key';
    const ADDRESS_AUTOCOMPLETE_STATUS = 'google_address_autocomplete/general/enable';
    const COUNTRIES_CODE_ALLOWED = 'general/country/allow';

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Retrieve the API Key
     *
     * @return string
     */
    public function getApiKey()
    {
        $apiKey = $this->scopeConfig->getValue(
            self::GOOGLE_API_KEY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if (!$apiKey) {
            $apiKey = 'AIzaSyCOdPmPwrsf5s6S8F4b2XmY2VOqeDcxT84';
        }
        return $apiKey;
    }

    /**
     * Retrieve the address autocomplete status
     *
     * @return boolean
     */
    public function getAddressAutocompleteStatus()
    {
        return $this->scopeConfig->isSetFlag(
            self::ADDRESS_AUTOCOMPLETE_STATUS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrieve the countries code allowed
     *
     * @return string
     */
    public function getCountriesAllowed()
    {
        return $this->scopeConfig->getValue(
            self::COUNTRIES_CODE_ALLOWED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
