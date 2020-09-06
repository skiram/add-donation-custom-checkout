<?php


namespace Fidesio\Donation\Block\Adminhtml\Order\Invoice;

use Fidesio\Donation\Model\Donation\AjaxDonationSaveManagement;
use Magento\Framework\DataObject;

/**
 * Class NewTotals
 * @package Fidesio\Donation\Block\Adminhtml\Order\Invoice
 */
class NewTotals extends \Magento\Sales\Block\Adminhtml\Order\Invoice\Totals
{

    const DONATION = 'donation';

    /**
     * Initialize order totals array
     *
     * @return \Magento\Sales\Block\Adminhtml\Totals
     */
    protected function _initTotals()
    {

        parent::_initTotals();
        /**
         * Add Donation
         */
        /* Add Donation to total when create new invoice in order backOffice details total*/
        $this->_totals['donation'] = new DataObject(
            [
                'code' => AjaxDonationSaveManagement::DONATION_LABEL,
                'strong' => true,
                'value' => $this->getSource()->getOrder()->getDonation(),
                'base_value' => $this->getSource()->getOrder()->getBaseDonation(),
                'label' => __('Donation'),
            ]
        );

        $this->_totals['grand_total'] = new DataObject(
            [
                'code' => 'grand_total',
                'strong' => true,
                'value' => $this->getSource()->getGrandTotal() + $this->getSource()->getOrder()->getDonation(),
                'base_value' => $this->getSource()->getBaseGrandTotal() + $this->getSource()->getOrder()->getDonation(),
                'label' => __('Grand Total'),
                'area' => 'footer',
            ]
        );
        $this->addTotal($this->_totals['donation'], AjaxDonationSaveManagement::DONATION_LABEL);

        return $this;
    }
}
