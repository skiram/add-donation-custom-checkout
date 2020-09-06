<?php


namespace Fidesio\Donation\Ui\Component\Listing\Column;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Sales\Model\Order\Invoice;
use Magento\Ui\Component\Listing\Columns\Column;

class DonationOrderInvoice extends Column
{

    /**
     * @var Invoice
     */
    protected $invoice;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteria;

    /**
     * DonationOrderInvoice constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Invoice $invoice
     * @param SearchCriteriaBuilder $criteria
     * @param array $components
     * @param array $data
     */
    public function __construct
    (
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Invoice $invoice,
        SearchCriteriaBuilder $criteria,
        array $components = [],
        array $data = []
    )
    {
        $this->invoice = $invoice;
        $this->searchCriteria = $criteria;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        return $dataSource;
    }
}
