<?php

namespace Fidesio\Donation\Api\Donation;

/**
 * Interface AjaxDonationSaveInterface
 * @package Fidesio\Donation\Api\Donation
 */
interface AjaxDonationSaveInterface
{

    const DONATION_LABEL = 'donation';

    /**
     * Returns string
     *
     * @param string $donationValue
     * @return string
     * @api
     */
    public function donationSave($donationValue);

    /**
     * @return mixed
     */
    public function getImage();

    /**
     * @return mixed
     */
    public function getText();
}
