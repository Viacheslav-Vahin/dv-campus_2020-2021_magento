<?php
declare(strict_types=1);

namespace Viacheslav\RegularCustomer\CustomerData;

use Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;

class DiscountRequests implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory
     */
    private $collectionFactory;

    /**
     * DiscountRequests constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory $collectionFactory
    ) {

        $this->customerSession = $customerSession;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function getSectionData()
    {
        if ($this->customerSession->isLoggedIn()) {
            $customerName = $this->customerSession->getCustomer()->getName();
            $customerEmail = $this->customerSession->getCustomer()->getEmail();
            $customerId = $this->customerSession->getCustomerId();

            /** @var DiscountRequestCollection $collection */
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('customer_id', $customerId);
            $productList = array_map('intval', $collection->getColumnValues('product_id'));
        } else {
            $customerName = $this->customerSession->getGuestName();
            $customerEmail = $this->customerSession->getGuestEmail();
            $productList = $this->customerSession->getProductList();
        }

        return [
            'name' => $customerName,
            'email' => $customerEmail,
            'productList' => $productList
        ];
    }
}
