<?php
declare(strict_types=1);

namespace Viacheslav\RegularCustomer\Controller\LoyaltyProgram;

use Magento\Framework\Controller\Result\Json as JsonResponse;

class ProductList implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     */
    private $jsonResponseFactory;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * Controller constructor.
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonResponseFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->jsonResponseFactory = $jsonResponseFactory;
        $this->customerSession = $customerSession;
        $this->request = $request;
    }

    /***
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        $response = $this->jsonResponseFactory->create();
        $productList = $this->customerSession->getData('product_list');
        $currentProductId = $this->request->getParam('productId');

        $result = $productList && in_array($currentProductId, $productList, true);

        return $response->setData([
            'result' => $result
        ]);
    }
}
