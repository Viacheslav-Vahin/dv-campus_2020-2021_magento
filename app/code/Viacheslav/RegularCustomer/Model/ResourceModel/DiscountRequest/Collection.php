<?php

declare(strict_types=1);

namespace Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(
            \Viacheslav\RegularCustomer\Model\DiscountRequest::class,
            \Viacheslav\RegularCustomer\Model\ResourceModel\DiscountRequest::class
        );
    }
}
