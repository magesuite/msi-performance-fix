<?php

namespace MageSuite\MsiPerformanceFix\Preference\Magento\InventoryConfiguration\Plugin\InventoryConfiguration\Model;

use Magento\CatalogInventory\Api\Data\StockItemInterface;
use Magento\InventoryConfiguration\Model\GetLegacyStockItem;

/**
 * Caching plugin for GetLegacyStockItem service.
 */
class GetLegacyStockItemCache
{
    /**
     * @var array
     */
    private $legacyStockItemsBySku = [];
    /**
     * Cache the result of service to avoid duplicate queries to the database.
     *
     * @param GetLegacyStockItem $subject
     * @param callable $proceed
     * @param string $sku
     * @return StockItemInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundExecute(GetLegacyStockItem $subject, callable $proceed, string $sku): StockItemInterface
    {
        if (!isset($this->legacyStockItemsBySku[$sku])) {
            $this->legacyStockItemsBySku[$sku] = $proceed($sku);
        }
        return $this->legacyStockItemsBySku[$sku];
    }
}
