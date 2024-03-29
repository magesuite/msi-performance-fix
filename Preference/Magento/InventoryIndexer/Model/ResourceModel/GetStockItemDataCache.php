<?php

namespace MageSuite\MsiPerformanceFix\Preference\Magento\InventoryIndexer\Model\ResourceModel;

use Magento\InventoryIndexer\Model\ResourceModel\GetStockItemData;
use Magento\InventorySalesApi\Model\GetStockItemDataInterface;

/**
 * @inheritdoc
 */
class GetStockItemDataCache implements GetStockItemDataInterface
{
    /**
     * @var GetStockItemData
     */
    private $getStockItemData;
    /**
     * @var array
     */
    private $stockItemData = [[]];
    /**
     * @param GetStockItemData $getStockItemData
     */
    public function __construct(
        GetStockItemData $getStockItemData
    ) {
        $this->getStockItemData = $getStockItemData;
    }
    /**
     * @inheritdoc
     */
    public function execute(string $sku, int $stockId): ?array
    {
        if (!isset($this->stockItemData[$stockId][$sku])) {
            $this->stockItemData[$stockId][$sku] = $this->getStockItemData->execute($sku, $stockId);
        }
        return $this->stockItemData[$stockId][$sku];
    }
}
