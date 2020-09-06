<?php


namespace Fidesio\Donation\Model\Donation;

use  Fidesio\Donation\Api\Donation\AjaxDonationSaveInterface;
use Fidesio\Donation\Model\Config;
use Magento\Checkout\Controller\Index\Index as IndexAlias;
use Magento\Checkout\Model\Cart;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Quote;

class AjaxDonationSaveManagement extends IndexAlias implements AjaxDonationSaveInterface
{
    /**
     * @var Quote
     */
    private $quote;

    /**
     * @var Cart
     */

    private $cart;

    /**
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var Config
     */
    private $config;

    /**
     * AjaxDonationSaveManagement constructor.
     * @param Cart $cart
     * @param Quote $quote
     * @param CartRepositoryInterface $quoteRepository
     * @param Config $config
     */
    public function __construct
    (
        Cart $cart,
        Quote $quote,
        CartRepositoryInterface $quoteRepository,
        Config $config
    )
    {
        $this->cart = $cart;
        $this->quote = $quote;
        $this->quoteRepository = $quoteRepository;
        $this->config = $config;
    }


    /**
     * Returns string
     *
     * @param string $donationValue
     * @return string
     * @api
     */
    public function donationSave($donationValue)
    {
        $cartId = $this->cart->getQuote()->getId();

        /** @var  Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        try {
            $quote->setDonation($donationValue);
            $this->quoteRepository->save($quote->collectTotals());

        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        $path = $this->config->getDonationImage();
        return $path;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        $content = $this->config->getDonationText();
        return $content;
    }

}
