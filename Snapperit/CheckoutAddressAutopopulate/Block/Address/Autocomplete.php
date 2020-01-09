<?php

namespace Snapperit\CheckoutAddressAutopopulate\Block\Address;

class Autocomplete extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Snapperit\CheckoutAddressAutopopulate\Helper\Data
     */
    protected $addressAutocompleteHelperData;

    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    protected $_localeResolver;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Snapperit\CheckoutAddressAutopopulate\Helper\Data $addressAutocompleteHelperData
     * @param \Magento\Framework\Locale\ResolverInterface $localeResolver
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Snapperit\CheckoutAddressAutopopulate\Helper\Data $addressAutocompleteHelperData,
        \Magento\Framework\Locale\ResolverInterface $localeResolver
    ) {
        $this->addressAutocompleteHelperData = $addressAutocompleteHelperData;
        $this->_localeResolver = $localeResolver;
        parent::__construct($context);
    }

    /**
     * Retrieve the address autocomplete status
     *
     * @return boolean
     */
    public function showAddressAutocomplete()
    {
        if ($this->addressAutocompleteHelperData->getAddressAutocompleteStatus()) {
            return true;
        }
        return false;
    }

    /**
     * Check if the current page is the checkout page
     *
     * @return boolean
     */
    public function isCheckoutPage()
    {
        $moduleName     = $this->getRequest()->getModuleName();
        $controllerName = $this->getRequest()->getControllerName();
        $actionName     = $this->getRequest()->getActionName();
        $currentPage = $moduleName.'_'.$controllerName.'_'.$actionName;
        $array = [
            'checkout_index_index'
        ];
        if (in_array($currentPage, $array)) {
            return true;
        }
        return false;
    }

    /**
     * Retrieve the API Key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->addressAutocompleteHelperData->getApiKey();
    }

    /**
     * Retrieve the locate
     *
     * @return string
     */
    public function getLocate()
    {
        return $this->_localeResolver->getLocale();
    }

    /**
     * Retrieve the countries code allowed
     *
     * @return string
     */
    public function getCountriesAllowed()
    {
        return $this->addressAutocompleteHelperData->getCountriesAllowed();
    }
}
