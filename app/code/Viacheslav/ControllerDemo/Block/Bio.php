<?php
declare(strict_types=1);

namespace Viacheslav\ControllerDemo\Block;

/**
 * Class Bio
 * @package Viacheslav\ControllerDemo\Block
 */

class Bio extends \Magento\Framework\View\Element\Template
{
    public function getName()
    {
        return $this->getRequest()->getParam('firstname');
    }

    public function getSurname()
    {
        return $this->getRequest()->getParam('lastname');
    }

    public function getRepo()
    {
        return $this->getRequest()->getParam('url');
    }
}
