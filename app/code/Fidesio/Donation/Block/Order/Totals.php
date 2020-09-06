<?php


namespace Fidesio\Donation\Block\Order;


use Magento\Framework\DataObject;
use Magento\Framework\View\Element\AbstractBlock;

class Totals extends AbstractBlock
{

    public function initTotals()
    {
        /* Add Donation to Email total*/
        $orderTotalsBlock = $this->getParentBlock();
        $order = $orderTotalsBlock->getOrder();
        if ($order->getNewTotalAmount() > 0) {
            $orderTotalsBlock->addTotal(new DataObject([
                'code' => 'donation',
                'label' => __('Donation'),
                'value' => $order->getDonation(),
                'base_value' => $order->getDonation(),
            ]), 'subtotal');
        }
    }
}
