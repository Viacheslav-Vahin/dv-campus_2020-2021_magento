<?php
declare(strict_types=1);

namespace Viacheslav\ControllerDemo\Controller\Demo;

use Magento\Framework\Controller\Result\Forward as ForwardResponse;

/**
 * Class Forward
 * @package Viacheslav\ControllerDemo\Controller\Demo
 */
class Forward implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    private $request;

    /**
     * @var \Magento\Framework\Controller\Result\ForwardFactory
     */
    private $forwardResponseFactory;

    /**
     * Forward constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\ForwardFactory $forwardResponseFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\ForwardFactory $forwardResponseFactory
    )
    {
        $this->request = $request;
        $this->forwardResponseFactory = $forwardResponseFactory;
    }

    /**
     * @return ForwardResponse
     */
    public function execute(): ForwardResponse
    {
        return $this->forwardResponseFactory->create()
            ->setParams([
                'firstname' => 'Viacheslav',
                'lastname' => 'Vahin',
                'url' => 'https://github.com/Viacheslav-Vahin/dv-campus_2020-2021_magento'
            ])->forward('Data');
    }
}
