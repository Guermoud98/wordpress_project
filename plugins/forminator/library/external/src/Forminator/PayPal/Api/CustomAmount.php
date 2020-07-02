<?php

namespace Forminator\PayPal\Api;

use Forminator\PayPal\Common\PayPalModel;

/**
 * Class CustomAmount
 *
 * The custom amount applied on an invoice. If you include a label, the amount cannot be empty.
 *
 * @package Forminator\PayPal\Api
 *
 * @property string label
 * @property \Forminator\PayPal\Api\Currency amount
 */
class CustomAmount extends PayPalModel
{
    /**
     * The custom amount label. Maximum length is 25 characters.
     *
     * @param string $label
     * 
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * The custom amount label. Maximum length is 25 characters.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * The custom amount value. Valid range is from -999999.99 to 999999.99.
     *
     * @param \Forminator\PayPal\Api\Currency $amount
     * 
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * The custom amount value. Valid range is from -999999.99 to 999999.99.
     *
     * @return \Forminator\PayPal\Api\Currency
     */
    public function getAmount()
    {
        return $this->amount;
    }

}
