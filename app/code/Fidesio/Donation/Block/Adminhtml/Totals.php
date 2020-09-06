<?php


namespace Fidesio\Donation\Block\Adminhtml;


use Fidesio\Donation\Model\Donation\AjaxDonationSaveManagement;
use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Totals extends Template
{
    /**
     * @var
     */
    protected $order;

    /**
     * @var
     */
    protected $source;

    /**
     * Totals constructor.
     * @param Context $context
     * @param array $data
     */
    public function __construct
    (
        Context $context,
        array $data = []
    )
    {
        parent:: __construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getStore()
    {
        return $this->order->getStore();
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return $this
     */
    public function initTotals()
    {
        /* Add Donation to total in order backOffice details total*/
        $parent = $this->getParentBlock();
        $this->order = $parent->getOrder();
        $this->source = $parent->getSource();

        $donation = new DataObject(
            [
                'code' => AjaxDonationSaveManagement::DONATION_LABEL,
                'value' => $this->getSource()->getDonation(),
                'base_value' => $this->getSource()->getBaseDonation(),
                'label' => __('Donation'),
            ]
        );
        $parent->addTotal($donation, AjaxDonationSaveManagement::DONATION_LABEL);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }
}
