<?php
declare(strict_types=1);

namespace Viacheslav\ControllerDemo\Controller\Demo;

use Magento\Framework\View\Result\Page as DataResponse;

class Data implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $dataResponseFactory;

    /**
     * Data constructor.
     * @param \Magento\Framework\View\Result\PageFactory $dataResponseFactory
     */
    public function __construct(\Magento\Framework\View\Result\PageFactory $dataResponseFactory)
    {
        $this->dataResponseFactory = $dataResponseFactory;
    }

    /**
     * @return DataResponse
     */
    public function execute(): DataResponse
    {
        return $this->dataResponseFactory->create();
    }
}
