<?php

namespace Webkul\CyberSource\Payment;

use Illuminate\Support\Facades\Storage;
use Webkul\Payment\Payment\Payment;

class CyberSource extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code = 'cyber_source';

    /**
     * Return paypal redirect url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return route('cyber_source.redirect');
    }
}