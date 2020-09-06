<?php


namespace Fidesio\Donation\Model\ConfigProvider;

use Fidesio\Donation\Model\Config;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class DonationConfigProvider
 * @package Fidesio\Donation\Model\ConfigProvider
 */
class DonationConfigProvider implements ConfigProviderInterface
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * DonationConfigProvider constructor.
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Config $config,
        StoreManagerInterface $storeManager
    )
    {
        $this->config = $config;
        $this->storeManager = $storeManager;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'donation' => [
                'image' => $this->getMediaUrl() . 'don_image/' . $this->config->getDonationImage(),
                'text' => $this->config->getDonationText(),
                'donation_values' => $this->getDonationConfigValues()
            ]
        ];
    }

    /**
     * @return array
     */
    private function getDonationConfigValues(): array
    {
        $array = [];
        $values = $this->config->getDonationValues();
        $items = explode(',', $values);
        foreach ($items as $key => $item) {
            $array[$key]['value'] = $item;
            $array[$key]['label'] = $item . '€';
        }
        return $array;
    }

    /**
     * @return mixed
     * @throws NoSuchEntityException
     */
    private function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }
}
