<?php


namespace Fidesio\Donation\Block\Sales\Order;


use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Tax\Block\Sales\Order\Tax;
use Magento\Tax\Model\Config;

class Donation extends Template
{
    /**
     * Tax configuration model
     *
     * @var Config
     */
    protected $config;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var DataObject
     */
    protected $source;

    /**
     * @param Context $context
     * @param Config $taxConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $taxConfig,
        array $data = []
    )
    {
        $this->config = $taxConfig;
        parent::__construct($context, $data);
    }

    /**
     * Check if we nedd display full tax total info
     *
     * @return bool
     */
    public function displayFullSummary()
    {
        return true;
    }

    /**
     * Get data (totals) source model
     *
     * @return DataObject
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return mixed
     */
    public function getStore()
    {
        return $this->order->getStore();
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return array
     */
    public function getLabelProperties()
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    /**
     * @return array
     */
    public function getValueProperties()
    {
        return $this->getParentBlock()->getValueProperties();
    }

    /**
     * Initialize all order totals relates with tax
     *
     * @return Tax
     */
    public function initTotals()
    {

        /* Add Donation total in customer order view*/
        $parent = $this->getParentBlock();
        $this->order = $parent->getOrder();

        $donation = new DataObject(
            [
                'code' => 'donation',
                'strong' => false,
                'value' => $this->order->getDonation(),
                'label' => __('Donation'),
            ]
        );

        $parent->addTotal($donation, 'donation');

        return $this;
    }
}
