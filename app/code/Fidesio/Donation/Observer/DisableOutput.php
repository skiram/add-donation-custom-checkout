<?php

namespace Fidesio\Donation\Observer;

use Fidesio\Donation\Model\Config as ModelConfig;
use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class DisableOutput implements ObserverInterface
{

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var ModelConfig
     */
    protected $configModel;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;


    /**
     * DisableOutput constructor.
     * @param Config $config
     * @param ModelConfig $configModel
     * @param StoreManagerInterface $storeManager
     * @param RequestInterface $request
     */
    public function __construct(
        Config $config,
        ModelConfig $configModel,
        StoreManagerInterface $storeManager,
        RequestInterface $request
    )
    {
        $this->config = $config;
        $this->configModel = $configModel;
        $this->storeManager = $storeManager;
        $this->request = $request;

    }

    /**
     * @param Observer $observer
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $disable = false;
        $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        $scopeCode = 0;

        if ($this->request->getParam(ScopeInterface::SCOPE_STORE)) {
            $scopeType = ScopeInterface::SCOPE_STORE;
            $scopeCode = $this->storeManager->getStore($this->request->getParam(ScopeInterface::SCOPE_STORE))->getCode();
        } elseif ($this->request->getParam(ScopeInterface::SCOPE_WEBSITE)) {
            $scopeType = ScopeInterface::SCOPE_WEBSITE;
            $scopeCode = $this->storeManager->getWebsite($this->request->getParam(ScopeInterface::SCOPE_WEBSITE))->getCode();
        }

        $moduleConfig = $this->configModel->isDonationEnable($scopeType);


        if ((int)$moduleConfig == 0) {
            $disable = true;
        }

        $moduleName = 'Fidesio_Donation';
        $outputPath = "advanced/modules_disable_output/$moduleName";

        $this->config->saveConfig($outputPath, $disable, $scopeType, $scopeCode);
    }
}
