<?php
declare(strict_types=1);

namespace Viacheslav\RegularCustomer\Controller\LoyaltyProgram;

use Magento\Framework\Controller\Result\Json as JsonResponse;
use Viacheslav\RegularCustomer\Model\DiscountRequest;

class Registration implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    private \Magento\Framework\Controller\Result\JsonFactory $jsonFactory;

    private \Magento\Framework\App\RequestInterface $request;

    private \Viacheslav\RegularCustomer\Model\DiscountRequestFactory $discountRequestFactory;

    private \Magento\Customer\Model\Session $customerSession;

    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    private \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest $discountRequestResource;

    private \Psr\Log\LoggerInterface $logger;

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

            $productId = (int)$this->request->getParam('productId');

            if (!$this->customerSession->isLoggedIn()) {
                $this->customerSession->setGuestName($this->request->getParam('name'));
                $this->customerSession->setGuestEmail($this->request->getParam('email'));

                $sessionProductList = (array)$this->customerSession->getData('product_list');
                $sessionProductList[] = $productId;
                $this->customerSession->setProductList($sessionProductList);
            }

            $customerId = $this->customerSession->getCustomerId()
                ? (int)$this->customerSession->getCustomerId()
                : null;

            $discountRequest->setProductId($productId)
                ->setName($this->request->getParam('name'))
                ->setEmail($this->request->getParam('email'))
                ->setCustomerId($customerId)
                ->setWebsiteId($this->storeManager->getStore()->getWebsiteId())
                ->setStatus(DiscountRequest::STATUS_PENDING);
            $this->discountRequestResource->save($discountRequest);
            $message = __('You request for registration in loyalty program was accepted! Your discount will be available after admin verification');
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $message = __('Your request can\'t be sent. Please, contact us if you see this message.');
        }

        return $response->setData([
            'message' => $message
        ]);
    }
}
