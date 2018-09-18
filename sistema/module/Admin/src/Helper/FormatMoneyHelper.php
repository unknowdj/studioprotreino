<?php

namespace Admin\Helper;

use Zend\View\Helper\AbstractHelper;

class FormatMoneyHelper extends AbstractHelper
{
    public function __invoke($money)
    {
        $fmt = new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY);
        return $fmt->formatCurrency($money, "BRL");
    }
}