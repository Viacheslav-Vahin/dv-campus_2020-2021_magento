<?php

declare(strict_types=1);

namespace Viacheslav\RegularCustomer\Block;

use Viacheslav\RegularCustomer\Model\DiscountRequest;
use Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;
use Magento\Framework\Phrase;

class DiscountInfo extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactorys
     */
    private $collectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    private $storeManager;

    /**
     * PersonalDiscountInfo constructor.
     * @param \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @return DiscountRequest|null
     */
    public function getPersonalDiscount(): ?DiscountRequest
    {
        /** @var DiscountRequestCollection $collection */
        $collection = $this->collectionFactory->create();
        // @TODO: get current customer's ID
        $collection->addFieldToFilter('email', 'john-doe@example.com');
        // @TODO: check if accounts are shared or not
        $collection->addFieldToFilter('website_id', $this->storeManager->getStore()->getWebsiteId());
        /** @var DiscountRequest $discountRequest */
        $discountRequest = $collection->getFirstItem();

        return $discountRequest->getRequestId() ? $discountRequest : null;
    }

    /**
     * @param DiscountRequest $discountRequest
     * @return Phrase
     */
    public function getStatusMessage(DiscountRequest $discountRequest): Phrase
    {
        switch ($discountRequest->getStatus()) {
            case DiscountRequest::STATUS_PENDING:
                return __('pending');
            case DiscountRequest::STATUS_APPROVED:
                return __('approved');
            case DiscountRequest::STATUS_DECLINED:
            default:
                return __('declined');
        }
    }
}
