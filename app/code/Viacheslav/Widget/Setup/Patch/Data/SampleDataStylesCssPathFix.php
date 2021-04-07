<?php

declare(strict_types=1);

namespace Viacheslav\Widget\Setup\Patch\Data;

class SampleDataStylesCssPathFix implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    private $scopeConfig;

    /**
     * @var \Magento\Config\Model\ResourceModel\Config $configResource
     */
    private $configResource;

    /**
     * SampleDataStylesCssPathFix constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Config\Model\ResourceModel\Config $configResource
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Config\Model\ResourceModel\Config $configResource
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->configResource = $configResource;
    }

    /**
     * @inheritDoc
     */
    public function apply(): void
    {
        $config = $this->scopeConfig->getValue('design/head/includes');
        $pattern = '{{MEDIA_URL}}';

        if (strpos($config, $pattern) !== false) {
            $config = str_replace($pattern, '/media/', $config);
        }

        $this->configResource->saveConfig('design/head/includes', $config);
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases(): array
    {
        return [];
    }
}
