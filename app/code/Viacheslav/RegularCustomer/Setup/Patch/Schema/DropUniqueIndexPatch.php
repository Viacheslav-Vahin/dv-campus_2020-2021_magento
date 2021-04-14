<?php
declare(strict_types=1);

namespace Viacheslav\RegularCustomer\Setup\Patch\Schema;

class DropUniqueIndexPatch implements \Magento\Framework\Setup\Patch\SchemaPatchInterface
{
    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface $schemaSetup
     */
    private $schemaSetup;
    /**
     * @var \Magento\Framework\App\DeploymentConfig
     */
    private $deploymentConfig;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup
     * @param \Magento\Framework\App\DeploymentConfig $deploymentConfig
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->schemaSetup = $schemaSetup;
        $this->deploymentConfig = $deploymentConfig;
        $this->logger = $logger;
    }

    /**
     * @return string
     */
    public function getIndexName(): string
    {
        $configData = $this->deploymentConfig->getConfigData('db');
        $dbName = $configData['connection']['default']['dbname'];

        $indexList = $this->schemaSetup->getConnection()->getIndexList(
            $this->schemaSetup->getTable('viacheslav_regular_customer'),
            $dbName
        );

        $columnItem = 'email';
        $columnItemTwo = 'website_id';

        $name = '';

        foreach ($indexList as $indexItem) {
            if (in_array($columnItem, $indexItem['COLUMNS_LIST'], true)
                && in_array($columnItemTwo, $indexItem['COLUMNS_LIST'], true)) {
                $name = $indexItem['KEY_NAME'];
            }
        }
        return $name;
    }

    /**
     * @inheritDoc
     */
    public function apply(): void
    {
        $configData = $this->deploymentConfig->getConfigData('db');
        $dbName = $configData['connection']['default']['dbname'];

        if ($this->getIndexName() !== '') {
            $this->schemaSetup->getConnection()
                ->dropIndex(
                    $this->schemaSetup->getTable('viacheslav_regular_customer'),
                    $this->getIndexName(),
                    $dbName
                );
        } else {
            $this->logger->info('Index not found');
        }
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
