<?php

declare(strict_types=1);

namespace Viacheslav\RegularCustomer\Controller\Index;

use Magento\Framework\Controller\Result\Json as JsonResponse;

class Request implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    private $request;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     */
    private $jsonResponseFactory;

    /**
     * Controller constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
    )
    {
        $this->request = $request;
        $this->jsonResponseFactory = $jsonResponseFactory;
    }

    /**
     * https://viacheslav-vahin-develop.loc/viacheslav_discount_regular_customer/index/request
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        $response = $this->jsonResponseFactory->create();
        $response->setData([
            'message' => __('You request for product %1 was accepted!', $this->request->getParam('productName'))
        ]);

        return $response;
    }
}
