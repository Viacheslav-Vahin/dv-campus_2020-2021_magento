<?php
declare(strict_types=1);

namespace Viacheslav\ControllerDemo\Block;

/**
 * Class Bio
 * @package Viacheslav\ControllerDemo\Block
 */
class Bio extends \Magento\Framework\View\Element\Template
{
    /**
     * @return String
     */
    public function getName(): String
    {
        return (string) $this->getRequest()->getParam('firstname');
    }

    /**
     * @return String
     */
    public function getSurname(): String
    {
        return (string) $this->getRequest()->getParam('lastname');
    }

    /**
     * @return String
     */
    public function getRepo(): String
    {
        return (string) $this->getRequest()->getParam('url');
    }
}
