<?php

namespace Snapperit\CheckoutAddressAutopopulate\Plugin\Quote\Model;

class BillingAddressManagement
{
    
    protected $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function beforeAssign(
        \Magento\Quote\Model\BillingAddressManagement $subject,
        $cartId,
        \Magento\Quote\Api\Data\AddressInterface $address,
        $useForShipping = false
    ) {

        $extAttributes = $address->getExtensionAttributes();
        if (!empty($extAttributes)) {

            try {
                $address->setDeliveryAddressAttribute($extAttributes->getDeliveryAddressAttribute());
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }
            
        }

    }
}