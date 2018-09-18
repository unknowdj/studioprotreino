<?php

namespace Admin\Helper;

use Zend\View\Helper\AbstractHelper;

class StatusActiveHelper extends AbstractHelper
{

    function __invoke($statusId)
    {
        return $this->getStatus($statusId);
    }

    static public function getStatus($statusId)
    {
        return ($statusId == 1) ? '<span class="label label-success status">Sim</span>' : '<span class="label label-danger status">Não</span>';
    }

}
