<?php

declare(strict_types=1);

namespace Viacheslav\RegularCustomer\Controller\Index;

use Magento\Framework\Controller\Result\Json as JsonResponse;
use Viacheslav\RegularCustomer\Model\DiscountRequest;

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
     * @var \Viacheslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     */
    private $discountRequestFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * @var \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     */
    private $discountRequestResource;

    /**
     * @var \Psr\Log\LoggerInterface $logger
     */
    private $logger;

    /**
     * Controller constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     * @param \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Viacheslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory,
        \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Viacheslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->request = $request;
        $this->jsonResponseFactory = $jsonResponseFactory;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->discountRequestResource = $discountRequestResource;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    /**
     * https://viacheslav-vahin-develop.loc/viacheslav_discount_regular_customer/index/request
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        $response = $this->jsonResponseFactory->create();
        // @TODO: pass message via notifications, not alert
        // @TODO: add form key validation and hideIt validation
        // @TODO: add Google Recaptcha to the form

        try {
            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            $discountRequest->setName($this->request->getParam('name'))
                ->setEmail($this->request->getParam('email'))
                ->setMessage($this->request->getParam('email'))
                ->setWebsiteId($this->storeManager->getStore()->getWebsiteId())
                ->setStatus($this->request->getParam('email'));
            $this->discountRequestResource->save($discountRequest);
            $message = __('You request for product %1 was accepted!', $this->request->getParam('productName'));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $message = __('Your request can\'t be sent. Please, contact us if you see this message.');
        }

        return $response->setData([
            'message' => $message
        ]);
    }
}
