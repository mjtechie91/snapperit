<?php

namespace Snapperit\CheckoutAddressAutopopulate\Observer;
class SalesEventQuoteSubmitBeforeObserver implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        //Code to update custom fields from quote to order address table
        

        return $this;
    }
}