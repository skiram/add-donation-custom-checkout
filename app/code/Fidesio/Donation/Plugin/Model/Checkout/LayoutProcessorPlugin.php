<?php


namespace Fidesio\Donation\Plugin\Model\Checkout;

use Fidesio\Donation\Model\Config;
use Magento\Checkout\Block\Checkout\LayoutProcessor;

class LayoutProcessorPlugin
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * LayoutProcessorPlugin constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array $jsLayout
    )
    {

        $paymentConfig = &$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
        ['children']['payment'];
        $paymentConfig['children']['beforeMethods']['children']
        ['donation-checkout-form-container'] =
            [
                'component' => 'Fidesio_Donation/js/view/donation-checkout-form',
                'provider' => 'checkoutProvider',
            ];
        $paymentConfig['children']['beforeMethods']['children']['donation-checkout-form-container']
        ['children']['donation-checkout-form-fields']['children'] =
            [
                'component' => 'uiComponent',
                'displayArea' => 'donation-checkout-form-fields'
            ];

        $paymentConfig['children']['beforeMethods']['children']['donation-checkout-form-container']
        ['children']['donation-checkout-form-fields']['children']['donation_select'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'donationCheckoutFormScope',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'donation-select'
            ],
            'dataScope' => 'donationCheckoutFormScope.donation_select',
            'label' => 'Your Donation',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'id' => 'donation-select',
            'options' => $this->getArray(),
        ];

        return $jsLayout;
    }

    /**
     * @return array
     */
    private function getArray()
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
}
