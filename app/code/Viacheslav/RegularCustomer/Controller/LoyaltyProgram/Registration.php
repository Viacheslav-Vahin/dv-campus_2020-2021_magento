<?php
declare(strict_types=1);

namespace Viacheslav\RegularCustomer\Controller\LoyaltyProgram;

use Magento\Framework\Controller\Result\Json as JsonResponse;
use Viacheslav\RegularCustomer\Model\DiscountRequest;

class Registration implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private \Magento\Framework\Controller\Result\JsonFactory $jsonFactory;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private \Magento\Framework\App\RequestInterface $request;

    /**
     * @var \Viacheslav\RegularCustomer\Model\DiscountRequestFactory
     */
    private \Viacheslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private \Magento\Customer\Model\Session $customerSession;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    /**
     * @var \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest
     */
    private \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private \Psr\Log\LoggerInterface $logger;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator;

    /**
     * Controller constructor.
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Viacheslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Framework\App\RequestInterface $request,
        \Viacheslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
    )
    {
        $this->jsonFactory = $jsonFactory;
        $this->request = $request;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->discountRequestResource = $discountRequestResource;
        $this->logger = $logger;
        $this->formKeyValidator = $formKeyValidator;
    }

    /**
     * @return JsonResponse
     */
    public function execute(): JsonResponse
    {
        $response = $this->jsonFactory->create();
        try {
            if (!$this->formKeyValidator->validate($this->request)) {
                throw new \InvalidArgumentException('Form key is not valid');
            }

            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();

            if ($this->customerSession->isLoggedIn()) {
                $productId = $this->request->getParam('productId');
                $sessionProductList = (array)$this->customerSession->getData('product_list');
                $sessionProductList[] = $productId;
                $this->customerSession->setProductList($sessionProductList);
                $discountRequest->setName($this->customerSession->getCustomer()->getName())
                    ->setEmail($this->customerSession->getCustomerData()->getEmail())
                    ->setMessage($this->request->getParam('message'))
                    ->setCustomerId($this->customerSession->getCustomerId())
                    ->setWebsiteId($this->storeManager->getStore()->getWebsiteId())
                    ->setStatus(DiscountRequest::STATUS_PENDING);
                $this->discountRequestResource->save($discountRequest);
                $message = __('You request for registration in loyalty program was accepted! Your discount will be available after admin verification');
            } else {
                $message = __('Please, sign in or sign up');
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $message = __('Your request can\'t be sent. Please, contact us if you see this message.');
        }

        return $response->setData([
            'message' => $message
        ]);
    }
}
