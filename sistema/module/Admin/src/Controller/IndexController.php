<?php

namespace Admin\Controller;

use MainClass\MainController;
use Zend\Db\Adapter\AdapterInterface;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class IndexController
 * @package Admin\Controller
 */
class IndexController extends MainController
{
    /**
     * IndexController constructor.
     * @param AdapterInterface $dbAdapter
     * @param PhpRenderer $phpRender
     */
    function __construct(AdapterInterface $dbAdapter, PhpRenderer $phpRender)
    {
        parent::__construct($dbAdapter, $phpRender);
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return $this->_view;
    }
}
