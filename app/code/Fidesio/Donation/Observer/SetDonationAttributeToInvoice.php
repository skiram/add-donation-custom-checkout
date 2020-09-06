<?php


namespace Fidesio\Donation\Observer;

use Fidesio\Donation\Model\Donation\AjaxDonationSaveManagement;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class SetDonationAttributeToInvoice implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $invoice = $observer->getEvent()->getInvoice();
        $order = $invoice->getOrder();
        $invoice->setDonation($order->getDonation());
        $invoice->setData(AjaxDonationSaveManagement::DONATION_LABEL, $order->getDonation());
        $invoice->setGrandTotal($invoice->getGrandTotal() + $order->getDonation());
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $order->getDonation());

    }
}
