<?php


namespace Fidesio\Donation\Block\Adminhtml\Order\Invoice;

use Fidesio\Donation\Model\Donation\AjaxDonationSaveManagement;
use Magento\Framework\DataObject;

/**
 * Class Totals
 * @package Fidesio\Donation\Block\Adminhtml\Order\Invoice
 */
class Totals extends \Magento\Sales\Block\Adminhtml\Order\Invoice\Totals
{
    /**
     * Initialize order totals array
     *
     * @return \Magento\Sales\Block\Adminhtml\Totals
     */
    protected function _initTotals()
    {
        parent::_initTotals();

        /* Add Donation total in Invoice Order backOffice details total*/
        $this->_totals['donation'] = new DataObject(
            [
                'code' => AjaxDonationSaveManagement::DONATION_LABEL,
                'strong' => true,
                'value' => $this->getSource()->getOrder()->getDonation(),
                'base_value' => $this->getSource()->getOrder()->getBaseDonation(),
                'label' => __('Donation'),
            ]
        );

        $this->addTotal($this->_totals['donation'], AjaxDonationSaveManagement::DONATION_LABEL);

        return $this;
    }
}
