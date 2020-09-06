<?php


namespace Fidesio\Donation\Observer;

use Fidesio\Donation\Model\Donation\AjaxDonationSaveManagement;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\QuoteFactory;

class SetDonationAttributeToOrder implements ObserverInterface
{

    /**
     * @var QuoteFactory
     */
    private $quoteFactory;

    /**
     * SetDonationAttributeToOrder constructor.
     * @param QuoteFactory $quoteFactory
     */
    public function __construct(QuoteFactory $quoteFactory)
    {
        $this->quoteFactory = $quoteFactory;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $quoteId = $order->getQuoteId();
        $quote = $this->quoteFactory->create()->load($quoteId);
        $order->setDonation($quote->getDonation());
        $order->setData(AjaxDonationSaveManagement::DONATION_LABEL, $quote->getDonation());
    }
}
