<?php


namespace Fidesio\Donation\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{

    const DONATION_MODULE_ENABLE_DISABLE = 'donation_general/general/enabled';
    const DONATION_VALUES_PATH = 'donation_general/general/donation_values';
    const DONATION_IMAGE = 'donation_general/general/custom_file_upload';
    const DONATION_TEXT = 'donation_general/general/editor_textarea';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param string $scope
     * @param null $scopeCode
     * @return bool
     */
    public function isDonationEnable($scope = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return $this->scopeConfig->isSetFlag(self::DONATION_MODULE_ENABLE_DISABLE, $scope, $scopeCode);
    }

    /**
     * @param string $scope
     * @param null $scopeCode
     * @return mixed
     */
    public function getDonationValues($scope = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return $this->scopeConfig->getValue(self::DONATION_VALUES_PATH, $scope, $scopeCode);
    }

    /**
     * @param string $scope
     * @param null $scopeCode
     * @return mixed
     */
    public function getDonationImage($scope = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return $this->scopeConfig->getValue(self::DONATION_IMAGE, $scope, $scopeCode);
    }

    /**
     * @param string $scope
     * @param null $scopeCode
     * @return mixed
     */
    public function getDonationText($scope = ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return $this->scopeConfig->getValue(self::DONATION_TEXT, $scope, $scopeCode);
    }
}
