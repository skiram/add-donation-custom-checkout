<?php


namespace Fidesio\Donation\Controller\donation;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;
use Zend\Http\AbstractMessage;
use Zend\Http\Response;

class saveDon extends Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var JsonFactory
     */
    protected $jsonResultFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * saveDon constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param JsonFactory $jsonResultFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $jsonResultFactory,
        LoggerInterface $logger
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->logger = $logger;
    }

    /**
     * @return ResponseInterface|Json|ResultInterface
     */
    public function execute()
    {

        $jsonResult = $this->jsonResultFactory->create();

        try {
            /** @var Page $resultPage */
            $resultPage = $this->resultPageFactory->create();
            $this->getActionResponse();


        } catch (LocalizedException $e) {
            $response['error'] = $e->getMessage();
            $jsonResult->setStatusHeader(404);
        }
        return $jsonResult->setData($response);
    }

    /**
     * @return array
     */
    protected function getActionResponse()
    {
        $params = $this->getRequest()->getParams();
        return $params;
    }
}
